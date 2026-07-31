<?php

namespace App\Services;

use App\Mail\OtpCodeMail;
use App\Models\CreditApplication;
use App\Models\OtpVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class OtpService
{
    public function send(CreditApplication $application): string
    {
        if (! $application->email) {
            throw new UnprocessableEntityHttpException('Renseignez votre e-mail avant de demander un code.');
        }

        $latest = $application->latestOtp;
        if ($latest && $latest->sent_at->diffInSeconds(now()) < config('credit.otp.resend_cooldown_seconds')) {
            throw new TooManyRequestsHttpException(
                config('credit.otp.resend_cooldown_seconds'),
                'Veuillez patienter avant de renvoyer un code.',
            );
        }

        $code = str_pad((string) random_int(0, 999999), config('credit.otp.length'), '0', STR_PAD_LEFT);

        OtpVerification::query()->create([
            'credit_application_id' => $application->id,
            'code_hash' => Hash::make($code),
            'expires_at' => now()->addMinutes(config('credit.otp.expires_minutes')),
            'sent_at' => now(),
        ]);

        try {
            Mail::to($application->email)->send(new OtpCodeMail($application, $code));
        } catch (\Throwable $e) {
            Log::error('OTP Mail send failed: ' . $e->getMessage());
        }

        Log::info('OTP envoyé pour le dossier '.$application->reference, [
            'email' => $application->email,
            'code' => $code,
        ]);

        return $code;
    }

    public function verify(CreditApplication $application, string $code): void
    {
        $otp = $application->latestOtp;

        if (! $otp) {
            throw new UnprocessableEntityHttpException('Aucun code actif. Demandez un nouveau code.');
        }

        if ($otp->isExpired()) {
            throw new UnprocessableEntityHttpException('Ce code a expiré. Demandez un nouveau code.');
        }

        if ($otp->attempts >= config('credit.otp.max_attempts')) {
            throw new UnprocessableEntityHttpException('Nombre maximal de tentatives atteint.');
        }

        $otp->increment('attempts');

        if (! Hash::check($code, $otp->code_hash)) {
            throw new UnprocessableEntityHttpException('Code incorrect.');
        }

        $application->otp_verified_at = now();
        $application->save();
    }
}

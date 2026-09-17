@component('mail::message')

<div style="background-color: #F7F2FF; padding: 1.75rem 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; border: 1px solid #ECE0FF; text-align: center;">
    <p style="margin: 0 0 8px 0; color: #4A00C4; font-size: 11px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase;">
        Accord de principe
    </p>
    <h1 style="font-size: 1.5rem; font-weight: 800; color: #0F172A; margin: 0 0 0.5rem 0;">
        Votre prêt est approuvé
    </h1>
    <p style="color: #475569; margin: 0; font-size: 0.95rem;">
        Dossier <strong style="color:#0F172A;">{{ $application->reference }}</strong>
    </p>
</div>

<div style="background-color: #ffffff; padding: 0.25rem 0;">
@if($customMessage)
{!! Illuminate\Mail\Markdown::parse($customMessage) !!}
@else
<p style="margin: 0 0 16px 0; color: #334155; font-size: 15px; line-height: 1.65;">
    Bonjour <strong style="color:#0F172A;">{{ $application->prenom }} {{ $application->nom }}</strong>,
</p>

<p style="margin: 0 0 16px 0; color: #334155; font-size: 15px; line-height: 1.65;">
    Nous avons le plaisir de vous informer que votre demande de financement a été <strong style="color:#0F172A;">examinée et approuvée</strong> par notre comité d'engagement.
</p>

<p style="margin: 0 0 20px 0; color: #334155; font-size: 15px; line-height: 1.65;">
    Vous trouverez en pièce jointe votre <strong style="color:#0F172A;">Offre de Contrat de Prêt</strong>, précisant l'ensemble des modalités financières de votre dossier.
</p>

<p style="margin: 0 0 10px 0; color: #0F172A; font-size: 13px; font-weight: 700;">
    Prochaines étapes :
</p>
<table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; margin-bottom: 4px;">
    <tr>
        <td style="padding: 4px 0; color: #334155; font-size: 14px; line-height: 1.6; vertical-align: top; width: 22px;">1.</td>
        <td style="padding: 4px 0; color: #334155; font-size: 14px; line-height: 1.6;">Prenez connaissance du contrat ci-joint.</td>
    </tr>
    <tr>
        <td style="padding: 4px 0; color: #334155; font-size: 14px; line-height: 1.6; vertical-align: top;">2.</td>
        <td style="padding: 4px 0; color: #334155; font-size: 14px; line-height: 1.6;">Signez l'offre et retournez-la à notre équipe.</td>
    </tr>
    <tr>
        <td style="padding: 4px 0; color: #334155; font-size: 14px; line-height: 1.6; vertical-align: top;">3.</td>
        <td style="padding: 4px 0; color: #334155; font-size: 14px; line-height: 1.6;">Le déblocage des fonds sera effectué dès réception du contrat signé.</td>
    </tr>
</table>
@endif
</div>

{{-- Signature --}}
<table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; border-top: 1px solid #E2E8F0; margin-top: 1.5rem; padding-top: 1.25rem;">
    <tr>
        <td>
            <p style="margin: 0 0 2px 0; color: #0F172A; font-size: 15px; font-weight: 700;">
                L'équipe {{ config('credit.brand') }}
            </p>
            <p style="margin: 0 0 10px 0; color: #64748B; font-size: 13px;">
                Service client
            </p>
            <p style="margin: 0; color: #64748B; font-size: 12px; line-height: 1.8;">
                <a href="tel:+33780961216" style="color: #0F172A; text-decoration: none; font-weight: 600;">+33 7 80 96 12 16</a>
                &nbsp;&middot;&nbsp;
                <a href="mailto:contacts@studcredit.com" style="color: #6200FE; text-decoration: none; font-weight: 500;">contacts@studcredit.com</a>
                &nbsp;&middot;&nbsp;
                <a href="https://studcredit.com" style="color: #6200FE; text-decoration: none; font-weight: 500;">studcredit.com</a>
            </p>
        </td>
    </tr>
</table>

@endcomponent

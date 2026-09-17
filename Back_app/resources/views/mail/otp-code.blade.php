<x-mail::message>

<p style="margin: 0 0 8px 0; color: #0F172A; font-size: 20px; font-weight: 700;">
    Bonjour{{ $application->prenom ? ' ' . $application->prenom : '' }},
</p>

<p style="margin: 0 0 28px 0; color: #64748B; font-size: 14px; line-height: 1.7;">
    Nous avons reçu une demande de vérification pour votre compte.
    Utilisez le code ci-dessous pour finaliser votre démarche.
    Ce code est strictement personnel et confidentiel.
</p>

{{-- Bloc OTP principal --}}
<table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #F7F2FF; border: 1px solid #ECE0FF; border-radius: 12px; margin-bottom: 24px;">
    <tr>
        <td style="padding: 30px 24px; text-align: center;">

            <p style="margin: 0 0 16px 0; color: #4A00C4; font-size: 11px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase;">
                Votre code de vérification
            </p>

            {{-- Chiffres du code OTP --}}
            <table cellpadding="0" cellspacing="0" role="presentation" style="margin: 0 auto 18px auto;">
                <tr>
                    @foreach (str_split($code) as $digit)
                    <td style="padding: 0 5px;">
                        <div style="width: 46px; height: 56px; background-color: #ffffff; border: 2px solid #6200FE; border-radius: 10px; text-align: center; line-height: 56px;">
                            <span style="color: #4A00C4; font-size: 26px; font-weight: 700; font-family: 'Courier New', Courier, monospace;">{{ $digit }}</span>
                        </div>
                    </td>
                    @endforeach
                </tr>
            </table>

            <p style="margin: 0; color: #6D28D9; font-size: 12px; letter-spacing: 0.2px;">
                Ne communiquez jamais ce code à quiconque
            </p>

        </td>
    </tr>
</table>

{{-- Expiration du code --}}
<table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; margin-bottom: 20px;">
    <tr>
        <td style="padding: 14px 18px;">
            <p style="margin: 0; color: #475569; font-size: 13px; line-height: 1.5;">
                Ce code expire dans
                <span style="color: #4A00C4; font-weight: 700;">{{ config('credit.otp.expires_minutes') }} minutes</span>.
                Passé ce délai, veuillez en demander un nouveau.
            </p>
        </td>
    </tr>
</table>

{{-- Conseils de sécurité --}}
<table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #FFF7ED; border: 1px solid #FED7AA; border-radius: 10px; margin-bottom: 20px;">
    <tr>
        <td style="padding: 18px 22px;">
            <p style="margin: 0 0 10px 0; color: #C2410C; font-size: 13px; font-weight: 700;">
                Conseils de sécurité
            </p>
            <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%;">
                <tr>
                    <td style="padding: 3px 0; color: #7C2D12; font-size: 13px; line-height: 1.5;">
                        — {{ config('credit.brand') }} ne vous demandera jamais ce code par téléphone ou SMS
                    </td>
                </tr>
                <tr>
                    <td style="padding: 3px 0; color: #7C2D12; font-size: 13px; line-height: 1.5;">
                        — Ne partagez ce code avec aucun tiers, même un agent du support
                    </td>
                </tr>
                <tr>
                    <td style="padding: 3px 0; color: #7C2D12; font-size: 13px; line-height: 1.5;">
                        — Vérifiez que vous êtes bien sur le site officiel studcredit.com
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

{{-- Message si non concerné --}}
<table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; margin-bottom: 28px;">
    <tr>
        <td style="padding: 16px 18px;">
            <p style="margin: 0; color: #64748B; font-size: 13px; line-height: 1.5;">
                Vous n'êtes pas à l'origine de cette demande ?
                Ignorez simplement cet email. Votre compte reste sécurisé et aucune action n'est nécessaire.
            </p>
        </td>
    </tr>
</table>

<p style="margin: 0; color: #94A3B8; font-size: 13px; text-align: center; padding-top: 20px; border-top: 1px solid #F1F5F9;">
    Un problème ? Contactez-nous à <a href="mailto:contacts@studcredit.com" style="color: #6200FE; text-decoration: none; font-weight: 600;">contacts@studcredit.com</a>
</p>

<x-slot:subcopy>
    Données traitées conformément au RGPD. Cet email automatique fait suite à une action initiée sur notre plateforme.
</x-slot:subcopy>

</x-mail::message>

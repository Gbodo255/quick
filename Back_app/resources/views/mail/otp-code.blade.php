<x-mail::message>
    {{-- ═══════════════════════════════════════════
         HEADER
    ═══════════════════════════════════════════ --}}
    <x-slot:header>
        <tr>
            <td style="padding: 0; margin: 0;">

                {{-- Bande supérieure de marque --}}
                <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #0A2240;">
                    <tr>
                        <td style="padding: 28px 40px 24px 40px;">
                            <table cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td style="vertical-align: middle; padding-right: 14px;">
                                        <div style="width: 40px; height: 40px; background-color: #7C3AED; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; text-align: center; line-height: 40px;">
                                            <span style="color: #ffffff; font-size: 20px; font-weight: 700; font-family: 'Courier New', monospace;">C</span>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <p style="margin: 0; color: #ffffff; font-size: 20px; font-weight: 700; letter-spacing: -0.3px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                                            {{ config('credit.brand') }}
                                        </p>
                            <p style="margin: 0; color: #C4B5FD; font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                                            Vérification sécurisée
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                {{-- Bandeau avertissement sécurité --}}
                <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #FFFBEB; border-bottom: 1px solid #FDE68A;">
                    <tr>
                        <td style="padding: 13px 40px;">
                            <table cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td style="vertical-align: middle; padding-right: 10px;">
                                        <div style="width: 8px; height: 8px; background-color: #C084FC; border-radius: 50%;"></div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <p style="margin: 0; color: #7C3AED; font-size: 13px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                                            Action de sécurité requise — Code de vérification
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </x-slot:header>

    {{-- ═══════════════════════════════════════════
         CORPS DU MESSAGE
    ═══════════════════════════════════════════ --}}

    {{-- Salutation --}}
    <p style="margin: 0 0 8px 0; color: #0A2240; font-size: 22px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
        Bonjour{{ $application->prenom ? ' ' . $application->prenom : '' }},
    </p>

    <p style="margin: 0 0 32px 0; color: #64748B; font-size: 14px; line-height: 1.7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
        Nous avons reçu une demande de vérification pour votre compte.
        Utilisez le code ci-dessous pour finaliser votre démarche.
        Ce code est strictement personnel et confidentiel.
    </p>

    {{-- Bloc OTP principal --}}
    <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #0A2240; border-radius: 12px; margin-bottom: 24px;">
        <tr>
            <td style="padding: 32px 24px; text-align: center;">

<p style="margin: 0 0 16px 0; color: #A78BFA; font-size: 10px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                    Votre code de vérification
                </p>

                {{-- Chiffres du code OTP --}}
                <table cellpadding="0" cellspacing="0" role="presentation" style="margin: 0 auto 16px auto;">
                    <tr>
                        @foreach (str_split($code) as $digit)
                        <td style="padding: 0 5px;">
                            <div style="width: 48px; height: 58px; background-color: #112D4E; border: 2px solid #7C3AED; border-radius: 10px; text-align: center; line-height: 58px;">
                                <span style="color: #C4B5FD; font-size: 26px; font-weight: 700; font-family: 'Courier New', Courier, monospace;">{{ $digit }}</span>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                </table>

                <p style="margin: 0; color: #A78BFA; font-size: 11px; letter-spacing: 0.3px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                    Ne communiquez jamais ce code à quiconque
                </p>

            </td>
        </tr>
    </table>

    {{-- Expiration du code --}}
    <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; margin-bottom: 24px;">
        <tr>
            <td style="padding: 14px 18px;">
                <p style="margin: 0; color: #475569; font-size: 13px; line-height: 1.5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                    ⏱️ Ce code expire dans
                    <span style="color: #6D28D9; font-weight: 700;">{{ config('credit.otp.expires_minutes') }} minutes</span>.
                    Passé ce délai, veuillez en demander un nouveau.
                </p>
            </td>
        </tr>
    </table>

    {{-- Conseils de sécurité --}}
    <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #FFF7ED; border: 1px solid #FED7AA; border-radius: 10px; margin-bottom: 24px;">
        <tr>
            <td style="padding: 20px 24px;">
                <p style="margin: 0 0 12px 0; color: #C2410C; font-size: 13px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                    ⚠️ Conseils de sécurité
                </p>
                <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%;">
                    <tr>
                        <td style="padding: 4px 0; color: #7C2D12; font-size: 13px; line-height: 1.5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                            — {{ config('credit.brand') }} ne vous demandera jamais ce code par téléphone ou SMS
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #7C2D12; font-size: 13px; line-height: 1.5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                            — Ne partagez ce code avec aucun tiers, même un agent du support
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 4px 0; color: #7C2D12; font-size: 13px; line-height: 1.5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                            — Vérifiez que vous êtes bien sur le site officiel crediteco.app
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Message si non concerné --}}
    <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; margin-bottom: 32px;">
        <tr>
            <td style="padding: 16px 18px;">
                <p style="margin: 0; color: #64748B; font-size: 13px; line-height: 1.5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                    ℹ️ Vous n'êtes pas à l'origine de cette demande ?
                    Ignorez simplement cet email. Votre compte reste sécurisé et aucune action n'est nécessaire.
                </p>
            </td>
        </tr>
    </table>

    {{-- Note de contact --}}
    <p style="margin: 0; color: #94A3B8; font-size: 13px; text-align: center; padding-top: 24px; border-top: 1px solid #F1F5F9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
        Un problème ? Contactez-nous à <a href="mailto:support@crediteco.app" style="color: #7C3AED; text-decoration: none; font-weight: 600;">support@crediteco.app</a>
    </p>

    {{-- ═══════════════════════════════════════════
         FOOTER
    ═══════════════════════════════════════════ --}}
    <x-slot:footer>
        <tr>
            <td style="padding: 0;">
                <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #0A2240;">
                    <tr>
                        <td style="padding: 32px 40px 24px 40px;">

                            {{-- Colonnes contact / horaires --}}
                            <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; margin-bottom: 24px;">
                                <tr>
                                    <td style="vertical-align: top; width: 50%;">
                                        <p style="margin: 0; color: #A78BFA; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">Contact</p>
                                        <p style="margin: 0; color: #C4B5FD; font-size: 12px; line-height: 1.8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                                            📧 <a href="mailto:support@crediteco.app" style="color: #C4B5FD; text-decoration: none;">support@crediteco.app</a><br>
                                            🌐 <a href="https://crediteco.app" style="color: #C4B5FD; text-decoration: none;">crediteco.app</a>
                                        </p>
                                    </td>
                                    <td style="vertical-align: top; width: 50%; padding-left: 24px;">
                                        <p style="margin: 0 0 10px 0; color: #A78BFA; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">Horaires</p>
                                        <p style="margin: 0; color: #C4B5FD; font-size: 12px; line-height: 1.8; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                                            Lun – Ven<br>9h00 – 18h00
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            {{-- Ligne de séparation --}}
                            <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; border-top: 1px solid #1E3A5F; margin-bottom: 16px;">
                                <tr><td style="padding: 0; font-size: 0; line-height: 0;">&nbsp;</td></tr>
                            </table>

                            {{-- Mentions légales --}}
                            <p style="margin: 16px 0 0 0; color: #A78BFA; font-size: 11px; text-align: center; line-height: 1.7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                                Données traitées conformément au RGPD · © {{ date('Y') }} {{ config('credit.brand') }} · Tous droits réservés<br>
                                Cet email automatique fait suite à une action initiée sur notre plateforme.
                            </p>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </x-slot:footer>

</x-mail::message>

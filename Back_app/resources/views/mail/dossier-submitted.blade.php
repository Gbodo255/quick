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
                                        <p style="margin: 3px 0 0 0; color: #C4B5FD; font-size: 10px; letter-spacing: 1.5px; text-transform: uppercase; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                                            Plateforme de crédit simplifié
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                {{-- Bandeau coloré de statut --}}
                <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #F5F3FF; border-bottom: 1px solid #DDD6FE;">
                    <tr>
                        <td style="padding: 13px 40px;">
                            <table cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td style="vertical-align: middle; padding-right: 10px;">
                                        <div style="width: 8px; height: 8px; background-color: #C4B5FD; border-radius: 50%;"></div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <p style="margin: 0; color: #6D28D9; font-size: 13px; font-weight: 600; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                                            Dossier reçu et en cours d'analyse
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
        Bonjour {{ $application->prenom }} {{ $application->nom }},
    </p>

    <p style="margin: 0 0 32px 0; color: #64748B; font-size: 14px; line-height: 1.7; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
        Nous confirmons la bonne réception de votre demande de crédit.
        Notre équipe d'analystes examine actuellement votre dossier et vous contactera dans les plus brefs délais.
    </p>

    {{-- Bloc référence --}}
    <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #F8F4FF; border: 1px solid #DDD6FE; border-radius: 10px; margin-bottom: 28px;">
        <tr>
            <td style="padding: 20px 24px;">
                <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%;">
                    <tr>
                        <td style="vertical-align: middle;">
                            <p style="margin: 0 0 6px 0; color: #7C3AED; font-size: 10px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                                Référence du dossier
                            </p>
                            <p style="margin: 0; color: #6D28D9; font-size: 22px; font-weight: 700; letter-spacing: 3px; font-family: 'Courier New', Courier, monospace;">
                                {{ $application->reference }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Titre section détails --}}
    <p style="margin: 0 0 12px 0; color: #94A3B8; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
        Détails de votre demande
    </p>

    {{-- Tableau des détails --}}
    <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; border-collapse: collapse; border: 1px solid #E2E8F0; border-radius: 8px; margin-bottom: 28px; overflow: hidden;">
        <tr>
            <td style="padding: 13px 16px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; color: #64748B; font-size: 13px; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; width: 55%;">
                Montant demandé
            </td>
            <td style="padding: 13px 16px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; color: #7C3AED; font-size: 15px; font-weight: 700; text-align: right; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                {{ number_format($application->montant, 0, ',', ' ') }} €
            </td>
        </tr>
        <tr>
            <td style="padding: 13px 16px; background-color: #ffffff; border-bottom: 1px solid #E2E8F0; color: #64748B; font-size: 13px; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                Durée de remboursement
            </td>
            <td style="padding: 13px 16px; background-color: #ffffff; border-bottom: 1px solid #E2E8F0; color: #0A2240; font-size: 13px; font-weight: 700; text-align: right; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                {{ $application->duree_mois }} mois
            </td>
        </tr>
        <tr>
            <td style="padding: 13px 16px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; color: #64748B; font-size: 13px; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                Mensualité estimée
            </td>
            <td style="padding: 13px 16px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; color: #0A2240; font-size: 13px; font-weight: 700; text-align: right; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                {{ number_format($application->mensualite, 2, ',', ' ') }} €
            </td>
        </tr>
        <tr>
            <td style="padding: 13px 16px; background-color: #ffffff; color: #64748B; font-size: 13px; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                Taux annuel effectif global
            </td>
            <td style="padding: 13px 16px; background-color: #ffffff; color: #0A2240; font-size: 13px; font-weight: 700; text-align: right; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                {{ $application->taux_annuel }} %
            </td>
        </tr>
    </table>

    {{-- Prochaines étapes --}}
    <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #FAFAFA; border: 1px solid #E2E8F0; border-radius: 10px; margin-bottom: 24px;">
        <tr>
            <td style="padding: 20px 24px;">
                <p style="margin: 0 0 14px 0; color: #94A3B8; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                    Prochaines étapes
                </p>
                <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%;">
                    <tr>
                        <td style="vertical-align: top; padding-right: 12px; padding-bottom: 12px; width: 28px;">
                            <div style="width: 22px; height: 22px; background-color: #7C3AED; border-radius: 50%; text-align: center; line-height: 22px;">
                                <span style="color: #ffffff; font-size: 11px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">1</span>
                            </div>
                        </td>
                        <td style="vertical-align: top; padding-bottom: 12px;">
                            <p style="margin: 0; color: #475569; font-size: 13px; line-height: 1.6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                                <span style="color: #0A2240; font-weight: 700;">Analyse du dossier</span> — Notre équipe examine vos informations sous 24 à 48h.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-right: 12px; padding-bottom: 12px; width: 28px;">
                            <div style="width: 22px; height: 22px; background-color: #7C3AED; border-radius: 50%; text-align: center; line-height: 22px;">
                                <span style="color: #ffffff; font-size: 11px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">2</span>
                            </div>
                        </td>
                        <td style="vertical-align: top; padding-bottom: 12px;">
                            <p style="margin: 0; color: #475569; font-size: 13px; line-height: 1.6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                                <span style="color: #0A2240; font-weight: 700;">Décision de principe</span> — Vous recevrez une réponse par email avec notre décision.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align: top; padding-right: 12px; width: 28px;">
                            <div style="width: 22px; height: 22px; background-color: #7C3AED; border-radius: 50%; text-align: center; line-height: 22px;">
                                <span style="color: #ffffff; font-size: 11px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">3</span>
                            </div>
                        </td>
                        <td style="vertical-align: top;">
                            <p style="margin: 0; color: #475569; font-size: 13px; line-height: 1.6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                                <span style="color: #0A2240; font-weight: 700;">Signature du contrat</span> — En cas d'accord, procédure de signature électronique sécurisée.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Pièce jointe --}}
    <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #F5F3FF; border: 1px solid #DDD6FE; border-radius: 8px; margin-bottom: 32px;">
        <tr>
            <td style="padding: 14px 18px;">
                <p style="margin: 0; color: #6D28D9; font-size: 13px; line-height: 1.5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
                    📎 <span style="font-weight: 700;">Pièce jointe :</span>
                    Le récapitulatif PDF complet de votre dossier est joint à cet email pour vos archives.
                </p>
            </td>
        </tr>
    </table>

    {{-- Note de contact --}}
    <p style="margin: 0; color: #94A3B8; font-size: 13px; text-align: center; padding-top: 24px; border-top: 1px solid #F1F5F9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
        Une question ? Contactez-nous à <a href="mailto:support@crediteco.app" style="color: #7C3AED; text-decoration: none; font-weight: 600;">support@crediteco.app</a>
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

                            {{-- Colonne contact / horaires --}}
                            <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; margin-bottom: 24px;">
                                <tr>
                                    <td style="vertical-align: top; width: 50%;">
                                        <p style="margin: 0 0 10px 0; color: #A78BFA; font-size: 10px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">Contact</p>
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
                                Vous recevez cet email car vous avez soumis une demande de crédit sur notre plateforme.
                            </p>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </x-slot:footer>

</x-mail::message>

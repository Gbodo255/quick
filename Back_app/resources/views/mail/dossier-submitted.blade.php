<x-mail::message>
    {{-- ═══════════════════════════════════════════
         HEADER MATCHING SITE BRAND LOGO
    ═══════════════════════════════════════════ --}}
    <x-slot:header>
        <tr>
            <td style="padding: 0; margin: 0;">
                <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #0A2240;">
                    <tr>
                        <td style="padding: 24px 32px; text-align: left;">
                            <table cellpadding="0" cellspacing="0" role="presentation">
                                <tr>
                                    <td style="vertical-align: middle; padding-right: 12px;">
                                        <div style="width: 38px; height: 38px; background-color: #1E293B; border-radius: 8px; text-align: center; line-height: 38px;">
                                            <span style="color: #60A5FA; font-size: 20px; font-family: -apple-system, sans-serif;">🏛️</span>
                                        </div>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <p style="margin: 0; color: #ffffff; font-size: 22px; font-weight: 800; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; letter-spacing: -0.5px;">
                                            Quick<span style="color: #60A5FA;">credit</span>
                                        </p>
                                        <p style="margin: 2px 0 0 0; color: #93C5FD; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                            Courtage &amp; Financement
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                {{-- Bandeau de statut épuré --}}
                <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0;">
                    <tr>
                        <td style="padding: 12px 32px;">
                            <p style="margin: 0; color: #2563EB; font-size: 12px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                🔵 Demande reçue · En cours d'analyse
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </x-slot:header>

    {{-- ═══════════════════════════════════════════
         CORPS DU MESSAGE
    ═══════════════════════════════════════════ --}}
    <div style="padding: 12px 4px 4px 4px;">

        {{-- Salutation --}}
        <p style="margin: 0 0 12px 0; color: #0F172A; font-size: 20px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            Bonjour {{ $application->prenom }} {{ $application->nom }},
        </p>

        <p style="margin: 0 0 24px 0; color: #475569; font-size: 14px; line-height: 1.6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            Nous avons bien reçu votre demande de prêt. Votre dossier a été transmis à notre équipe d'analyse et est actuellement en cours de traitement.
        </p>

        {{-- Encadré Référence --}}
        <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; margin-bottom: 24px;">
            <tr>
                <td style="padding: 16px 20px;">
                    <p style="margin: 0 0 4px 0; color: #64748B; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        Référence de dossier
                    </p>
                    <p style="margin: 0; color: #1E293B; font-size: 20px; font-weight: 800; font-family: 'Courier New', Courier, monospace; letter-spacing: 1px;">
                        {{ $application->reference }}
                    </p>
                </td>
            </tr>
        </table>

        {{-- Tableau récapitulatif --}}
        <p style="margin: 0 0 10px 0; color: #0F172A; font-size: 13px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            Récapitulatif de votre demande :
        </p>

        <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; border-collapse: collapse; border: 1px solid #E2E8F0; border-radius: 8px; overflow: hidden; margin-bottom: 24px;">
            <tr>
                <td style="padding: 11px 16px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; color: #475569; font-size: 13px; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; width: 50%;">
                    Montant souhaité
                </td>
                <td style="padding: 11px 16px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; color: #0F172A; font-size: 14px; font-weight: 700; text-align: right; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    {{ number_format($application->montant, 0, ',', ' ') }} €
                </td>
            </tr>
            <tr>
                <td style="padding: 11px 16px; background-color: #ffffff; border-bottom: 1px solid #E2E8F0; color: #475569; font-size: 13px; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    Durée de remboursement
                </td>
                <td style="padding: 11px 16px; background-color: #ffffff; border-bottom: 1px solid #E2E8F0; color: #0F172A; font-size: 13px; font-weight: 600; text-align: right; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    {{ $application->duree_mois }} mois
                </td>
            </tr>
            <tr>
                <td style="padding: 11px 16px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; color: #475569; font-size: 13px; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    Mensualité estimée
                </td>
                <td style="padding: 11px 16px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; color: #0F172A; font-size: 13px; font-weight: 600; text-align: right; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    {{ number_format($application->mensualite, 2, ',', ' ') }} €
                </td>
            </tr>
            <tr>
                <td style="padding: 11px 16px; background-color: #ffffff; color: #475569; font-size: 13px; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    TAEG fixe
                </td>
                <td style="padding: 11px 16px; background-color: #ffffff; color: #0F172A; font-size: 13px; font-weight: 600; text-align: right; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    {{ $application->taux_annuel }} %
                </td>
            </tr>
        </table>

        {{-- Note de confirmation --}}
        <p style="margin: 0 0 24px 0; color: #475569; font-size: 13px; line-height: 1.6; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
            Vous trouverez également en pièce jointe le récapitulatif complet de votre demande au format PDF.
        </p>

        {{-- Signature du courtier avec le badge logo du site --}}
        <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; border-top: 1px solid #E2E8F0; padding-top: 20px; margin-top: 24px;">
            <tr>
                <td style="vertical-align: top; width: 52px; padding-right: 14px;">
                    <div style="width: 42px; height: 42px; background-color: #0A2240; border-radius: 10px; text-align: center; line-height: 42px;">
                        <span style="color: #60A5FA; font-size: 20px; font-family: -apple-system, sans-serif;">🏛️</span>
                    </div>
                </td>
                <td style="vertical-align: top;">
                    <p style="margin: 0 0 2px 0; color: #0F172A; font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        Julien Verran
                    </p>
                    <p style="margin: 0 0 6px 0; color: #475569; font-size: 13px; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        Courtier en crédit immobilier
                    </p>
                    <p style="margin: 0 0 3px 0; color: #64748B; font-size: 12px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        📞 <a href="tel:+33780961216" style="color: #0F172A; text-decoration: none; font-weight: 600;">+33 7 80 96 12 16</a>
                    </p>
                    <p style="margin: 0 0 3px 0; color: #64748B; font-size: 12px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        ✉️ <a href="mailto:support@crediteco.app" style="color: #2563EB; text-decoration: none; font-weight: 500;">support@crediteco.app</a>
                    </p>
                    <p style="margin: 0; color: #64748B; font-size: 12px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                        🌐 <a href="https://crediteco.app" style="color: #2563EB; text-decoration: none; font-weight: 500;">crediteco.app</a>
                    </p>
                </td>
            </tr>
        </table>

    </div>

    {{-- ═══════════════════════════════════════════
         FOOTER
    ═══════════════════════════════════════════ --}}
    <x-slot:footer>
        <tr>
            <td style="padding: 0;">
                <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #0A2240;">
                    <tr>
                        <td style="padding: 24px 32px; text-align: center;">
                            <p style="margin: 0 0 8px 0; color: #94A3B8; font-size: 12px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                📞 +33 7 80 96 12 16 · 📧 support@crediteco.app · 🌐 crediteco.app
                            </p>
                            <p style="margin: 0; color: #64748B; font-size: 11px; line-height: 1.5; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                                © {{ date('Y') }} Quickcredit · Données sécurisées conformément au RGPD
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </x-slot:footer>

</x-mail::message>

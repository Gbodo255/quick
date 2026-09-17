<x-mail::message>

{{-- Bandeau de statut --}}
<table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #F7F2FF; border: 1px solid #ECE0FF; border-radius: 8px; margin-bottom: 24px;">
    <tr>
        <td style="padding: 12px 18px;">
            <p style="margin: 0; color: #4A00C4; font-size: 12px; font-weight: 700; letter-spacing: 0.2px;">
                Demande reçue &middot; En cours d'analyse
            </p>
        </td>
    </tr>
</table>

{{-- Salutation --}}
<p style="margin: 0 0 12px 0; color: #0F172A; font-size: 20px; font-weight: 700;">
    Bonjour {{ $application->prenom }} {{ $application->nom }},
</p>

<p style="margin: 0 0 24px 0; color: #475569; font-size: 14px; line-height: 1.6;">
    Nous avons bien reçu votre demande de prêt. Votre dossier a été transmis à notre équipe d'analyse et est actuellement en cours de traitement.
</p>

{{-- Encadré Référence --}}
<table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; background-color: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; margin-bottom: 24px;">
    <tr>
        <td style="padding: 16px 20px;">
            <p style="margin: 0 0 4px 0; color: #64748B; font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                Référence de dossier
            </p>
            <p style="margin: 0; color: #1E293B; font-size: 20px; font-weight: 800; font-family: 'Courier New', Courier, monospace; letter-spacing: 1px;">
                {{ $application->reference }}
            </p>
        </td>
    </tr>
</table>

{{-- Tableau récapitulatif --}}
<p style="margin: 0 0 10px 0; color: #0F172A; font-size: 13px; font-weight: 700;">
    Récapitulatif de votre demande :
</p>

<table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; border-collapse: collapse; border: 1px solid #E2E8F0; border-radius: 8px; overflow: hidden; margin-bottom: 24px;">
    <tr>
        <td style="padding: 11px 16px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; color: #475569; font-size: 13px; font-weight: 500; width: 50%;">
            Montant souhaité
        </td>
        <td style="padding: 11px 16px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; color: #0F172A; font-size: 14px; font-weight: 700; text-align: right;">
            {{ number_format($application->montant, 0, ',', ' ') }} €
        </td>
    </tr>
    <tr>
        <td style="padding: 11px 16px; background-color: #ffffff; border-bottom: 1px solid #E2E8F0; color: #475569; font-size: 13px; font-weight: 500;">
            Durée de remboursement
        </td>
        <td style="padding: 11px 16px; background-color: #ffffff; border-bottom: 1px solid #E2E8F0; color: #0F172A; font-size: 13px; font-weight: 600; text-align: right;">
            {{ $application->duree_mois }} mois
        </td>
    </tr>
    <tr>
        <td style="padding: 11px 16px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; color: #475569; font-size: 13px; font-weight: 500;">
            Mensualité estimée
        </td>
        <td style="padding: 11px 16px; background-color: #F8FAFC; border-bottom: 1px solid #E2E8F0; color: #0F172A; font-size: 13px; font-weight: 600; text-align: right;">
            {{ number_format($application->mensualite, 2, ',', ' ') }} €
        </td>
    </tr>
    <tr>
        <td style="padding: 11px 16px; background-color: #ffffff; color: #475569; font-size: 13px; font-weight: 500;">
            TAEG fixe
        </td>
        <td style="padding: 11px 16px; background-color: #ffffff; color: #0F172A; font-size: 13px; font-weight: 600; text-align: right;">
            {{ $application->taux_annuel }} %
        </td>
    </tr>
</table>

<p style="margin: 0 0 28px 0; color: #475569; font-size: 13px; line-height: 1.6;">
    Vous trouverez également en pièce jointe le récapitulatif complet de votre demande au format PDF.
</p>

{{-- Signature --}}
<table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%; border-top: 1px solid #E2E8F0; padding-top: 20px;">
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

<x-slot:subcopy>
    Données transmises et conservées de façon confidentielle, conformément au RGPD.
</x-slot:subcopy>

</x-mail::message>

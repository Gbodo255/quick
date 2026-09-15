@component('mail::message')

<div style="background-color: #F8FAFC; padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; border: 1px solid #E2E8F0; text-align: center;">
    <div style="margin-bottom: 12px; display: inline-block;">
        <table cellpadding="0" cellspacing="0" role="presentation" style="margin: 0 auto;">
            <tr>
                <td style="vertical-align: middle; padding-right: 10px;">
                    <div style="width: 40px; height: 40px; background-color: #0A2240; border-radius: 8px; text-align: center; line-height: 40px;">
                        <span style="color: #60A5FA; font-size: 20px; font-family: -apple-system, sans-serif;">🏛️</span>
                    </div>
                </td>
                <td style="vertical-align: middle;">
                    <span style="color: #0F172A; font-size: 22px; font-weight: 800; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; letter-spacing: -0.5px;">
                        {{ config('credit.brand') }}
                    </span>
                </td>
            </tr>
        </table>
    </div>
    <h1 style="font-size: 1.5rem; font-weight: 800; color: #0F172A; margin: 0 0 0.4rem 0;">
        Accord de principe — Prêt Approuvé
    </h1>
    <p style="color: #475569; margin: 0; font-size: 0.95rem;">
        Votre dossier <strong>{{ $application->reference }}</strong> a été validé.
    </p>
</div>

<div style="background-color: #ffffff; padding: 1.5rem; border-radius: 10px; border: 1px solid #E2E8F0;">
@if($customMessage)
{!! Illuminate\Mail\Markdown::parse($customMessage) !!}
@else
Bonjour <strong>{{ $application->prenom }} {{ $application->nom }}</strong>,

Nous avons le plaisir de vous informer que votre demande de financement a été **examinée et approuvée** par notre comité d'engagement.

Vous trouverez en pièce jointe votre **Offre de Contrat de Prêt**, précisant l'ensemble des modalités financières de votre dossier.

**Prochaines étapes :**
1. Prenez connaissance du contrat ci-joint.
2. Signez l'offre et retournez-la à notre équipe.
3. Le déblocage des fonds sera effectué dès réception du contrat signé.
@endif
</div>

{{-- Signature du courtier --}}
<div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #E2E8F0;">
    <table cellpadding="0" cellspacing="0" role="presentation" style="width: 100%;">
        <tr>
            <td style="vertical-align: top; width: 52px; padding-right: 14px;">
                <div style="width: 42px; height: 42px; background-color: #0A2240; border-radius: 10px; text-align: center; line-height: 42px;">
                    <span style="color: #60A5FA; font-size: 20px; font-family: -apple-system, sans-serif;">🏛️</span>
                </div>
            </td>
            <td style="vertical-align: top;">
                <p style="margin: 0 0 2px 0; color: #0F172A; font-size: 16px; font-weight: 700; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    L'équipe {{ config('credit.brand') }}
                </p>
                <p style="margin: 0 0 6px 0; color: #475569; font-size: 13px; font-weight: 500; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    Service client
                </p>
                <p style="margin: 0 0 3px 0; color: #64748B; font-size: 12px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    📞 <a href="tel:+33780961216" style="color: #0F172A; text-decoration: none; font-weight: 600;">+33 7 80 96 12 16</a>
                </p>
                <p style="margin: 0 0 3px 0; color: #64748B; font-size: 12px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    ✉️ <a href="mailto:contacts@studcredit.com" style="color: #2563EB; text-decoration: none; font-weight: 500;">contacts@studcredit.com</a>
                </p>
                <p style="margin: 0; color: #64748B; font-size: 12px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
                    🌐 <a href="https://studcredit.com" style="color: #2563EB; text-decoration: none; font-weight: 500;">studcredit.com</a>
                </p>
            </td>
        </tr>
    </table>
</div>

@endcomponent

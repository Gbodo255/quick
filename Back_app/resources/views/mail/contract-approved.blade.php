@component('mail::message')

<div style="background-color: #f8fafc; padding: 2rem 1rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid #e2e8f0; text-align: center;">
    <div style="width: 60px; height: 60px; background-color: #ecfdf5; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem;">
        <span style="font-size: 28px;">🎉</span>
    </div>
    <h1 style="font-size: 1.8rem; font-weight: 800; color: #0f172a; margin: 0 0 0.5rem 0; letter-spacing: -0.02em;">
        Bonne nouvelle !
    </h1>
    <p style="color: #475569; margin: 0; font-size: 1rem;">
        Votre dossier <strong>{{ $application->reference }}</strong> a été approuvé.
    </p>
</div>

<div style="background-color: #ffffff; padding: 2rem; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
@if($customMessage)
{!! Illuminate\Mail\Markdown::parse($customMessage) !!}
@else
Bonjour **{{ $application->prenom }} {{ $application->nom }}**,

Nous avons le plaisir de vous informer que votre demande de prêt a été **examinée et approuvée** par notre comité d'engagement.

Veuillez trouver en pièce jointe votre **Offre de Contrat de Prêt**, qui récapitule l'ensemble des conditions et modalités de votre financement.

**Prochaines étapes :**

1. Lisez attentivement le contrat ci-joint
2. Signez le document et retournez-le à votre conseiller
3. Les fonds seront débloqués après réception du contrat signé
@endif
</div>

<div style="text-align: center; margin-top: 2rem; color: #64748b; font-size: 0.85rem;">
    Pour toute question, notre équipe reste disponible à l'adresse : <a href="mailto:{{ config('mail.from.address') }}" style="color: #4f46e5; text-decoration: none; font-weight: 600;">{{ config('mail.from.address') }}</a>
    <br><br>
    Cordialement,<br>
    <strong>L'équipe {{ config('credit.brand') }}</strong>
</div>

@endcomponent

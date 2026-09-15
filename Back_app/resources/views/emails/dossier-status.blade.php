<x-mail::message>
# Bonjour {{ $application->prenom }},

Le statut de votre demande de crédit (Réf: **{{ $application->reference }}**) a été mis à jour.

Nouveau statut : **{{ $application->status->label() }}**

@if($application->status === \App\Enums\DossierStatus::ClotureSucces || $application->status === \App\Enums\DossierStatus::FondsDecaisses)
Félicitations, votre demande a été approuvée ! Un conseiller prendra contact avec vous très prochainement.
@else
Votre dossier est actuellement en cours d'analyse par notre équipe.
@endif

Merci de votre confiance,
L'équipe {{ config('credit.brand') }}.
</x-mail::message>

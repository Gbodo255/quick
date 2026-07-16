<x-mail::message>
# Bonjour {{ $application->prenom }},

Le statut de votre demande de crédit (Réf: **{{ $application->reference }}**) a été mis à jour.

Nouveau statut : **{{ match($application->status) { 'processing' => 'En cours de traitement', 'completed' => 'Approuvé', 'rejected' => 'Refusé', default => 'En attente' } }}**

@if($application->status === 'completed')
Félicitations, votre demande a été approuvée ! Un conseiller prendra contact avec vous très prochainement.
@elseif($application->status === 'processing')
Votre dossier est actuellement en cours d'analyse par notre équipe.
@endif

Merci de votre confiance,
L'équipe QuickCredit.
</x-mail::message>

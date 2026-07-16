import React from 'react';
import { SEO } from '@/components/SEO';
import { BrandLogo } from '../BrandLogo';

export function LegalScreen({ onBack }) {
  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO title="Mentions légales & CGU" />
      <header className="sticky top-0 z-40 bg-lumina-surface-lowest/80 backdrop-blur-md border-b border-lumina-outline px-6 py-4 flex items-center justify-between">
        <button onClick={onBack} className="inline-flex items-center gap-2 hover:opacity-80">
          <BrandLogo size="lg" />
        </button>
        <button onClick={onBack} className="text-sm font-medium hover:underline">
          Retour
        </button>
      </header>
      <main className="flex-1 max-w-4xl mx-auto px-6 py-12 w-full">
        <h1 className="text-3xl font-bold mb-8">Mentions Légales</h1>
        <div className="space-y-6 text-lumina-on-surface-variant leading-relaxed">
          <p><strong>Dénomination Sociale :</strong> Privilege Finance SAS</p>
          <p><strong>Capital Social :</strong> 10 000 €</p>
          <p><strong>Siège social :</strong> 12 rue de la Paix, 75001 Paris, France.</p>
          <p><strong>RCS :</strong> Paris B XXX XXX XXX</p>

          <h2 className="text-xl font-semibold text-lumina-heading mt-6">Statut Réglementé (IOBSP)</h2>
          <p>
            En tant qu'Intermédiaire en Opérations de Banque et en Services de Paiement (IOBSP), Privilege Finance agit en qualité de courtier.
            Nous sommes immatriculés au Registre Unique des Intermédiaires en Assurance, Banque et Finance (ORIAS) sous le numéro <strong>XX XXX XXX</strong> (vérifiable sur www.orias.fr).
          </p>
          <p>
            Activité soumise au contrôle de l'Autorité de Contrôle Prudentiel et de Résolution (ACPR) : 4 Place de Budapest CS 92459, 75436 Paris Cedex 09 (www.acpr.banque-france.fr).
          </p>

          <h2 className="text-xl font-semibold text-lumina-heading mt-6">Garantie Financière et RCP</h2>
          <p>
            Assurance Responsabilité Civile Professionnelle souscrite auprès de [Nom de l'assureur], Police n° [Numéro], couvrant le territoire français.
            Garantie financière conforme aux articles L.512-6 et L.512-7 du Code des assurances et L.519-4 du Code monétaire et financier.
          </p>

          <h2 className="text-xl font-semibold text-lumina-heading mt-6">Calcul de Nos Frais</h2>
          <p>
            Conformément à la réglementation, <strong>aucun versement, de quelque nature que ce soit, ne peut être exigé d'un particulier, avant l'obtention d'un ou plusieurs prêts d'argent.</strong> (Article L321-2 du Code de la Consommation).
          </p>
          <p>
            Nos frais de courtage sont transparents et s'élèvent en général à 1% du montant emprunté (avec un minimum forfaitaire de XXX €). Ils ne sont dus et facturés qu'au moment du déblocage effectif des fonds. Ils sont clairement distingués des frais de dossier bancaires.
          </p>

          <h2 className="text-xl font-semibold text-lumina-heading mt-6">Délégation d'Assurance (Loi Lemoine)</h2>
          <p>
            Conformément à la Loi Lemoine du 28 février 2022, vous êtes libre de choisir votre assurance emprunteur (délégation d'assurance), dès lors que le contrat alternatif présente un niveau de garantie équivalent à celui proposé par l'établissement prêteur. Vous pouvez résilier votre assurance emprunteur à tout moment. Le questionnaire de santé est supprimé pour les prêts immobiliers inférieurs à 200 000€ par emprunteur dont l'échéance arrive avant le 60ème anniversaire.
          </p>

          <h2 className="text-xl font-semibold text-lumina-heading mt-6">Hébergement</h2>
          <p>Le site est hébergé sur des serveurs sécurisés en Europe par [Nom de l'hébergeur, Adresse].</p>
        </div>
      </main>
    </div>
  );
}

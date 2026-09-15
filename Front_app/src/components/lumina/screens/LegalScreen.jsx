import { SEO } from '@/components/SEO';

const SECTIONS = [
  {
    title: 'Statut Réglementé (IOBSP)',
    body: [
      "En tant qu'Intermédiaire en Opérations de Banque et en Services de Paiement (IOBSP), Privilege Finance agit en qualité de courtier. Nous sommes immatriculés au Registre Unique des Intermédiaires en Assurance, Banque et Finance (ORIAS) sous le numéro XX XXX XXX (vérifiable sur www.orias.fr).",
      "Activité soumise au contrôle de l'Autorité de Contrôle Prudentiel et de Résolution (ACPR) : 4 Place de Budapest CS 92459, 75436 Paris Cedex 09 (www.acpr.banque-france.fr).",
    ],
  },
  {
    title: 'Garantie Financière et RCP',
    body: [
      "Assurance Responsabilité Civile Professionnelle souscrite auprès de [Nom de l'assureur], Police n° [Numéro], couvrant le territoire français. Garantie financière conforme aux articles L.512-6 et L.512-7 du Code des assurances et L.519-4 du Code monétaire et financier.",
    ],
  },
  {
    title: 'Calcul de Nos Frais',
    body: [
      "Conformément à la réglementation, aucun versement, de quelque nature que ce soit, ne peut être exigé d'un particulier, avant l'obtention d'un ou plusieurs prêts d'argent (Article L321-2 du Code de la Consommation).",
      "Nos frais de courtage sont transparents et s'élèvent en général à 1% du montant emprunté (avec un minimum forfaitaire de XXX €). Ils ne sont dus et facturés qu'au moment du déblocage effectif des fonds. Ils sont clairement distingués des frais de dossier bancaires.",
    ],
  },
  {
    title: "Délégation d'Assurance (Loi Lemoine)",
    body: [
      "Conformément à la Loi Lemoine du 28 février 2022, vous êtes libre de choisir votre assurance emprunteur (délégation d'assurance), dès lors que le contrat alternatif présente un niveau de garantie équivalent à celui proposé par l'établissement prêteur. Vous pouvez résilier votre assurance emprunteur à tout moment. Le questionnaire de santé est supprimé pour les prêts immobiliers inférieurs à 200 000€ par emprunteur dont l'échéance arrive avant le 60ème anniversaire.",
    ],
  },
  {
    title: 'Hébergement',
    body: ["Le site est hébergé sur des serveurs sécurisés en Europe par [Nom de l'hébergeur, Adresse]."],
  },
];

export function LegalScreen({ footer }) {
  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO title="Mentions légales & CGU | StudCredit" />

      <main className="flex-1 mx-auto w-full max-w-4xl px-6 pt-24 pb-20 md:pt-32">
        <p className="mb-3 text-xs font-semibold tracking-widest text-lumina-primary uppercase">Informations légales</p>
        <h1 className="font-[family-name:var(--font-headline)] text-4xl font-semibold tracking-tight text-lumina-heading md:text-5xl mb-10">
          Mentions Légales
        </h1>

        <div className="grid gap-2 text-sm text-lumina-on-surface-variant mb-4">
          <p><strong className="text-lumina-heading">Dénomination Sociale :</strong> Privilege Finance SAS</p>
          <p><strong className="text-lumina-heading">Capital Social :</strong> 10 000 €</p>
          <p><strong className="text-lumina-heading">Siège social :</strong> 12 rue de la Paix, 75001 Paris, France.</p>
          <p><strong className="text-lumina-heading">RCS :</strong> Paris B XXX XXX XXX</p>
        </div>

        <div className="mt-10 border-t border-lumina-outline">
          {SECTIONS.map((s) => (
            <div key={s.title} className="border-b border-lumina-outline py-8">
              <h2 className="font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-heading">
                {s.title}
              </h2>
              <div className="mt-3 space-y-3">
                {s.body.map((p) => (
                  <p key={p} className="max-w-2xl leading-relaxed text-lumina-on-surface-variant">
                    {p}
                  </p>
                ))}
              </div>
            </div>
          ))}
        </div>
      </main>
      {footer}
    </div>
  );
}

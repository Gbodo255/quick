import { useState } from 'react';
import { ChevronDown } from 'lucide-react';
import { SEO } from '@/components/SEO';
import { BRAND_WORDMARK } from '@/lib/credit';
import { cn } from '@/lib/utils';

const FAQ_ITEMS = [
  {
    q: "Le prêt est-il réservé aux étudiants ?",
    a: "Oui. L'offre est destinée aux étudiants qui remplissent les conditions d'éligibilité prévues par le produit.",
  },
  {
    q: "Dois-je fournir un certificat de scolarité ?",
    a: "Oui, le certificat de scolarité fait partie des justificatifs demandés pour vérifier votre statut étudiant.",
  },
  {
    q: "Dois-je avoir une caution ?",
    a: "Non, aucune caution personnelle n'est demandée dans le cadre de l'offre. Cela ne signifie pas que la demande est automatiquement acceptée.",
  },
  {
    q: "Le certificat de scolarité suffit-il pour obtenir le prêt ?",
    a: "Non. Il justifie le statut étudiant, mais l'octroi du crédit reste soumis aux conditions applicables et aux vérifications requises.",
  },
  {
    q: "Combien puis-je emprunter ?",
    a: "Le montant dépend de votre projet et de votre situation. Notre simulateur permet d'estimer un financement de 1 000 € à 50 000 €.",
  },
  {
    q: "Combien vais-je rembourser chaque mois ?",
    a: "La mensualité dépend notamment du montant, de la durée, du taux et des frais éventuels. Utilisez le simulateur pour obtenir une estimation.",
  },
  {
    q: "Quel est le coût du crédit ?",
    a: "Le coût est présenté de manière complète avant l'engagement, notamment au moyen du TAEG (3,9 % fixe à titre d'exemple) et des informations contractuelles applicables.",
  },
  {
    q: "Puis-je utiliser le financement pour mes dépenses personnelles ?",
    a: "Le financement accompagne les besoins liés à votre parcours d'études : frais de scolarité, logement étudiant, matériel et fournitures, permis de conduire ou autre projet étudiant.",
  },
  {
    q: "Puis-je rembourser plus tôt ?",
    a: "Les conditions de remboursement anticipé sont précisées dans les documents contractuels, conformément à la réglementation applicable.",
  },
  {
    q: "Que se passe-t-il si ma situation financière change ?",
    a: "Si vous rencontrez des difficultés de remboursement, contactez rapidement votre conseiller. N'attendez pas l'accumulation d'impayés pour demander des informations.",
  },
  {
    q: "Est-ce une offre de crédit immédiate ?",
    a: "Le délai de traitement dépend du parcours, des vérifications et des conditions applicables à votre dossier. Nous ne promettons pas d'acceptation immédiate.",
  },
  {
    q: "Comment contacter votre équipe ?",
    a: "Par téléphone au +33 7 80 96 12 16 (du lundi au vendredi, 9h-18h) ou par email à contacts@studcredit.com.",
  },
];

export function FaqScreen({ footer }) {
  const [openIndex, setOpenIndex] = useState(0);
  const toggle = (i) => setOpenIndex((prev) => (prev === i ? null : i));

  const faqSchema = {
    "@type": "FAQPage",
    "mainEntity": FAQ_ITEMS.map((item) => ({
      "@type": "Question",
      "name": item.q,
      "acceptedAnswer": {
        "@type": "Answer",
        "text": item.a,
      },
    })),
  };

  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO
        title="Questions fréquentes sur le prêt étudiant | StudCredit"
        description="Éligibilité, certificat de scolarité, caution, montants, mensualités, TAEG : toutes les réponses sur le prêt étudiant StudCredit."
        schema={faqSchema}
      />

      <main className="flex-1 mx-auto w-full max-w-4xl px-6 pt-10 pb-20 md:pt-12">
        <h1 className="font-[family-name:var(--font-headline)] text-4xl font-semibold tracking-tight text-lumina-heading md:text-5xl mb-10">
          Questions fréquentes sur le prêt étudiant
        </h1>

        <div className="border-t border-lumina-outline">
          {FAQ_ITEMS.map((item, index) => {
            const isOpen = openIndex === index;
            return (
              <div key={item.q} className="border-b border-lumina-outline">
                <button
                  type="button"
                  onClick={() => toggle(index)}
                  aria-expanded={isOpen}
                  className="flex w-full items-center gap-4 py-6 text-left"
                >
                  <h3 className="flex-1 font-[family-name:var(--font-headline)] text-lg font-semibold text-lumina-heading">
                    {item.q}
                  </h3>
                  <span className="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-lumina-outline-variant">
                    <ChevronDown
                      className={cn(
                        'h-4 w-4 text-lumina-on-surface-variant transition-transform duration-300',
                        isOpen && 'rotate-180',
                      )}
                    />
                  </span>
                </button>
                <div
                  className={cn(
                    'grid transition-all duration-300 ease-in-out',
                    isOpen ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0',
                  )}
                >
                  <div className="overflow-hidden">
                    <p className="max-w-2xl pb-6 leading-relaxed text-lumina-on-surface-variant">{item.a}</p>
                  </div>
                </div>
              </div>
            );
          })}
        </div>

        <p className="mt-10 max-w-2xl text-xs leading-relaxed text-lumina-on-surface-variant">
          « Sans caution personnelle » signifie qu'aucune personne physique n'est demandée comme caution dans le cadre de l'offre, sous réserve des conditions d'octroi et des vérifications légalement requises. {BRAND_WORDMARK.prefix}{BRAND_WORDMARK.accent} ne garantit pas l'acceptation automatique d'une demande.
        </p>
      </main>
      {footer}
    </div>
  );
}

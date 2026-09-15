import { SEO } from '@/components/SEO';
import { TAUX_ANNUEL } from '@/lib/credit';

const SECTIONS = [
  {
    title: 'Quel montant pouvez-vous emprunter ?',
    body: (
      <>De <strong className="text-lumina-heading">1 000 €</strong> à <strong className="text-lumina-heading">50 000 €</strong>, selon votre projet et votre situation. Le montant définitif dépend de l'étude de votre demande.</>
    ),
  },
  {
    title: 'Choisissez une durée adaptée à votre situation.',
    body: (
      <>De <strong className="text-lumina-heading">12</strong> à <strong className="text-lumina-heading">84 mois</strong>. Une durée plus longue réduit la mensualité mais augmente le coût total du crédit : utilisez le simulateur pour comparer les scénarios.</>
    ),
  },
  {
    title: 'Le coût du crédit, expliqué sans détour.',
    body: (
      <>À titre indicatif, un TAEG fixe de <strong className="text-lumina-heading">{TAUX_ANNUEL} %</strong> s'applique aux exemples présentés sur ce site. Le taux débiteur, le TAEG définitif, les frais éventuels et le montant total dû vous seront communiqués avant toute signature, conformément aux modalités réglementaires applicables. Aucun chiffre affiché ici ne constitue une offre ferme.</>
    ),
  },
  {
    title: 'Pas de caution personnelle demandée.',
    body: "Vous n'avez pas à demander à un proche de se porter caution dans le cadre de cette offre. Cette caractéristique ne supprime pas les conditions d'éligibilité, l'étude de la demande ni les obligations de remboursement.",
  },
];

export function PretEtudiantScreen({ onOpenEligibilite, footer }) {
  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO
        title="Prêt étudiant : montant, durée et conditions | StudCredit"
        description="Découvrez le fonctionnement du prêt étudiant StudCredit : montant, durée, taux, coût et absence de caution personnelle."
      />

      <main className="flex-1 mx-auto w-full max-w-4xl px-6 pt-24 pb-20 md:pt-32">
        <p className="mb-3 text-xs font-semibold tracking-widest text-lumina-primary uppercase">Le prêt étudiant</p>
        <h1 className="font-[family-name:var(--font-headline)] text-4xl font-semibold tracking-tight text-lumina-heading md:text-5xl mb-6">
          Un prêt conçu pour accompagner votre parcours étudiant.
        </h1>
        <p className="max-w-2xl text-lg leading-relaxed text-lumina-on-surface-variant mb-14">
          Parce que les études représentent des dépenses réelles, notre offre de financement est conçue pour répondre aux besoins des étudiants éligibles. L'objectif : présenter une solution compréhensible, avec des conditions lisibles avant toute décision.
        </p>

        <div className="border-t border-lumina-outline">
          {SECTIONS.map((s) => (
            <div key={s.title} className="border-b border-lumina-outline py-8">
              <h2 className="font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-heading">{s.title}</h2>
              <p className="mt-3 max-w-2xl leading-relaxed text-lumina-on-surface-variant">{s.body}</p>
            </div>
          ))}
        </div>

        <div className="mt-14 flex flex-col items-start gap-4 bg-lumina-primary p-8 text-white sm:flex-row sm:items-center sm:justify-between">
          <p className="font-semibold text-lg">Vérifiez si votre profil est éligible.</p>
          <button
            type="button"
            onClick={onOpenEligibilite}
            className="inline-flex h-11 shrink-0 items-center justify-center rounded-none bg-white px-8 text-sm font-semibold text-lumina-primary transition-colors hover:bg-white/90"
          >
            Vérifier mon éligibilité
          </button>
        </div>

        <p className="mt-8 max-w-2xl text-xs leading-relaxed text-lumina-on-surface-variant">
          « Sans caution personnelle » signifie qu'aucune personne physique n'est demandée comme caution dans le cadre de l'offre, sous réserve des conditions d'octroi et des vérifications légalement requises.
        </p>
      </main>
      {footer}
    </div>
  );
}

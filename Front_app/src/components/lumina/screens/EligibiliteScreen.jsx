import { SEO } from '@/components/SEO';
import eligibiliteImage from '@/assets/hero-students.jpg';

const CRITERES = [
  "Être étudiant dans un établissement éligible",
  "Fournir un certificat de scolarité valide",
  "Résider en France métropolitaine",
  "Respecter les critères d'âge, de situation et de capacité de remboursement applicables",
];

export function EligibiliteScreen({ onStartSimulator, footer }) {
  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO
        title="Prêt étudiant : conditions d'éligibilité | StudCredit"
        description="Qui peut demander le prêt étudiant StudCredit ? Critères, certificat de scolarité et conditions d'octroi expliqués simplement."
      />

      <main className="flex-1 mx-auto w-full max-w-5xl px-6 pt-10 pb-20 md:pt-12">
        <h1 className="font-[family-name:var(--font-headline)] text-4xl font-semibold tracking-tight text-lumina-heading md:text-5xl mb-6">
          Qui peut demander le prêt étudiant ?
        </h1>

        <div className="h-64 w-full overflow-hidden md:h-96">
          <img
            src={eligibiliteImage}
            alt="Étudiants sur un campus universitaire"
            className="h-full w-full object-cover"
          />
        </div>

        <p className="mt-8 w-full text-lg leading-relaxed text-lumina-on-surface-variant">
          L'offre est réservée aux étudiants répondant aux critères ci-dessous. La demande doit être accompagnée des justificatifs prévus au parcours.
        </p>

        <ul className="mt-10 border-t border-lumina-outline mb-4">
          {CRITERES.map((c) => (
            <li key={c} className="flex items-start gap-3 border-b border-lumina-outline py-4">
              <span className="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center bg-lumina-primary/10 text-lumina-primary text-xs font-bold">✓</span>
              <span className="text-sm text-lumina-on-surface">{c}</span>
            </li>
          ))}
        </ul>

        <div className="mt-10 border-t border-lumina-outline">
          <div className="border-b border-lumina-outline py-8">
            <h2 className="font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-heading">Votre certificat de scolarité</h2>
            <p className="mt-3 w-full leading-relaxed text-lumina-on-surface-variant">
              Le certificat de scolarité permet de justifier votre statut étudiant. D'autres informations ou justificatifs peuvent toutefois être nécessaires selon la réglementation, le produit et l'analyse de la demande.
            </p>
          </div>
          <div className="border-b border-lumina-outline py-8">
            <h2 className="font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-heading">À propos de la caution</h2>
            <p className="mt-3 w-full leading-relaxed text-lumina-on-surface-variant">
              Aucune caution personnelle n'est demandée dans le cadre de l'offre.
            </p>
          </div>
        </div>

        <div className="mt-8 border border-lumina-warning/40 bg-lumina-warning-bg p-5">
          <h2 className="text-sm font-bold uppercase tracking-wide text-lumina-warning-foreground">Important</h2>
          <p className="mt-2 text-sm text-lumina-warning-foreground leading-relaxed">
            La fourniture d'un certificat de scolarité ne vaut pas acceptation automatique du crédit. Toute demande reste soumise aux conditions applicables et aux vérifications requises.
          </p>
        </div>

        <div className="mt-10">
          <button
            type="button"
            onClick={onStartSimulator}
            className="inline-flex h-11 items-center justify-center rounded-none bg-lumina-primary px-8 text-sm font-semibold text-white transition-colors hover:bg-lumina-brand w-full sm:w-auto"
          >
            Commencer ma simulation
          </button>
        </div>
      </main>
      {footer}
    </div>
  );
}

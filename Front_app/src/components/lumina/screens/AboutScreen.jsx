import { SEO } from '@/components/SEO';
import { BRAND_WORDMARK } from '@/lib/credit';

const SECTIONS = [
  {
    title: 'Notre façon de faire',
    text: "Nous expliquons les conditions avant la décision, nous distinguons clairement simulation et offre de crédit, et nous évitons les promesses qui pourraient donner une vision irréaliste du financement.",
  },
  {
    title: 'Notre engagement de transparence',
    text: "Pas de formulation ambiguë sur le coût. Pas de promesse d'acceptation automatique. Pas de présentation du crédit comme de l'argent gratuit. Les conditions réelles de l'offre priment toujours sur le discours marketing.",
  },
  {
    title: 'Notre expertise',
    text: "Nous travaillons avec des partenaires bancaires certifiés pour garantir la sécurité de vos données. Nos conseillers sont basés en Europe et formés aux normes de régulation financière.",
  },
];

export function AboutScreen({ footer }) {
  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO
        title="À propos | StudCredit"
        description={`Découvrez la mission de ${BRAND_WORDMARK.prefix}${BRAND_WORDMARK.accent} : rendre le financement des études plus lisible pour les étudiants.`}
      />

      <main className="flex-1 mx-auto w-full max-w-4xl px-6 pt-24 pb-20 md:pt-32">
        <p className="mb-3 text-xs font-semibold tracking-widest text-lumina-primary uppercase">À propos</p>
        <h1 className="max-w-2xl font-[family-name:var(--font-headline)] text-4xl font-semibold tracking-tight text-lumina-heading md:text-5xl">
          Notre mission : rendre le financement des études plus lisible.
        </h1>
        <p className="mt-6 max-w-2xl text-lg leading-relaxed text-lumina-on-surface-variant">
          Les études demandent du temps, de l'énergie et un budget. Notre approche est simple : proposer aux étudiants une information claire sur les possibilités de financement et sur les engagements associés à un crédit.
        </p>

        <div className="mt-14 border-t border-lumina-outline">
          {SECTIONS.map((s) => (
            <div key={s.title} className="border-b border-lumina-outline py-8">
              <h2 className="font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-heading">
                {s.title}
              </h2>
              <p className="mt-3 max-w-2xl leading-relaxed text-lumina-on-surface-variant">
                {s.text}
              </p>
            </div>
          ))}
        </div>
      </main>
      {footer}
    </div>
  );
}

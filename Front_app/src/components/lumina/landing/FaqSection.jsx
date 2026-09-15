import { useState } from 'react'
import { ChevronDown, ArrowRight } from 'lucide-react'
import { cn } from '@/lib/utils'

const FAQ_ITEMS = [
  {
    q: "Le prêt est-il réservé aux étudiants ?",
    a: "Oui. L'offre est destinée aux étudiants qui remplissent les conditions d'éligibilité prévues par le produit.",
  },
  {
    q: "Dois-je avoir une caution ?",
    a: "Non, aucune caution personnelle n'est demandée dans le cadre de l'offre. Cela ne signifie pas que la demande est automatiquement acceptée.",
  },
  {
    q: "Combien puis-je emprunter ?",
    a: "Le montant dépend de votre projet et de votre situation. Notre simulateur permet d'estimer un financement de 1 000 € à 50 000 €.",
  },
  {
    q: "Quel est le coût du crédit ?",
    a: "Le coût est présenté de manière complète avant l'engagement, notamment au moyen du TAEG (3,9 % fixe à titre d'exemple) et des informations contractuelles applicables.",
  },
  {
    q: "Est-ce une offre de crédit immédiate ?",
    a: "Le délai de traitement dépend du parcours, des vérifications et des conditions applicables à votre dossier. Nous ne promettons pas d'acceptation immédiate.",
  },
]

export function FaqSection({ onOpenFaq }) {
  const [openIndex, setOpenIndex] = useState(null)

  const toggle = (i) => setOpenIndex((prev) => (prev === i ? null : i))

  return (
    <section id="faq" className="mx-auto flex min-h-[75svh] max-w-6xl flex-col items-center justify-center px-6 py-24 scroll-mt-24">
      <div className="text-center">
        <h2 className="font-[family-name:var(--font-headline)] text-lg leading-tight font-semibold sm:text-2xl md:text-3xl text-lumina-heading">
          Vous avez une question ? Nous vous écoutons.
        </h2>
      </div>

      <div className="mt-10 w-full max-w-4xl border-t border-lumina-outline">
        {FAQ_ITEMS.map((item, index) => {
          const isOpen = openIndex === index
          return (
            <div key={item.q} className="border-b border-lumina-outline">
              <button
                type="button"
                onClick={() => toggle(index)}
                aria-expanded={isOpen}
                className="flex w-full items-center gap-4 py-6 text-left"
              >
                <h3 className="flex-1 font-[family-name:var(--font-headline)] text-base font-semibold text-lumina-heading md:text-lg">
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
                  <p className="pb-6 text-sm leading-relaxed text-lumina-on-surface-variant">
                    {item.a}
                  </p>
                </div>
              </div>
            </div>
          )
        })}
      </div>

      <div className="mt-10 flex w-full max-w-4xl justify-end">
        <button
          type="button"
          onClick={onOpenFaq}
          className="inline-flex h-11 items-center justify-center gap-1.5 rounded-md bg-lumina-primary px-8 text-sm font-semibold text-white transition-colors hover:bg-lumina-brand"
        >
          Foire aux questions
          <ArrowRight className="h-4 w-4" />
        </button>
      </div>
    </section>
  )
}

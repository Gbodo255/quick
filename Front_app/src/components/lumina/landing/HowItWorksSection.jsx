import { useState, useEffect } from 'react'
import { GraduationCap, ShieldCheck, FileCheck, Clock, ArrowRight } from 'lucide-react'
import { useTranslation } from 'react-i18next'
import { cn } from '@/lib/utils'
import imgDedieEtudiants from '@/assets/why-us/dedie-etudiants.jpg'
import imgSansCaution from '@/assets/why-us/sans-caution.jpg'
import imgConditionsClaires from '@/assets/why-us/conditions-claires.jpg'
import imgReponseRapide from '@/assets/why-us/reponse-rapide.jpg'

const ITEMS = [
  { key: 'step1', icon: GraduationCap, image: imgDedieEtudiants },
  { key: 'step2', icon: ShieldCheck, image: imgSansCaution },
  { key: 'step3', icon: FileCheck, image: imgConditionsClaires },
  { key: 'step4', icon: Clock, image: imgReponseRapide },
]

export function HowItWorksSection({ onOpenObjectifModal }) {
  const { t } = useTranslation()
  const [openKey, setOpenKey] = useState(ITEMS[0].key)
  const openItem = ITEMS.find((p) => p.key === openKey)

  useEffect(() => {
    const timer = setTimeout(() => {
      setOpenKey((prev) => {
        const idx = ITEMS.findIndex((p) => p.key === prev)
        return ITEMS[(idx + 1) % ITEMS.length].key
      })
    }, 5000)
    return () => clearTimeout(timer)
  }, [openKey])

  return (
    <section id="pourquoi-nous" className="mx-auto min-h-[90svh] max-w-6xl px-6 pt-16 pb-16 scroll-mt-24">
      <div className="flex w-full flex-col gap-10 lg:flex-row lg:gap-16">
        <div className="flex flex-col lg:order-2 lg:w-1/2">
          <h2 className="font-[family-name:var(--font-headline)] text-2xl leading-tight font-semibold md:text-3xl text-balance text-lumina-heading">
            {t('landing.how_title', 'Un financement conçu autour de la réalité étudiante.')}
          </h2>

          <div
            className={cn(
              'relative mt-8 min-h-64 flex-1 overflow-hidden rounded-lg transition-opacity duration-300 ease-in-out',
              openItem ? 'opacity-100' : 'opacity-0',
            )}
          >
            {openItem && (
              <img
                src={openItem.image}
                alt={t(`landing.${openItem.key}_title`)}
                className="absolute inset-0 h-full w-full object-cover"
              />
            )}
          </div>
        </div>

        <div className="lg:order-1 lg:w-2/5">
          {ITEMS.map(({ key, icon: ItemIcon }, index) => {
            const isOpen = openKey === key
            return (
              <div key={key} className={cn(index < ITEMS.length - 1 && 'border-b border-lumina-outline')}>
                <button
                  type="button"
                  onClick={() => setOpenKey(key)}
                  aria-expanded={isOpen}
                  className="flex w-full items-center gap-4 py-9 text-left outline-none"
                >
                  <ItemIcon className="h-8 w-8 shrink-0 text-lumina-primary" strokeWidth={1.5} />
                  <h3 className="flex-1 font-[family-name:var(--font-headline)] text-lg font-semibold text-lumina-heading">
                    {t(`landing.${key}_title`)}
                  </h3>
                </button>

                <div
                  className={cn(
                    'grid transition-all duration-300 ease-in-out',
                    isOpen ? 'grid-rows-[1fr] opacity-100' : 'grid-rows-[0fr] opacity-0',
                  )}
                >
                  <div className="overflow-hidden">
                    <div className="pb-9 pl-12">
                      <p className="text-sm leading-relaxed text-lumina-on-surface-variant">
                        {t(`landing.${key}_text`)}
                      </p>
                      <button
                        type="button"
                        onClick={onOpenObjectifModal}
                        className="mt-4 inline-flex h-10 items-center justify-center rounded-md bg-lumina-primary px-6 text-sm font-semibold text-white transition-colors hover:bg-lumina-brand"
                      >
                        {t('landing.pillar_cta', 'Faire un prêt')}
                        <ArrowRight className="ml-2 h-4 w-4" />
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            )
          })}
        </div>
      </div>
    </section>
  )
}

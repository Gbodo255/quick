import { useState, useEffect } from 'react'
import { Wrench, Car, Wallet, IdCard, ArrowRight } from 'lucide-react'
import { useTranslation } from 'react-i18next'
import { cn } from '@/lib/utils'
import { BANKS } from '@/data/banks'
import imgFraisScolarite from '@/assets/pillars/frais-scolarite.jpg'
import imgLogementEtudiant from '@/assets/pillars/logement-etudiant.jpg'
import imgMaterielFournitures from '@/assets/pillars/materiel-fournitures.jpg'
import imgPermisConduire from '@/assets/pillars/permis-conduire.jpg'

const PILLARS = [
  { key: 'travaux', icon: Wrench, image: imgFraisScolarite },
  { key: 'auto', icon: Car, image: imgLogementEtudiant },
  { key: 'tresorerie', icon: Wallet, image: imgMaterielFournitures },
  { key: 'vacances', icon: IdCard, image: imgPermisConduire },
]

const FEATURED_BANKS = BANKS.slice(0, 5)

export function ProductPillarsSection({ onSelect }) {
  const { t } = useTranslation()
  const [openKey, setOpenKey] = useState(PILLARS[0].key)
  const openPillar = PILLARS.find((p) => p.key === openKey)

  useEffect(() => {
    const timer = setTimeout(() => {
      setOpenKey((prev) => {
        const idx = PILLARS.findIndex((p) => p.key === prev)
        return PILLARS[(idx + 1) % PILLARS.length].key
      })
    }, 5000)
    return () => clearTimeout(timer)
  }, [openKey])

  return (
    <>
      <section className="flex min-h-[10svh] w-full items-center justify-center px-[5%] py-4">
        <div className="flex w-full flex-wrap items-center justify-center gap-x-6 gap-y-3 sm:flex-nowrap sm:justify-between sm:gap-4">
          {FEATURED_BANKS.map((bank) => (
            <img
              key={bank.name}
              src={bank.logo}
              alt={bank.name}
              className="h-8 w-auto max-w-[80px] object-contain sm:h-10 sm:max-w-[110px] md:h-12"
              onError={(e) => { e.target.style.display = 'none' }}
            />
          ))}
        </div>
      </section>

      <section className="mx-auto min-h-[90svh] max-w-6xl px-6 pt-16 pb-16">
        <div className="flex w-full flex-col gap-10 lg:flex-row lg:gap-16">
          <div className="flex flex-col lg:w-1/2">
            <h2 className="font-[family-name:var(--font-headline)] text-2xl leading-tight font-semibold md:text-3xl text-balance text-lumina-heading">
              {t('landing.pillars_title', 'Un prêt pour chaque projet.')}
            </h2>

            <div
              className={cn(
                'relative mt-8 min-h-64 flex-1 overflow-hidden rounded-lg transition-opacity duration-300 ease-in-out',
                openPillar ? 'opacity-100' : 'opacity-0',
              )}
            >
              {openPillar && (
                <img
                  src={openPillar.image}
                  alt={t(`landing.pillar_${openPillar.key}_title`)}
                  className="absolute inset-0 h-full w-full object-cover"
                />
              )}
            </div>
          </div>

          <div className="lg:w-2/5">
            {PILLARS.map(({ key, icon: PillarIcon }, index) => {
              const isOpen = openKey === key
              return (
                <div key={key} className={cn(index < PILLARS.length - 1 && 'border-b border-lumina-outline')}>
                  <button
                    type="button"
                    onClick={() => setOpenKey(key)}
                    aria-expanded={isOpen}
                    className="flex w-full items-center gap-4 py-9 text-left outline-none"
                  >
                    <PillarIcon className="h-8 w-8 shrink-0 text-lumina-primary" strokeWidth={1.5} />
                    <h3 className="flex-1 font-[family-name:var(--font-headline)] text-lg font-semibold text-lumina-heading">
                      {t(`landing.pillar_${key}_title`)}
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
                          {t(`landing.pillar_${key}_desc`)}
                        </p>
                        <button
                          type="button"
                          onClick={() => onSelect?.(key)}
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
    </>
  )
}

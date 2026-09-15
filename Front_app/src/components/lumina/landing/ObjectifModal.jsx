import { useState } from 'react'
import { X, Wrench, Car, Wallet, IdCard, HelpCircle, ArrowRight } from 'lucide-react'
import { useTranslation } from 'react-i18next'
import { cn } from '@/lib/utils'

const OPTIONS = [
  { value: 'travaux', icon: Wrench },
  { value: 'auto', icon: Car },
  { value: 'tresorerie', icon: Wallet },
  { value: 'vacances', icon: IdCard },
  { value: 'autre', icon: HelpCircle },
]

export function ObjectifModal({ open, onClose, onSelect }) {
  const { t } = useTranslation()
  const [selected, setSelected] = useState(null)

  if (!open) return null

  return (
    <div
      className="fixed inset-0 z-[70] flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm"
      onClick={onClose}
    >
      <div
        className="relative w-full max-w-2xl bg-white p-8 shadow-2xl md:p-10"
        onClick={(e) => e.stopPropagation()}
        role="dialog"
        aria-modal="true"
      >
        <button
          type="button"
          onClick={onClose}
          aria-label="Fermer"
          className="absolute -top-4 -right-4 flex h-10 w-10 items-center justify-center bg-white text-lumina-on-surface-variant shadow-md transition-colors hover:bg-lumina-surface-container-low hover:text-lumina-heading"
        >
          <X className="h-5 w-5" />
        </button>

        <h2 className="mb-8 text-center font-[family-name:var(--font-headline)] text-xl font-semibold leading-tight text-lumina-heading md:text-2xl">
          {t('landing.objectif_modal_title', 'Quel type de prêt étudiant souhaitez-vous ?')}
        </h2>

        <div className="grid grid-cols-2 gap-4 sm:grid-cols-3">
          {OPTIONS.map(({ value, icon: OptionIcon }) => {
            const isSelected = selected === value
            return (
              <button
                key={value}
                type="button"
                onClick={() => setSelected(value)}
                aria-pressed={isSelected}
                className={cn(
                  'flex flex-col items-center gap-4 border p-6 text-center transition-all hover:-translate-y-1',
                  isSelected
                    ? 'border-lumina-primary bg-lumina-surface-container-low shadow-lg'
                    : 'border-lumina-outline hover:border-lumina-primary hover:shadow-lg',
                )}
              >
                <span
                  className={cn(
                    'flex h-14 w-14 items-center justify-center bg-lumina-surface-container text-lumina-primary',
                    isSelected && 'bg-lumina-primary text-white',
                  )}
                >
                  <OptionIcon className="h-7 w-7" strokeWidth={1.5} />
                </span>
                <span className="text-sm font-medium leading-tight text-lumina-heading">
                  {t(`simulator.motifs.${value}`)}
                </span>
              </button>
            )
          })}
        </div>

        <div className="mt-8 flex justify-end">
          <button
            type="button"
            disabled={!selected}
            onClick={() => onSelect(selected)}
            className="inline-flex h-11 items-center justify-center gap-1.5 bg-lumina-primary px-8 text-sm font-semibold text-white transition-colors hover:bg-lumina-brand disabled:cursor-not-allowed disabled:opacity-40"
          >
            {t('landing.objectif_modal_continue', 'Continuer')}
            <ArrowRight className="h-4 w-4" />
          </button>
        </div>
      </div>
    </div>
  )
}

import { Check, GraduationCap, Home, Laptop, IdCard, Sparkles } from 'lucide-react'
import { fmt, fmtDec } from '@/lib/credit'
import { useTranslation } from 'react-i18next'

const MOTIF_VISUALS = {
  travaux: { icon: GraduationCap },
  auto: { icon: Home },
  tresorerie: { icon: Laptop },
  vacances: { icon: IdCard },
  autre: { icon: Sparkles },
}

export function StepProjet({ data, setField, errors, montant, duree, mensualite, coutTotal }) {
  const { t } = useTranslation()

  const MOTIFS = [
    ['travaux', t('projet.motifs.travaux')],
    ['auto', t('projet.motifs.auto')],
    ['tresorerie', t('projet.motifs.tresorerie')],
    ['vacances', t('projet.motifs.vacances')],
    ['autre', t('projet.motifs.autre')],
  ]

  return (
    <div className="flex flex-col gap-4">
      <div className="rounded-lg border border-lumina-outline bg-lumina-surface-container-low p-4">
        <p className="mb-4 text-xs font-medium tracking-widest text-lumina-on-surface-variant uppercase">
          {t('projet.simulation_title')}
        </p>
        <div className="grid gap-4 sm:grid-cols-3">
          <div>
            <p className="text-xs text-lumina-on-surface-variant">{t('projet.amount')}</p>
            <p className="font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-on-surface">
              {fmt(montant)}
            </p>
          </div>
          <div>
            <p className="text-xs text-lumina-on-surface-variant">{t('projet.duration')}</p>
            <p className="font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-on-surface">
              {t('simulator.duration_months', { n: duree })}
            </p>
          </div>
          <div>
            <p className="text-xs text-lumina-on-surface-variant">{t('projet.monthly')}</p>
            <p className="font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-secondary">
              {fmtDec(mensualite)}
            </p>
          </div>
        </div>
        <p className="mt-3 text-xs text-lumina-on-surface-variant">
          {t('projet.credit_cost')} : {fmtDec(coutTotal)}
        </p>
      </div>

      <div className="flex flex-col gap-3">
        <p className="text-sm font-medium tracking-wide text-lumina-on-surface">
          {t('projet.motif_label')}<span className="text-lumina-accent"> *</span>
        </p>
        <div className="scrollbar-hide -mx-1 flex snap-x snap-proximity gap-3 overflow-x-auto px-1 pb-1">
          {MOTIFS.map(([value, label]) => {
            const VisualIcon = MOTIF_VISUALS[value]?.icon
            return (
              <label
                key={value}
                className="group relative block aspect-square w-28 shrink-0 snap-start cursor-pointer overflow-hidden rounded-lg sm:w-32"
              >
                <input
                  type="radio"
                  name="motif"
                  value={value}
                  checked={data.motif === value}
                  onChange={() => setField('motif', value)}
                  className="peer sr-only"
                />
                <div className="flex h-full w-full flex-col items-center justify-center gap-2 bg-lumina-surface-container p-2 transition-colors peer-checked:bg-lumina-primary/10">
                  {VisualIcon && (
                    <VisualIcon className="h-8 w-8 text-lumina-primary" strokeWidth={1.5} />
                  )}
                  <span className="text-center text-xs font-semibold leading-tight text-lumina-on-surface">
                    {label}
                  </span>
                </div>
                <div
                  aria-hidden="true"
                  className="pointer-events-none absolute inset-0 border-2 border-transparent transition-colors peer-checked:border-lumina-primary"
                />
                <span className="absolute top-1.5 right-1.5 hidden h-5 w-5 items-center justify-center rounded-full bg-lumina-primary text-white peer-checked:flex">
                  <Check className="h-3 w-3" strokeWidth={3} />
                </span>
              </label>
            )
          })}
        </div>
        {errors.motif && <p className="text-xs text-lumina-error">⚠ {errors.motif}</p>}
      </div>

      <div className="flex flex-col gap-3 mt-4">
        <p className="text-sm font-medium tracking-wide text-lumina-on-surface">
          Assurance souhaitée ? <span className="text-lumina-accent"> *</span>
        </p>
        <div className="flex gap-4">
          <label className="cursor-pointer flex items-center gap-2">
            <input
              type="radio"
              name="assurance"
              checked={data.assurance === true}
              onChange={() => setField('assurance', true)}
              className="accent-lumina-primary h-4 w-4"
            />
            <span className="text-sm text-lumina-on-surface">Oui (Recommandé)</span>
          </label>
          <label className="cursor-pointer flex items-center gap-2">
            <input
              type="radio"
              name="assurance"
              checked={data.assurance === false}
              onChange={() => setField('assurance', false)}
              className="accent-lumina-primary h-4 w-4"
            />
            <span className="text-sm text-lumina-on-surface">Non</span>
          </label>
        </div>
        {data.assurance && (
          <div className="inline-flex items-center gap-2 rounded-full border border-lumina-primary/30 bg-lumina-primary/10 px-3 py-1.5 text-xs font-medium text-lumina-primary shadow-sm self-start mt-2">
            <span className="h-1.5 w-1.5 rounded-full bg-lumina-primary" />
            Assurance emprunteur incluse (100% sur une tête)
          </div>
        )}
      </div>
    </div>
  )
}

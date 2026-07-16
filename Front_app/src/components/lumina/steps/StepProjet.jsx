import { fmt, fmtDec } from '@/lib/credit'
import { cn } from '@/lib/utils'
import { useTranslation } from 'react-i18next'

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
        <div className="grid gap-3 sm:grid-cols-2">
          {MOTIFS.map(([value, label]) => (
            <label key={value} className="cursor-pointer">
              <input
                type="radio"
                name="motif"
                value={value}
                checked={data.motif === value}
                onChange={() => setField('motif', value)}
                className="peer sr-only"
              />
              <div
                className={cn(
                  'rounded-md border border-lumina-outline-variant px-3 py-2 text-sm font-medium transition-all',
                  'peer-checked:border-lumina-primary peer-checked:bg-lumina-surface-container',
                )}
              >
                {label}
              </div>
            </label>
          ))}
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

import { generateDossierId, fmt, fmtDec } from '@/lib/credit'
import { Icon } from '@/components/lumina/Icon'
import { useMemo } from 'react'
import { useTranslation } from 'react-i18next'

export function SuccessScreen({ data, montant, duree, mensualite, dossierId, onGoHome }) {
  const { t } = useTranslation()
  const id = useMemo(() => dossierId || generateDossierId(), [dossierId])

  const TIMELINE = [
    { icon: 'fact_check', title: t('success.timeline_verif_title'), desc: t('success.timeline_verif_desc'), active: true },
    { icon: 'analytics', title: t('success.timeline_analysis_title'), desc: t('success.timeline_analysis_desc'), active: false },
    { icon: 'call', title: t('success.timeline_contact_title'), desc: t('success.timeline_contact_desc'), active: false },
    { icon: 'gavel', title: t('success.timeline_decision_title'), desc: t('success.timeline_decision_desc'), active: false },
  ]

  return (
    <div className="flex min-h-svh items-center justify-center bg-lumina-background p-4 font-[family-name:var(--font-body)]">
      <div className="surface-card w-full max-w-2xl animate-[pop_0.5s_ease] p-6 md:p-8">
        <div className="mb-6 flex justify-center">
          <div className="relative flex size-16 items-center justify-center rounded-md bg-lumina-surface-container">
            <div className="absolute inset-0 animate-ping rounded-full bg-lumina-status-success/20 opacity-20" />
            <svg className="size-8 text-lumina-status-success" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={3}>
              <path strokeLinecap="round" strokeLinejoin="round" d="M20 6L9 17l-5-5" />
            </svg>
          </div>
        </div>

        <h1 className="mb-2 text-center font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-heading">
          {t('success.title')}
        </h1>
        <p className="mb-6 text-center text-sm text-lumina-on-surface-variant">
          {t('success.dossier_number')} : <strong className="text-lumina-on-surface">{id}</strong>
        </p>

        <div className="mb-6 rounded-lg border border-lumina-outline bg-lumina-surface-container-low p-4">
          <h2 className="mb-4 text-xs font-medium tracking-widest text-lumina-on-surface uppercase opacity-70">
            {t('success.next_steps')}
          </h2>
          <div className="relative">
            <div className="absolute top-6 bottom-6 left-6 w-0.5 bg-lumina-outline-variant/30" />
            {TIMELINE.map((item) => (
              <div key={item.title} className={`relative mb-6 flex gap-4 last:mb-0 ${!item.active && 'opacity-60'}`}>
                <div
                  className={`relative z-10 flex size-9 shrink-0 items-center justify-center rounded-md border-2 border-lumina-surface-lowest ${
                    item.active ? 'bg-lumina-accent text-white' : 'bg-lumina-surface-container text-lumina-on-surface-variant'
                  }`}
                >
                  <Icon name={item.icon} filled={item.active} size={18} />
                </div>
                <div className="pt-2">
                  <h3 className="font-semibold text-lumina-on-surface">{item.title}</h3>
                  <p className="text-sm text-lumina-on-surface-variant">{item.desc}</p>
                </div>
              </div>
            ))}
          </div>
        </div>

        <div className="mb-5 grid grid-cols-3 gap-3 rounded-md bg-lumina-surface-container-low p-3 text-center text-xs">
          <div>
            <p className="text-lumina-on-surface-variant">{t('success.amount')}</p>
            <p className="font-bold">{fmt(montant)}</p>
          </div>
          <div>
            <p className="text-lumina-on-surface-variant">{t('success.duration')}</p>
            <p className="font-bold">{t('simulator.duration_months', { n: duree })}</p>
          </div>
          <div>
            <p className="text-lumina-on-surface-variant">{t('success.monthly')}</p>
            <p className="font-bold text-lumina-secondary">{fmtDec(mensualite)}</p>
          </div>
        </div>

        <div className="flex flex-col gap-4 sm:flex-row sm:justify-center">
          <button type="button" onClick={onGoHome} className="btn-clenar">
            {t('success.home')}
          </button>
        </div>
        <p className="mt-6 text-center text-sm text-lumina-on-surface-variant">
          {t('success.confirmation_sent')} <strong>{data.email}</strong>
        </p>
      </div>
    </div>
  )
}

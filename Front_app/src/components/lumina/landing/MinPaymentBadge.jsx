import { TAUX_ANNUEL } from '@/lib/credit'
import { useTranslation } from 'react-i18next'

export function MinPaymentBadge() {
  const { t } = useTranslation()

  return (
    <div className="w-fit max-w-[85vw] rounded-lg bg-white/90 px-5 py-4 shadow-xl sm:max-w-[300px]">
      <p className="text-xs font-medium tracking-widest text-lumina-on-surface-variant uppercase">
        {t('landing.min_payment_label', 'À partir de')}
      </p>
      <p className="font-[family-name:var(--font-headline)] text-3xl font-bold text-lumina-heading">
        20€<span className="text-base font-medium text-lumina-on-surface-variant">{t('landing.min_payment_suffix', '/mois')}</span>
      </p>

      <div className="mt-3 border-t border-lumina-outline pt-3">
        <p className="text-sm font-semibold text-lumina-primary">
          {t('landing.taeg_label', 'TAEG fixe')} {TAUX_ANNUEL}%
        </p>
        <p className="mt-1 text-xs leading-relaxed text-lumina-on-surface-variant">
          {t('landing.taeg_desc', 'Taux Annuel Effectif Global fixe, hors assurance facultative. Exemple non contractuel.')}
        </p>
      </div>
    </div>
  )
}

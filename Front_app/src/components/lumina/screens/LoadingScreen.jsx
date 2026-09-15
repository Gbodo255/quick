import { Icon } from '@/components/lumina/Icon'
import { DotSpinner } from '@/components/lumina/DotSpinner'
import { useTranslation } from 'react-i18next'

export function LoadingScreen({ loadStep }) {
  const { t } = useTranslation()

  const STEPS = [
    ['badge', t('loading.step_id')],
    ['home', t('loading.step_rib')],
    ['monitoring', t('loading.step_profile')],
    ['mail', t('loading.step_confirm')],
  ]

  return (
    <div className="flex min-h-svh flex-col items-center justify-center bg-lumina-background px-4 font-[family-name:var(--font-body)]">
      <DotSpinner size={40} className="mb-5 text-lumina-secondary" />
      <h1 className="mb-2 font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-heading">
        {t('loading.title')}
      </h1>
      <p className="mb-8 max-w-sm text-center text-sm leading-relaxed text-lumina-on-surface-variant">
        {t('loading.subtitle')}
      </p>
      <div className="w-full max-w-xs space-y-3">
        {STEPS.map(([icon, label], i) => (
          <div
            key={label}
            className={`flex items-center gap-3 ${loadStep > i ? 'text-lumina-on-surface' : 'text-lumina-on-surface-variant'}`}
          >
            <span className="flex size-8 items-center justify-center">
              {loadStep > i ? (
                <Icon name="check_circle" filled size={22} className="text-lumina-status-success" />
              ) : (
                <Icon name={icon} size={22} />
              )}
            </span>
            <span className={`text-sm ${loadStep > i ? 'font-semibold' : ''}`}>{label}</span>
          </div>
        ))}
      </div>
    </div>
  )
}

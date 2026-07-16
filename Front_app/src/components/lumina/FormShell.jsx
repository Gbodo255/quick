import { BrandLogo } from '@/components/lumina/BrandLogo'
import { Icon } from '@/components/lumina/Icon'
import { LanguageSwitcher } from '@/components/lumina/LanguageSwitcher'
import { ProgressTracker } from '@/components/lumina/ProgressTracker'
import { FORM_STEPS } from '@/lib/credit'
import { useTranslation } from 'react-i18next'

export function FormShell({
  step,
  children,
  onQuit,
  showRecap = false,
  recap,
}) {
  const { t } = useTranslation()
  const current = FORM_STEPS[step]

  return (
    <div className="flex min-h-svh flex-col bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased">
      <header className="sticky top-0 z-50 border-b border-lumina-outline bg-lumina-surface-lowest px-4 py-3 md:px-10">
        <div className="mx-auto flex max-w-3xl items-center justify-between">
          <BrandLogo />
          <div className="flex items-center gap-3">
            <LanguageSwitcher />
            <button
              type="button"
              onClick={onQuit}
              className="flex items-center gap-2 text-sm font-medium tracking-wide text-lumina-on-surface-variant transition-colors hover:text-lumina-secondary"
            >
              <span className="hidden md:inline">{t('nav.save_quit')}</span>
              <Icon name="close" size={20} />
            </button>
          </div>
        </div>
      </header>

      <main className="mx-auto flex w-full max-w-3xl flex-1 flex-col gap-4 px-4 py-6 md:px-0 md:py-8">
        <ProgressTracker step={step} />

        {showRecap && recap}

        <div className="surface-card p-5 md:p-6">
          <div className="mb-5 flex flex-col gap-1">
            <p className="text-[11px] font-medium tracking-widest text-lumina-on-surface-variant uppercase">
              {t('form.step_label', { n: current.stepNum, total: FORM_STEPS.length })}
            </p>
            <h1 className="font-[family-name:var(--font-headline)] text-xl font-semibold tracking-tight text-lumina-heading">
              {t(`form_steps.${current.id}`, current.label)}
            </h1>
          </div>
          {children}
        </div>

        <div className="flex items-center justify-center gap-2 pb-8 text-xs text-lumina-on-surface-variant">
          <Icon name="lock" filled size={16} className="text-lumina-secondary" />
          {t('nav.ssl')}
        </div>
      </main>
    </div>
  )
}

export function FormActions({ onBack, onNext, nextLabel, isLast = false, isSubmitting = false }) {
  const { t } = useTranslation()
  return (
    <div className="mt-6 flex flex-col-reverse gap-3 border-t border-lumina-outline-variant/20 pt-5 sm:flex-row sm:justify-between">
      <button
        type="button"
        onClick={onBack}
        className="h-9 rounded-md border border-lumina-outline px-4 text-xs font-medium text-lumina-on-surface transition-colors hover:bg-lumina-surface-container-low"
      >
        {t('form.back')}
      </button>
      <button
        type="button"
        onClick={onNext}
        disabled={isSubmitting}
        className="btn-clenar flex items-center justify-center gap-2 disabled:opacity-60"
      >
        {isLast ? (
          <>
            {t('form.submit')}
            <Icon name="send" size={18} />
          </>
        ) : (
          <>
            {nextLabel || t('form.continue')}
            <Icon name="arrow_forward" size={18} />
          </>
        )}
      </button>
    </div>
  )
}

import { BrandLogo } from '@/components/lumina/BrandLogo'
import { DotSpinner } from '@/components/lumina/DotSpinner'
import { Icon } from '@/components/lumina/Icon'
import { LanguageSwitcher } from '@/components/lumina/LanguageSwitcher'
import { ProgressTracker } from '@/components/lumina/ProgressTracker'
import { FORM_STEPS } from '@/lib/credit'
import { useTranslation } from 'react-i18next'
import formSideImage from '@/assets/hero-background.jpg'

export function FormShell({
  step,
  children,
}) {
  const { t } = useTranslation()
  const current = FORM_STEPS[step]

  return (
    <div className="flex min-h-svh flex-col bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased lg:flex-row">
      <aside className="relative hidden shrink-0 lg:fixed lg:inset-y-0 lg:left-0 lg:block lg:h-svh lg:w-[42%]">
        <img
          src={formSideImage}
          alt="Étudiante souriante en ville, sac à dos et plan à la main"
          className="absolute inset-0 h-full w-full object-cover object-top"
        />
        <div aria-hidden="true" className="hero-overlay-violet absolute inset-0" />
        <div
          aria-hidden="true"
          className="absolute inset-0 bg-gradient-to-t from-black/55 via-black/5 to-transparent"
        />
        <div className="relative z-10 flex h-full flex-col justify-between p-10 xl:p-12">
          <BrandLogo variant="inverse" size="lg" />
          <div className="max-w-sm">
            <p className="font-[family-name:var(--font-headline)] text-2xl font-semibold leading-tight text-white">
              Financez vos études en toute simplicité.
            </p>
            <p className="mt-3 text-sm text-white/80">
              Un parcours guidé et sécurisé, sans caution personnelle, pensé pour les étudiants.
            </p>
          </div>
        </div>
      </aside>

      <main className="flex w-full flex-1 flex-col lg:ml-[42%]">
        <div className="flex items-center justify-between gap-3 px-4 pt-4 md:px-10 lg:justify-end">
          <BrandLogo className="lg:hidden" />
          <LanguageSwitcher />
        </div>

        <div className="mx-auto flex w-full max-w-2xl flex-1 flex-col gap-4 px-4 py-6 md:px-10 md:py-8">
          <ProgressTracker step={step} />

          <div className="surface-card p-5 md:p-6">
            <div className="mb-5">
              <h1 className="font-[family-name:var(--font-headline)] text-xl font-semibold tracking-tight text-lumina-heading">
                {t(`form_steps.${current.id}`, current.label)}
              </h1>
            </div>
            {children}
          </div>
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
        className="h-9 rounded-none border border-lumina-outline px-4 text-xs font-medium text-lumina-on-surface transition-colors hover:bg-lumina-surface-container-low"
      >
        {t('form.back')}
      </button>
      <button
        type="button"
        onClick={onNext}
        disabled={isSubmitting}
        className="btn-clenar flex items-center justify-center gap-2 disabled:opacity-60"
      >
        {isSubmitting ? (
          <>
            <DotSpinner size={16} dots={8} />
            {t('form.processing', 'Traitement…')}
          </>
        ) : isLast ? (
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

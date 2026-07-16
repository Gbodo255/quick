import { Calculator, UserPlus, ShieldCheck, Check } from 'lucide-react'
import { useTranslation } from 'react-i18next'

export function HowItWorksSection() {
  const { t } = useTranslation()
  return (
    <section id="comment" className="mx-auto max-w-6xl px-6 py-24 scroll-mt-24">
      <div className="max-w-2xl">
        <span className="inline-flex items-center gap-2 rounded-full border border-lumina-outline bg-lumina-surface-lowest px-3 py-1 text-xs font-medium text-lumina-on-surface shadow-sm">
          {t('landing.how_badge', 'Comment ça marche')}
        </span>
        <h2 className="mt-4 font-[family-name:var(--font-headline)] text-4xl leading-tight font-semibold md:text-5xl text-balance text-lumina-heading">
          {t('landing.how_title', 'De la simu à la signature, en 3 étapes.')}
        </h2>
        <p className="mt-4 text-lumina-on-surface-variant text-lg">
          {t('landing.how_subtitle', 'Pas de paperasse inutile, pas de jargon. Un conseiller humain, une plateforme claire.')}
        </p>
      </div>
      
      <div className="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
        <div className="surface-card p-6 transition-transform hover:-translate-y-1 hover:shadow-lg">
          <header className="flex items-center gap-4">
            <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-lumina-surface-container text-lumina-primary">
              <Calculator className="h-6 w-6" />
            </div>
            <div className="min-w-0">
              <p className="font-[family-name:var(--font-headline)] text-xs font-bold text-lumina-outline-variant leading-none">01</p>
              <h3 className="mt-1 font-[family-name:var(--font-headline)] text-lg font-semibold text-lumina-heading leading-tight">
                {t('landing.step1_title', 'Tu simules')}
              </h3>
            </div>
          </header>
          <p className="mt-4 text-sm leading-relaxed text-lumina-on-surface-variant font-medium">
            {t('landing.step1_text', "Ajuste les curseurs pour ton projet. Tu vois ta mensualité et ta capacité d'emprunt en 30 secondes. Gratuit, anonyme.")}
          </p>
        </div>
        
        <div className="surface-card p-6 transition-transform hover:-translate-y-1 hover:shadow-lg border-lumina-primary/30">
          <header className="flex items-center gap-4">
            <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-lumina-primary/10 text-lumina-primary">
              <UserPlus className="h-6 w-6" />
            </div>
            <div className="min-w-0">
              <p className="font-[family-name:var(--font-headline)] text-xs font-bold text-lumina-outline-variant leading-none">02</p>
              <h3 className="mt-1 font-[family-name:var(--font-headline)] text-lg font-semibold text-lumina-heading leading-tight">
                {t('landing.step2_title', "Tu t'inscris")}
              </h3>
            </div>
          </header>
          <p className="mt-4 text-sm leading-relaxed text-lumina-on-surface-variant font-medium">
            {t('landing.step2_text', "2 minutes pour créer ton compte. Un conseiller dédié te rappelle sous 24h pour cadrer ton projet de financement.")}
          </p>
        </div>
        
        <div className="surface-card p-6 transition-transform hover:-translate-y-1 hover:shadow-lg">
          <header className="flex items-center gap-4">
            <div className="flex h-12 w-12 shrink-0 items-center justify-center rounded-2xl bg-lumina-surface-container text-lumina-primary">
              <ShieldCheck className="h-6 w-6" />
            </div>
            <div className="min-w-0">
              <p className="font-[family-name:var(--font-headline)] text-xs font-bold text-lumina-outline-variant leading-none">03</p>
              <h3 className="mt-1 font-[family-name:var(--font-headline)] text-lg font-semibold text-lumina-heading leading-tight">
                {t('landing.step3_title', "On défend ton dossier")}
              </h3>
            </div>
          </header>
          <p className="mt-4 text-sm leading-relaxed text-lumina-on-surface-variant font-medium">
            {t('landing.step3_text', "On constitue ton dossier et on le présente à nos 30+ banques partenaires. Tu compares les offres, tu signes la meilleure.")}
          </p>
        </div>
      </div>
      
      <div className="mt-10 flex flex-col items-center gap-4 rounded-[2rem] bg-gradient-to-br from-lumina-primary to-[#4a38a8] p-8 text-center text-white md:flex-row md:gap-8 md:text-left shadow-lg">
        <div className="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-white text-lumina-primary shadow-sm">
          <Check className="h-8 w-8" strokeWidth={3} />
        </div>
        <div className="flex-1">
          <p className="font-[family-name:var(--font-headline)] font-semibold text-2xl md:text-3xl leading-tight">
            {t('landing.how_bottom_title', "Quelques jours plus tard : ton prêt validé, au meilleur taux.")}
          </p>
          <p className="mt-2 text-white/80 font-medium">
            {t('landing.how_bottom_text', "On défend ton dossier auprès de nos banques partenaires. Tu compares les offres, tu signes celle qui te va.")}
          </p>
        </div>
      </div>
    </section>
  )
}

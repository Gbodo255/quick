import { BrandLogo } from '@/components/lumina/BrandLogo'
import { LanguageSwitcher } from '@/components/lumina/LanguageSwitcher'
import { useTranslation } from 'react-i18next'

export function HeaderSection({ onStart, onOpenBlog }) {
  const { t } = useTranslation()

  return (
    <header className="sticky top-0 z-40 bg-lumina-surface-lowest/80 backdrop-blur-md border-b border-lumina-outline">
      <div className="mx-auto grid max-w-6xl grid-cols-[auto_1fr_auto] items-center gap-4 px-6 py-3">
        <a className="inline-flex items-center gap-2 transition hover:opacity-90" aria-label="Accueil" href="/">
          <BrandLogo size="lg" />
        </a>
        
        <nav className="hidden md:flex items-center gap-6 text-sm font-medium">
          <a className="px-3 py-2 text-lumina-on-surface-variant hover:text-lumina-heading transition" href="#simulateur">
            {t('landing.simulator', 'Simulateur')}
          </a>
          <a className="px-3 py-2 text-lumina-on-surface-variant hover:text-lumina-heading transition" href="#comment">
            {t('landing.cta_how')}
          </a>
          <a className="px-3 py-2 text-lumina-on-surface-variant hover:text-lumina-heading transition" href="#avis">
            {t('landing.reviews', 'Avis')}
          </a>
          <button onClick={onOpenBlog} className="px-3 py-2 text-lumina-on-surface-variant hover:text-lumina-heading transition cursor-pointer">
            Conseils
          </button>
        </nav>
        
        <div className="justify-self-end flex items-center gap-2 sm:gap-4 text-sm">
          <LanguageSwitcher />
          <a href="#simulateur" className="btn-clenar py-2 px-4 text-sm inline-flex items-center justify-center">
            {t('landing.get_loan', 'Obtenir mon prêt')}
          </a>
        </div>
      </div>
    </header>
  )
}

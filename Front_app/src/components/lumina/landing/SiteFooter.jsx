import { useTranslation } from 'react-i18next'
import { BrandLogo } from '@/components/lumina/BrandLogo'
import { BRAND_WORDMARK } from '@/lib/credit'

function FooterLink({ href = '#', children, onClick }) {
  const cls = 'text-sm text-white/70 transition-colors hover:text-white cursor-pointer'
  if (onClick) return <button type="button" onClick={onClick} className={cls}>{children}</button>
  return <a href={href} className={cls}>{children}</a>
}

function FooterColumn({ title, children }) {
  return (
    <div className="flex flex-col items-start gap-5 text-left">
      <p className="text-sm font-semibold text-white">{title}</p>
      {children}
    </div>
  )
}

export function SiteFooter({ onPrivacy, onOpenAbout, onOpenLegal, onOpenFaq, onOpenContact, onOpenPretEtudiant, onOpenEligibilite, onOpenSimulator, onOpenObjectifModal }) {
  const { t } = useTranslation()
  const year = new Date().getFullYear()

  return (
    <footer className="border-t border-white/10 bg-lumina-heading">
      {/* ── Top section ── */}
      <div className="mx-auto flex min-h-[60svh] max-w-6xl flex-col justify-center px-6 py-16">
        <div className="grid grid-cols-1 gap-12 lg:grid-cols-[1.3fr_1fr_1fr_1fr]">

          {/* Brand bloc */}
          <div className="flex flex-col items-start gap-5 text-left">
            <BrandLogo variant="inverse" size="lg" />
            <p className="max-w-xs leading-relaxed text-white/70">
              {t('landing.footer_tagline', 'Le prêt étudiant pensé pour financer vos études, sans caution personnelle.')}
            </p>
            <button
              type="button"
              onClick={onOpenObjectifModal}
              className="inline-flex h-10 items-center justify-center rounded-md bg-lumina-accent px-6 text-xs font-medium text-white transition-colors hover:bg-lumina-brand"
            >
              {t('landing.sticky_cta', 'Faire mon prêt')}
            </button>
          </div>

          {/* Le prêt */}
          <FooterColumn title={t('landing.footer_col_produit', 'Le prêt')}>
            <FooterLink onClick={onOpenPretEtudiant}>{t('landing.footer_pret_etudiant', 'Le prêt étudiant')}</FooterLink>
            <FooterLink onClick={onOpenEligibilite}>{t('landing.footer_eligibilite', 'Éligibilité')}</FooterLink>
            <FooterLink onClick={onOpenSimulator}>{t('landing.footer_simulator', 'Simulation')}</FooterLink>
            <FooterLink onClick={onOpenFaq}>{t('landing.footer_faq', 'FAQ')}</FooterLink>
          </FooterColumn>

          {/* Informations */}
          <FooterColumn title={t('landing.footer_col_legal', 'Informations')}>
            <FooterLink onClick={onOpenAbout}>{t('landing.footer_about', 'À propos')}</FooterLink>
            <FooterLink onClick={onOpenLegal}>{t('landing.footer_legal', 'Mentions légales & CGU')}</FooterLink>
            <FooterLink onClick={onPrivacy}>{t('landing.footer_privacy', 'Confidentialité (RGPD)')}</FooterLink>
            <FooterLink onClick={onPrivacy}>{t('landing.footer_cookies', 'Politique de cookies')}</FooterLink>
          </FooterColumn>

          {/* Contact — poussé complètement à droite */}
          <div className="flex flex-col items-start gap-3 text-left">
            <p className="text-sm font-semibold text-white">{t('landing.footer_col_contact', 'Contact')}</p>
            <div className="space-y-1 text-sm text-white/70">
              <a href="tel:+33780961216" className="block transition-colors hover:text-white">+33 7 80 96 12 16</a>
              <a href="mailto:contacts@studcredit.com" className="block transition-colors hover:text-white">contacts@studcredit.com</a>
            </div>
            <button
              type="button"
              onClick={onOpenContact}
              className="mt-1 inline-flex h-12 items-center justify-center rounded-md bg-lumina-primary px-10 text-sm font-medium text-white transition-colors hover:bg-lumina-brand"
            >
              {t('landing.footer_contact_cta', 'Nous contacter')}
            </button>
          </div>

        </div>
      </div>

      {/* ── Bottom bar ── */}
      <div className="border-t border-white/10">
        <div className="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-6 py-4 md:flex-row">
          <p className="text-xs text-white/60">
            © {year}{' '}
            <span className="font-semibold text-white">
              {BRAND_WORDMARK.prefix}<span className="text-lumina-accent-lilac">{BRAND_WORDMARK.accent}</span>
            </span>
            {' '}— {t('landing.footer_rights', 'Tous droits réservés.')}
          </p>
          <p className="text-xs text-white/60 text-center md:text-right">
            {t('landing.footer_disclaimer', 'Étude gratuite et sans engagement.')}
            <br className="hidden md:block" />
            {t('landing.footer_disclaimer2', "L'emprunt vous engage et doit être remboursé.")}
          </p>
        </div>
      </div>
    </footer>
  )
}

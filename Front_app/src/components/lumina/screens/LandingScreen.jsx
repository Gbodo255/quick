import { useTranslation } from 'react-i18next'
import { BrandLogo } from '@/components/lumina/BrandLogo'
import { BRAND, BRAND_WORDMARK } from '@/lib/credit'

import { HeaderSection } from '../landing/HeaderSection'
import { HeroSection } from '../landing/HeroSection'
import { PartnersSection } from '../landing/PartnersSection'
import { HowItWorksSection } from '../landing/HowItWorksSection'
import { ClientSpaceSection } from '../landing/ClientSpaceSection'
import { ReviewsSection } from '../landing/ReviewsSection'

// ── Footer ──────────────────────────────────────────────────────────────────

function FooterLink({ href = '#', children, onClick }) {
  const cls = 'text-sm text-lumina-on-surface-variant transition-colors hover:text-lumina-heading cursor-pointer'
  if (onClick) return <button type="button" onClick={onClick} className={cls}>{children}</button>
  return <a href={href} className={cls}>{children}</a>
}

function FooterColumn({ title, children }) {
  return (
    <div className="flex flex-col gap-3">
      <p className="text-sm font-semibold text-lumina-on-surface">{title}</p>
      {children}
    </div>
  )
}

function SiteFooter({ onPrivacy, onOpenAbout, onOpenLegal, onOpenFaq, onOpenContact }) {
  const { t } = useTranslation()
  const year = new Date().getFullYear()

  return (
    <footer className="border-t border-lumina-outline bg-lumina-surface-lowest">
      {/* ── Top section ── */}
      <div className="mx-auto max-w-6xl px-6 py-12">
        <div className="grid grid-cols-1 gap-10 md:grid-cols-[2fr_1fr_1fr_1fr]">

          {/* Brand bloc */}
          <div className="flex flex-col gap-4">
            <BrandLogo variant="footer" />
            <p className="max-w-[260px] text-sm leading-relaxed text-lumina-on-surface-variant">
              {t('landing.footer_tagline', 'Courtier en crédit immobilier & prêt à la consommation.')}
            </p>
            <div className="rounded-lg bg-lumina-surface-container/60 p-3 border border-lumina-outline-variant/40 text-xs space-y-1">
              <p className="font-bold text-lumina-heading">Julien Verran</p>
              <p className="text-lumina-secondary font-medium">Courtier en crédit immobilier &amp; prêt à la consommation</p>
              <p className="font-semibold text-lumina-on-surface pt-1">
                📞 <a href="tel:+33780961216" className="hover:underline text-lumina-heading">+33 7 80 96 12 16</a>
              </p>
              <p className="text-lumina-on-surface-variant">
                ✉️ <a href="mailto:support@crediteco.app" className="hover:underline">support@crediteco.app</a>
              </p>
            </div>
            <p className="text-xs leading-relaxed text-lumina-on-surface-variant">
              <span className="font-semibold text-lumina-on-surface">{BRAND_WORDMARK.prefix}{BRAND_WORDMARK.accent}</span>{' '}
              {t('landing.footer_legal_entity', 'est une marque de')}{' '}
              <span className="font-bold text-lumina-on-surface uppercase">PRIVILEGE FINANCE</span>
            </p>
          </div>

          {/* Produit */}
          <FooterColumn title={t('landing.footer_col_produit', 'Produit')}>
            <FooterLink href="#simulator">{t('landing.footer_simulator', 'Simulateur')}</FooterLink>
            <FooterLink href="#how">{t('landing.footer_how', 'Comment ça marche')}</FooterLink>
            <FooterLink href="#reviews">{t('landing.footer_reviews', 'Avis clients')}</FooterLink>
            <FooterLink onClick={onOpenFaq}>{t('landing.footer_faq', 'FAQ')}</FooterLink>
          </FooterColumn>

          {/* Compte */}
          <FooterColumn title={t('landing.footer_col_compte', 'Compte')}>
            <FooterLink href="#login">{t('landing.footer_login', 'Connexion')}</FooterLink>
            <FooterLink href="#signup">{t('landing.footer_signup', 'Créer un compte')}</FooterLink>
            <FooterLink href="#space">{t('landing.footer_space', 'Mon espace')}</FooterLink>
          </FooterColumn>

          {/* Légal & E-E-A-T */}
          <FooterColumn title={t('landing.footer_col_legal', 'Légal')}>
            <FooterLink onClick={onOpenAbout}>{t('landing.footer_about', 'À propos')}</FooterLink>
            <FooterLink onClick={onOpenContact}>{t('landing.footer_contact', 'Contact')}</FooterLink>
            <FooterLink onClick={onOpenLegal}>{t('landing.footer_legal', 'Mentions légales & CGU')}</FooterLink>
            <FooterLink onClick={onPrivacy}>{t('landing.footer_privacy', 'Confidentialité (RGPD)')}</FooterLink>
          </FooterColumn>

        </div>
      </div>

      {/* ── Bottom bar ── */}
      <div className="border-t border-lumina-outline">
        <div className="mx-auto flex max-w-6xl flex-col items-center justify-between gap-3 px-6 py-4 md:flex-row">
          <p className="text-xs text-lumina-on-surface-variant">
            © {year}{' '}
            <span className="font-semibold">
              {BRAND_WORDMARK.prefix}<span className="text-lumina-secondary">{BRAND_WORDMARK.accent}</span>
            </span>
            {' '}— {t('landing.footer_rights', 'Tous droits réservés.')}
          </p>
          <p className="text-xs text-lumina-on-surface-variant text-center md:text-right">
            {t('landing.footer_disclaimer', 'Étude gratuite et sans engagement.')}
            <br className="hidden md:block" />
            {t('landing.footer_disclaimer2', "L'emprunt vous engage et doit être remboursé.")}
          </p>
        </div>
      </div>
    </footer>
  )
}

// ── Screen ───────────────────────────────────────────────────────────────────

export default function LandingScreen({
  montant,
  setMontant,
  duree,
  setDuree,
  mensualite,
  motif,
  setMotif,
  revenuEstime,
  setRevenuEstime,
  coutTotal,
  totalRembourse,
  errors = {},
  onStart,
  onPrivacy,
  onOpenAbout,
  onOpenLegal,
  onOpenFaq,
  onOpenContact,
  onOpenBlog,
  isLoading = false,
}) {
  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased">
      <HeaderSection onStart={onStart} onOpenBlog={onOpenBlog} />
      
      <main>
        <HeroSection 
          montant={montant}
          setMontant={setMontant}
          duree={duree}
          setDuree={setDuree}
          mensualite={mensualite}
          coutTotal={coutTotal}
          totalRembourse={totalRembourse}
          motif={motif}
          setMotif={setMotif}
          revenuEstime={revenuEstime}
          setRevenuEstime={setRevenuEstime}
          onStart={onStart}
          isLoading={isLoading}
        />
        
        <PartnersSection />
        
        <HowItWorksSection />
        
        <ClientSpaceSection />
        
        <ReviewsSection />
      </main>

      <SiteFooter 
        onPrivacy={onPrivacy}
        onOpenAbout={onOpenAbout}
        onOpenLegal={onOpenLegal}
        onOpenFaq={onOpenFaq}
        onOpenContact={onOpenContact}
      />
    </div>
  )
}

import { TopAnnouncementBar } from '../landing/TopAnnouncementBar'
import { HeroSection } from '../landing/HeroSection'
import { ProductPillarsSection } from '../landing/ProductPillarsSection'
import { HowItWorksSection } from '../landing/HowItWorksSection'
import { ReviewsSection } from '../landing/ReviewsSection'
import { TransparencyBanner } from '../landing/TransparencyBanner'
import { FaqSection } from '../landing/FaqSection'
import { SiteFooter } from '../landing/SiteFooter'
import { StickyCtaBar } from '../landing/StickyCtaBar'
import { Reveal } from '../landing/Reveal'

// ── Screen ───────────────────────────────────────────────────────────────────

export default function LandingScreen({
  montant,
  setMontant,
  duree,
  setDuree,
  motif,
  setMotif,
  revenuEstime,
  setRevenuEstime,
  onStart,
  onPrivacy,
  onOpenAbout,
  onOpenLegal,
  onOpenFaq,
  onOpenContact,
  onOpenPretEtudiant,
  onOpenEligibilite,
  onOpenObjectifModal,
  onStartWithMotif,
  isLoading = false,
}) {
  const selectPillar = (key) => {
    setMotif(key)
    onStartWithMotif?.(key)
  }

  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased">
      <TopAnnouncementBar />

      <main>
        <HeroSection
          montant={montant}
          setMontant={setMontant}
          duree={duree}
          setDuree={setDuree}
          motif={motif}
          setMotif={setMotif}
          revenuEstime={revenuEstime}
          setRevenuEstime={setRevenuEstime}
          onStart={onStart}
          isLoading={isLoading}
        />

        <Reveal><ProductPillarsSection onSelect={selectPillar} /></Reveal>

        <Reveal><HowItWorksSection onOpenObjectifModal={onOpenObjectifModal} /></Reveal>

        <Reveal><ReviewsSection /></Reveal>

        <Reveal><TransparencyBanner /></Reveal>

        <Reveal><FaqSection onOpenFaq={onOpenFaq} /></Reveal>
      </main>

      <SiteFooter 
        onPrivacy={onPrivacy}
        onOpenAbout={onOpenAbout}
        onOpenLegal={onOpenLegal}
        onOpenFaq={onOpenFaq}
        onOpenContact={onOpenContact}
        onOpenPretEtudiant={onOpenPretEtudiant}
        onOpenEligibilite={onOpenEligibilite}
        onOpenSimulator={() => document.getElementById('simulateur')?.scrollIntoView({ behavior: 'smooth', block: 'start' })}
        onOpenObjectifModal={onOpenObjectifModal}
      />

      <StickyCtaBar onOpenObjectifModal={onOpenObjectifModal} />
    </div>
  )
}

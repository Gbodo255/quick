import heroBackground from '@/assets/hero-background.jpg'
import { SimulatorPanel } from '@/components/lumina/SimulatorPanel'
import { MinPaymentBadge } from '@/components/lumina/landing/MinPaymentBadge'

export function HeroSection({
  montant,
  setMontant,
  duree,
  setDuree,
  motif,
  setMotif,
  revenuEstime,
  setRevenuEstime,
  onStart,
  isLoading,
}) {
  return (
    <section id="simulateur" className="relative w-full scroll-mt-0 overflow-hidden">
      <img
        src={heroBackground}
        alt="Étudiante souriante en ville, sac à dos et plan à la main"
        className="absolute inset-0 h-full w-full object-cover object-top"
      />
      <div
        aria-hidden="true"
        className="absolute inset-0 bg-gradient-to-r from-black/40 via-black/10 to-black/40"
      />

      <div className="relative z-10 mx-auto flex min-h-[95svh] max-w-6xl flex-col gap-6 px-6 py-10 md:h-[95svh] md:justify-center md:py-0">
        <div className="w-full md:ml-auto md:max-w-sm">
          <SimulatorPanel
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
        </div>

        <div className="md:absolute md:bottom-10 md:left-10">
          <MinPaymentBadge />
        </div>
      </div>
    </section>
  )
}

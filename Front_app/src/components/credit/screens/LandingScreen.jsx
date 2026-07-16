import { BrandLogo } from '@/components/credit/BrandLogo'
import { SimulatorCard } from '@/components/credit/SimulatorCard'
import { BRAND, calcMensualite, fmtDec } from '@/lib/credit'

const TRUST_HERO = [
  ['🔒', '100% sécurisé'],
  ['⚡', 'Réponse rapide'],
  ['📱', '100% en ligne'],
  ['✅', 'Sans engagement'],
]

const TRUST_STRIP = [
  ['🏛️', 'Conforme ACPR'],
  ['🔐', 'Données chiffrées SSL'],
  ['🇫🇷', 'Société française'],
  ['📋', 'RGPD compliant'],
  ['⭐', '4.8/5 · 1 200 avis'],
]

export function LandingScreen({
  montant,
  setMontant,
  duree,
  setDuree,
  mensualite,
  totalRembourse,
  coutTotal,
  onStart,
}) {
  return (
    <div className="min-h-svh bg-gray-50">
      <section className="relative overflow-hidden bg-gradient-to-br from-[#0A0F1E] via-[#1a2236] to-[#0d1a3a] px-5">
        <div className="pointer-events-none absolute -top-48 -right-48 size-[600px] rounded-full bg-[radial-gradient(circle,rgba(245,200,66,0.12)_0%,transparent_70%)]" />
        <div className="pointer-events-none absolute -bottom-24 -left-24 size-[400px] rounded-full bg-[radial-gradient(circle,rgba(16,185,129,0.08)_0%,transparent_70%)]" />

        <nav className="relative z-10 mx-auto flex max-w-[1100px] items-center justify-between py-6">
          <BrandLogo light />
          <span className="rounded-full border border-[#F5C842]/30 bg-[#F5C842]/15 px-3.5 py-1.5 text-xs font-semibold tracking-wide text-[#F5C842]">
            🔒 100% Sécurisé · RGPD
          </span>
        </nav>

        <div className="relative z-10 mx-auto grid max-w-[1100px] items-center gap-8 py-12 pb-20 md:grid-cols-2 md:gap-[60px] md:py-15">
          <div>
            <span className="mb-5 inline-flex items-center gap-2 rounded-full border border-emerald-500/30 bg-emerald-500/15 px-3.5 py-1.5 text-xs font-semibold tracking-wide text-emerald-400 before:text-[8px] before:content-['●']">
              Réponse en 60 minutes
            </span>
            <h1 className="mb-5 font-[family-name:var(--font-sora)] text-3xl leading-tight font-extrabold tracking-tight text-white md:text-5xl">
              On vous débloque
              <br />
              votre crédit en
              <br />
              <span className="text-[#F5C842]">60 minutes</span> ⚡
            </h1>
            <p className="mb-8 max-w-[460px] text-base leading-relaxed text-white/65">
              Simulez votre crédit, uploadez vos documents et recevez une réponse
              rapide. Sans engagement, sans frais cachés.
            </p>
            <div className="flex flex-wrap gap-6">
              {TRUST_HERO.map(([ico, t]) => (
                <div key={t} className="flex items-center gap-2 text-[13px] font-medium text-white/70">
                  <span className="flex size-7 items-center justify-center rounded-lg bg-[#F5C842]/15 text-sm">
                    {ico}
                  </span>
                  {t}
                </div>
              ))}
            </div>
          </div>
          <SimulatorCard
            montant={montant}
            setMontant={setMontant}
            duree={duree}
            setDuree={setDuree}
            mensualite={mensualite}
            totalRembourse={totalRembourse}
            coutTotal={coutTotal}
            onStart={onStart}
          />
        </div>
      </section>

      <div className="border-t border-gray-200 bg-white px-5 py-5">
        <div className="mx-auto flex max-w-[1100px] flex-wrap justify-center gap-10">
          {TRUST_STRIP.map(([ico, t]) => (
            <div key={t} className="flex items-center gap-2 text-[13px] font-medium text-gray-500">
              <span>{ico}</span> {t}
            </div>
          ))}
        </div>
      </div>

      <Footer />
    </div>
  )
}

export function Footer() {
  const mensEx = fmtDec(calcMensualite(5000, 36))
  const coutEx = fmtDec(calcMensualite(5000, 36) * 36 - 5000)

  return (
    <footer className="bg-[#0A0F1E] px-5 py-10 text-center">
      <div className="mb-3 flex justify-center">
        <BrandLogo light />
      </div>
      <p className="mx-auto max-w-[600px] text-[11px] leading-relaxed text-white/35">
        Un crédit vous engage et doit être remboursé. Vérifiez vos capacités de
        remboursement avant de vous engager. Exemple : pour un crédit de 5 000€ sur
        36 mois à un TAEG de 5,90%, vous remboursez 36 mensualités de {mensEx} soit
        un coût total de {coutEx}.
        <br />© 2024 {BRAND} SAS – RCS Paris · ORIAS n°XX XXX XXX
      </p>
    </footer>
  )
}

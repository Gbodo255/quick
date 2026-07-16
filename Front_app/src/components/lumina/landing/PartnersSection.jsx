import { Landmark } from 'lucide-react'

const BANKS = [
  { name: "BNP Paribas", logo: "/logos/BNB parisbas.svg" },
  { name: "Société Générale", logo: "/logos/societe generale.svg" },
  { name: "Crédit Agricole", logo: "/logos/creditagricole.png" },
  { name: "Crédit Mutuel", logo: "/logos/credit mutuel.png" },
  { name: "LCL", logo: "/logos/LCL.svg" },
  { name: "Caisse d'Épargne", logo: "/logos/caisse epargne.webp" },
  { name: "Banque Populaire", logo: "/logos/banque populaire.webp" },
  { name: "HSBC", logo: "/logos/HSBC.svg" },
  { name: "La Banque Postale", logo: "/logos/banque postale.svg" }
]

export function PartnersSection() {
  return (
    <section className="border-y border-lumina-outline bg-lumina-surface-light py-12">
      <div className="mx-auto max-w-6xl px-6">
        <p className="mb-8 text-center text-xs uppercase tracking-[0.18em] font-semibold text-lumina-on-surface-variant">
          Nos 30+ banques partenaires
        </p>
        
        <div className="relative overflow-hidden" style={{ maskImage: 'linear-gradient(to right, transparent, #000 8%, #000 92%, transparent)', WebkitMaskImage: 'linear-gradient(to right, transparent, #000 8%, #000 92%, transparent)' }}>
          <div className="flex w-max gap-10 animate-marquee">
            {/* Double the array for seamless infinite scrolling */}
            {[...BANKS, ...BANKS, ...BANKS].map((bank, index) => (
              <div key={index} className="flex shrink-0 flex-col items-center gap-3 px-2">
                <div className="flex h-14 w-14 items-center justify-center overflow-hidden rounded-2xl border border-lumina-outline bg-white shadow-sm p-1.5">
                  <img src={bank.logo} alt={bank.name} className="h-full w-full object-contain" onError={(e) => { e.target.style.display = 'none'; e.target.nextSibling.style.display = 'block'; }} />
                  <Landmark className="h-6 w-6 text-lumina-primary hidden" />
                </div>
                <span className="whitespace-nowrap text-xs font-semibold text-lumina-on-surface-variant">
                  {bank.name}
                </span>
              </div>
            ))}
          </div>
        </div>
      </div>
    </section>
  )
}

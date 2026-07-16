import { TAUX_ANNUEL, fmt, fmtDec } from '@/lib/credit'

export function RecapCard({ montant, duree, mensualite }) {
  return (
    <div className="mb-8 flex flex-wrap items-center justify-between gap-4 rounded-[20px] bg-gradient-to-br from-[#0A0F1E] to-[#1a2236] p-6">
      <div>
        <p className="text-[11px] text-white/50">Montant souhaité</p>
        <p className="font-[family-name:var(--font-sora)] text-lg font-bold text-[#F5C842]">
          {fmt(montant)}
        </p>
      </div>
      <div>
        <p className="text-[11px] text-white/50">Durée</p>
        <p className="font-[family-name:var(--font-sora)] text-lg font-bold text-white">
          {duree} mois
        </p>
      </div>
      <div>
        <p className="text-[11px] text-white/50">Mensualité estimée</p>
        <p className="font-[family-name:var(--font-sora)] text-lg font-bold text-white">
          {fmtDec(mensualite)}/mois
        </p>
      </div>
      <div>
        <p className="text-[11px] text-white/50">TAEG</p>
        <p className="font-[family-name:var(--font-sora)] text-lg font-bold text-white">
          {TAUX_ANNUEL}%
        </p>
      </div>
    </div>
  )
}

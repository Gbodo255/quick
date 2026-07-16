import { Button } from '@/components/ui/button'
import {
  DUREES,
  MONTANTS_RAPIDES,
  TAUX_ANNUEL,
  fmt,
  fmtDec,
} from '@/lib/credit'
import { cn } from '@/lib/utils'

export function SimulatorCard({
  montant,
  setMontant,
  duree,
  setDuree,
  mensualite,
  totalRembourse,
  coutTotal,
  onStart,
}) {
  const sliderPct = ((montant - 500) / (75000 - 500)) * 100

  return (
    <div className="relative z-10 rounded-3xl bg-white p-9 shadow-[0_40px_80px_rgba(0,0,0,0.3)]">
      <h2 className="mb-6 font-[family-name:var(--font-sora)] text-[17px] font-bold text-[#0A0F1E]">
        💰 Simulez votre crédit
      </h2>

      <div className="mb-2.5 flex items-baseline justify-between">
        <span className="text-[13px] font-medium text-gray-500">Montant souhaité</span>
        <span className="font-[family-name:var(--font-sora)] text-[22px] font-extrabold text-[#0A0F1E]">
          {fmt(montant)}
        </span>
      </div>
      <input
        type="range"
        min={500}
        max={75000}
        step={500}
        value={montant}
        onChange={(e) => setMontant(+e.target.value)}
        className="mb-2 h-1.5 w-full cursor-pointer appearance-none rounded-full bg-gray-200 accent-[#0A0F1E]"
        style={{
          background: `linear-gradient(to right, #0A0F1E ${sliderPct}%, #E5E7EB ${sliderPct}%)`,
        }}
      />
      <div className="mb-6 flex flex-wrap gap-2">
        {MONTANTS_RAPIDES.map((m) => (
          <button
            key={m}
            type="button"
            onClick={() => setMontant(m)}
            className={cn(
              'rounded-full border-[1.5px] px-3 py-1.5 text-xs font-semibold transition-all',
              montant === m
                ? 'border-[#0A0F1E] bg-[#0A0F1E] text-white'
                : 'border-gray-200 text-gray-500 hover:border-[#0A0F1E]',
            )}
          >
            {fmt(m)}
          </button>
        ))}
      </div>

      <p className="mb-2.5 text-[13px] font-medium text-gray-500">Durée de remboursement</p>
      <div className="mb-6 grid grid-cols-3 gap-2">
        {DUREES.map((d) => (
          <button
            key={d}
            type="button"
            onClick={() => setDuree(d)}
            className={cn(
              'rounded-[10px] border-[1.5px] px-1 py-2.5 text-center text-[13px] font-semibold transition-all',
              duree === d
                ? 'border-[#F5C842] bg-[#FFFBEB] text-[#0A0F1E]'
                : 'border-gray-200 text-gray-500 hover:border-[#F5C842]',
            )}
          >
            {d < 24 ? `${d} mois` : `${d / 12} ans`}
            <span className="mt-0.5 block text-[10px] font-normal text-gray-400">
              {d} mois
            </span>
          </button>
        ))}
      </div>

      <div className="mb-5 rounded-2xl bg-gradient-to-br from-[#0A0F1E] to-[#1a2236] px-6 py-5">
        <p className="text-xs font-medium text-white/60">Mensualité estimée</p>
        <p className="font-[family-name:var(--font-sora)] text-[34px] font-extrabold text-[#F5C842]">
          {fmtDec(mensualite)}
          <span className="ml-1 text-base font-normal text-white/60">/mois</span>
        </p>
        <div className="mt-2.5 flex flex-wrap gap-4">
          <span className="text-[11px] text-white/50">
            Total : <strong className="text-white/80">{fmtDec(totalRembourse)}</strong>
          </span>
          <span className="text-[11px] text-white/50">
            Coût crédit : <strong className="text-white/80">{fmtDec(coutTotal)}</strong>
          </span>
          <span className="text-[11px] text-white/50">
            TAEG : <strong className="text-white/80">{TAUX_ANNUEL}%</strong>
          </span>
        </div>
      </div>

      <Button
        type="button"
        onClick={onStart}
        className="h-auto w-full rounded-[14px] bg-[#F5C842] py-[18px] font-[family-name:var(--font-sora)] text-base font-bold text-[#0A0F1E] hover:bg-[#E6B830] hover:shadow-[0_8px_24px_rgba(245,200,66,0.4)]"
      >
        Obtenir mon crédit → 60 min ⚡
      </Button>
      <p className="mt-2.5 text-center text-[10px] leading-relaxed text-gray-400">
        Sans engagement · Sans frais de dossier · Réponse immédiate
        <br />
        Un crédit vous engage et doit être remboursé.
      </p>
    </div>
  )
}

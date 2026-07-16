import { TAUX_ANNUEL, fmt, fmtDec } from '@/lib/credit'

export function CreditRecapBar({ montant, duree, mensualite }) {
  return (
    <div className="surface-card flex flex-wrap items-center justify-between gap-3 px-4 py-3">
      <div>
        <p className="text-[10px] font-medium tracking-widest text-lumina-on-surface-variant uppercase">
          Montant
        </p>
        <p className="font-[family-name:var(--font-headline)] font-semibold text-lumina-heading">
          {fmt(montant)}
        </p>
      </div>
      <div>
        <p className="text-[10px] font-medium tracking-widest text-lumina-on-surface-variant uppercase">
          Durée
        </p>
        <p className="font-[family-name:var(--font-headline)] font-semibold text-lumina-on-surface">
          {duree} mois
        </p>
      </div>
      <div>
        <p className="text-[10px] font-medium tracking-widest text-lumina-on-surface-variant uppercase">
          Mensualité
        </p>
        <p className="font-[family-name:var(--font-headline)] font-semibold text-lumina-secondary">
          {fmtDec(mensualite)}
        </p>
      </div>
      <div>
        <p className="text-[10px] font-medium tracking-widest text-lumina-on-surface-variant uppercase">
          TAEG
        </p>
        <p className="font-[family-name:var(--font-headline)] font-semibold text-lumina-on-surface">
          {TAUX_ANNUEL}%
        </p>
      </div>
    </div>
  )
}

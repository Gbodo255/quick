import { fmt, fmtDec } from '@/lib/credit'

const TIMELINE = [
  ['done', '✅', 'Dossier reçu', 'Votre demande a bien été enregistrée'],
  ['done', '🔍', 'Vérification documents', 'Identité et RIB vérifiés avec succès'],
  ['pending', '📞', 'Appel de confirmation', 'Un conseiller vous contacte sous 60 min'],
  ['future', '💸', 'Versement des fonds', 'Sous 24–48h après validation finale'],
]

export function SuccessScreen({ data, montant, duree, mensualite }) {
  // eslint-disable-next-line react-hooks/purity
  const dossierNum = `CR-${Date.now().toString().slice(-8)}`

  return (
    <div className="mx-auto max-w-[580px] px-5 py-15 text-center">
      <div className="mx-auto mb-7 flex size-24 animate-[scaleIn_0.5s_ease] items-center justify-center rounded-full bg-gradient-to-br from-emerald-500 to-emerald-600 text-4xl text-white">
        ✅
      </div>
      <h1 className="mb-4 font-[family-name:var(--font-sora)] text-[32px] font-extrabold tracking-tight text-[#0A0F1E]">
        Dossier soumis avec succès !
      </h1>
      <p className="mb-9 text-base leading-relaxed text-gray-500">
        Un email de confirmation a été envoyé à <strong>{data.email}</strong>.
        <br />
        Notre équipe vous contactera sous <strong>60 minutes</strong>.
      </p>

      <div className="mb-7 rounded-[20px] bg-white p-7 text-left shadow-[0_4px_20px_rgba(0,0,0,0.06)]">
        <p className="mb-5 font-[family-name:var(--font-sora)] text-[15px] font-bold text-[#0A0F1E]">
          📋 Prochaines étapes
        </p>
        {TIMELINE.map(([status, ico, title, sub]) => (
          <div key={title} className="mb-4 flex gap-3.5 last:mb-0">
            <div
              className={`flex size-8 shrink-0 items-center justify-center rounded-full text-sm ${
                status === 'done'
                  ? 'bg-emerald-100'
                  : status === 'pending'
                    ? 'bg-amber-100'
                    : 'bg-gray-200'
              }`}
            >
              {ico}
            </div>
            <div>
              <p className="text-sm font-semibold text-[#0A0F1E]">{title}</p>
              <p className="mt-0.5 text-xs text-gray-500">{sub}</p>
            </div>
          </div>
        ))}
      </div>

      <div className="mb-6 rounded-[20px] bg-white p-6 text-left shadow-[0_4px_20px_rgba(0,0,0,0.06)]">
        <p className="mb-3 font-[family-name:var(--font-sora)] text-sm font-bold text-[#0A0F1E]">
          🏷️ Résumé de votre demande
        </p>
        {[
          ['Montant', fmt(montant)],
          ['Durée', `${duree} mois`],
          ['Mensualité', fmtDec(mensualite)],
          ['Numéro de dossier', dossierNum],
        ].map(([k, v]) => (
          <div
            key={k}
            className="flex items-center justify-between border-b border-gray-100 py-2.5 last:border-0"
          >
            <span className="text-[13px] text-gray-500">{k}</span>
            <span className="text-sm font-semibold text-[#0A0F1E]">{v}</span>
          </div>
        ))}
      </div>

      <p className="text-center text-xs leading-relaxed text-gray-400">
        Un crédit vous engage. Vérifiez vos capacités de remboursement.
      </p>
    </div>
  )
}

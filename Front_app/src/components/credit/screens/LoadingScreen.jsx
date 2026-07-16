const LOADER_STEPS = [
  ['🔍', 'Vérification de votre identité'],
  ['🏦', 'Analyse de votre RIB'],
  ['📊', 'Évaluation de votre profil'],
  ['📧', 'Envoi de votre confirmation'],
]

export function LoadingScreen({ loadStep }) {
  return (
    <div className="mx-auto max-w-[580px] px-5 py-20 text-center">
      <div className="mx-auto mb-6 size-[60px] animate-spin rounded-full border-4 border-gray-200 border-t-[#0A0F1E]" />
      <h1 className="mb-3 font-[family-name:var(--font-sora)] text-[22px] font-bold text-[#0A0F1E]">
        Analyse de votre dossier…
      </h1>
      <p className="text-sm leading-relaxed text-gray-500">
        Nos outils vérifient vos documents en toute sécurité.
        <br />
        Cette opération prend moins d&apos;une minute.
      </p>
      <div className="mx-auto mt-7 max-w-[320px] text-left">
        {LOADER_STEPS.map(([ico, txt], i) => (
          <div
            key={txt}
            className={`flex items-center gap-3 py-2.5 ${loadStep > i ? 'text-[#0A0F1E]' : 'text-gray-500'}`}
          >
            <span className="text-xl">{loadStep > i ? '✅' : ico}</span>
            <span className={`text-[13px] ${loadStep > i ? 'font-semibold' : ''}`}>
              {txt}
            </span>
          </div>
        ))}
      </div>
    </div>
  )
}

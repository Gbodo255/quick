import { CheckCircle2 } from 'lucide-react'
import { useTranslation } from 'react-i18next'

export function DossierSuccessModal({ open, onClose }) {
  const { t } = useTranslation()

  if (!open) return null

  return (
    <div
      className="fixed inset-0 z-[80] flex items-center justify-center bg-black/50 p-4 backdrop-blur-sm"
      role="dialog"
      aria-modal="true"
    >
      <div className="relative w-full max-w-md animate-[pop_0.5s_ease] rounded-lg bg-white p-8 text-center shadow-2xl md:p-10">
        <div className="mb-5 flex justify-center">
          <div className="flex size-16 items-center justify-center rounded-full bg-lumina-status-success/10">
            <CheckCircle2 className="h-9 w-9 text-lumina-status-success" strokeWidth={1.75} />
          </div>
        </div>

        <h2 className="mb-3 font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-heading">
          {t('success_popup.title', 'Votre dossier a bien été créé')}
        </h2>

        <p className="mb-6 text-sm leading-relaxed text-lumina-on-surface-variant">
          {t(
            'success_popup.body',
            "Il ne vous reste plus qu'à consulter votre boîte mail pour retrouver toutes les informations concernant votre dossier.",
          )}
        </p>

        <button type="button" onClick={onClose} className="btn-clenar w-full justify-center">
          {t('success_popup.cta', 'Ok')}
        </button>
      </div>
    </div>
  )
}

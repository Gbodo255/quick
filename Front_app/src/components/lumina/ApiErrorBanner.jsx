import { Icon } from '@/components/lumina/Icon'

export function ApiErrorBanner({ error, onDismiss }) {
  if (!error) return null

  return (
    <div
      role="alert"
      className="mb-4 flex items-start gap-3 rounded-none border border-lumina-error/30 bg-lumina-error/5 px-4 py-3 text-sm text-lumina-error"
    >
      <Icon name="error" size={20} className="mt-0.5 shrink-0" />
      <div className="flex-1">
        <p className="font-medium">{error}</p>
      </div>
      {onDismiss && (
        <button
          type="button"
          onClick={onDismiss}
          className="shrink-0 text-xs underline opacity-80 hover:opacity-100"
        >
          Fermer
        </button>
      )}
    </div>
  )
}

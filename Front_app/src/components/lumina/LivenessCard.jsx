import { useCallback, useEffect, useState } from 'react'
import { useTranslation } from 'react-i18next'
import { Icon } from '@/components/lumina/Icon'
import { DotSpinner } from '@/components/lumina/DotSpinner'
import { getLivenessStatus, startLiveness } from '@/lib/api'
import { loadDossierSession } from '@/lib/dossierSession'

const DIDIT_ORIGIN = 'https://verify.didit.me'

export function LivenessCard() {
  const { t } = useTranslation()
  const [review, setReview] = useState(null)
  const [url, setUrl] = useState('')
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState('')

  const refreshStatus = useCallback(async () => {
    const s = loadDossierSession()
    if (!s) return
    try {
      setReview(await getLivenessStatus(s.reference, s.token))
    } catch {
      // statut indisponible : l'utilisateur peut relancer la vérification
    }
  }, [])

  useEffect(() => {
    const s = loadDossierSession()
    if (s) getLivenessStatus(s.reference, s.token).then(setReview).catch(() => {})
  }, [])

  // Didit prévient la page parente à la fin du parcours ; la décision est relue côté serveur.
  useEffect(() => {
    const onMessage = (event) => {
      if (event.origin !== DIDIT_ORIGIN || event.data?.type !== 'didit:completed') return
      setUrl('')
      refreshStatus()
    }
    window.addEventListener('message', onMessage)
    return () => window.removeEventListener('message', onMessage)
  }, [refreshStatus])

  const launch = async () => {
    const s = loadDossierSession()
    if (!s) return
    setError('')
    setLoading(true)
    try {
      setUrl((await startLiveness(s.reference, s.token)).url)
    } catch (err) {
      setError(err?.message || t('liveness.error', 'La vérification est indisponible pour le moment.'))
    }
    setLoading(false)
  }

  const approved = review?.status === 'passed'
  const rejected = review?.status === 'failed'
  const pending = review?.status === 'pending'

  return (
    <div className="surface-card flex flex-col gap-4 p-4 md:p-5">
      <div className="flex items-center justify-between border-b border-lumina-outline-variant/30 pb-3">
        <div className="flex items-center gap-3">
          <div className="flex size-10 items-center justify-center rounded-md bg-lumina-surface-container text-lumina-primary">
            <Icon name="face" size={22} />
          </div>
          <div>
            <h2 className="font-[family-name:var(--font-headline)] text-base font-semibold text-lumina-on-surface">
              {t('liveness.title', 'Vérification faciale')}
            </h2>
            <p className="text-xs text-lumina-on-surface-variant">
              {t('liveness.subtitle', 'Un selfie vidéo de quelques secondes pour confirmer que vous êtes bien le titulaire du dossier.')}
            </p>
          </div>
        </div>
        {approved && (
          <span className="inline-flex items-center gap-1.5 rounded-full bg-lumina-status-success/15 px-3 py-1 text-xs font-semibold text-lumina-status-success">
            <Icon name="check_circle" filled size={16} />
            {t('documents.verified', 'Vérifié')}
          </span>
        )}
      </div>

      {rejected && !url && (
        <p className="text-xs text-lumina-error" role="alert">
          ⚠ {t('liveness.rejected', 'La vérification n\'a pas abouti. Vous pouvez réessayer.')}
        </p>
      )}
      {pending && !url && (
        <p className="text-xs text-lumina-on-surface-variant">
          {t('liveness.pending', 'Vérification en cours d\'analyse…')}
        </p>
      )}
      {error && <p className="text-xs text-lumina-error" role="alert">⚠ {error}</p>}

      {url && (
        <iframe
          src={url}
          title={t('liveness.title', 'Vérification faciale')}
          allow="camera; microphone; fullscreen; autoplay; encrypted-media"
          className="h-[640px] w-full rounded-md border-0"
        />
      )}

      {!url && !approved && (
        <div className="flex flex-wrap gap-2">
          <button
            type="button"
            onClick={launch}
            disabled={loading}
            className="btn-secondary flex items-center justify-center gap-2 text-sm disabled:opacity-50"
          >
            {loading ? <DotSpinner size={16} dots={8} /> : <Icon name="photo_camera" size={18} />}
            {t('liveness.start', 'Lancer la vérification')}
          </button>
          {pending && (
            <button type="button" onClick={refreshStatus} className="btn-secondary text-sm">
              {t('liveness.refresh', 'Actualiser le statut')}
            </button>
          )}
        </div>
      )}
    </div>
  )
}

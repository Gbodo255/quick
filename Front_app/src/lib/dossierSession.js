const STORAGE_KEY = 'quickcredit_dossier_session'

export function saveDossierSession({ reference, token }) {
  sessionStorage.setItem(
    STORAGE_KEY,
    JSON.stringify({ reference, token }),
  )
}

export function loadDossierSession() {
  try {
    const raw = sessionStorage.getItem(STORAGE_KEY)
    if (!raw) return null
    const parsed = JSON.parse(raw)
    if (parsed?.reference && parsed?.token) return parsed
    return null
  } catch {
    return null
  }
}

export function clearDossierSession() {
  sessionStorage.removeItem(STORAGE_KEY)
}

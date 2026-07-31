const rawApiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000'
const normalizedApiUrl = rawApiUrl.replace(/\/+$|\/api\/?$/, '')
const API_BASE = normalizedApiUrl.endsWith('/api/v1')
  ? normalizedApiUrl
  : `${normalizedApiUrl}/api/v1`

export class ApiError extends Error {
  constructor(message, { status = 0, errors = null } = {}) {
    super(message)
    this.name = 'ApiError'
    this.status = status
    this.errors = errors
  }
}

async function request(method, path, { token, json, formData } = {}) {
  const headers = { Accept: 'application/json' }
  if (token) headers['X-Dossier-Token'] = token
  if (json !== undefined) headers['Content-Type'] = 'application/json'

  let response
  try {
    response = await fetch(`${API_BASE}${path}`, {
      method,
      headers,
      body: json !== undefined ? JSON.stringify(json) : formData,
    })
  } catch {
    throw new ApiError('Une erreur est survenue. Réessayez plus tard.', { status: 0 })
  }

  return parseResponse(response)
}

async function parseResponse(response) {
  const contentType = response.headers.get('content-type') ?? ''
  const isJson = contentType.includes('application/json')
  const body = isJson ? await response.json().catch(() => ({})) : {}

  if (!response.ok) {
    throw new ApiError(body.message ?? 'Une erreur est survenue.', {
      status: response.status,
      errors: body.errors ?? null,
    })
  }

  return body
}

export async function checkApiHealth() {
  return request('GET', '/health')
}

export async function simulateCredit({ montant, duree_mois }) {
  return request('POST', '/simulate', { json: { montant, duree_mois } })
}

export async function createDossier(payload) {
  return request('POST', '/dossiers', { json: payload })
}

export async function updateDossierStep(reference, token, step, data) {
  return request('PATCH', `/dossiers/${reference}`, {
    token,
    json: { step, ...data },
  })
}

export async function uploadDocument(reference, token, type, file) {
  const form = new FormData()
  form.append('file', file)
  return request('POST', `/dossiers/${reference}/documents/${type}`, { token, formData: form })
}

export async function deleteDocument(reference, token, type) {
  return request('DELETE', `/dossiers/${reference}/documents/${type}`, { token })
}

export async function sendOtp(reference, token) {
  return request('POST', `/dossiers/${reference}/otp/send`, { token })
}

export async function verifyOtpAndSubmit(reference, token, code) {
  return request('POST', `/dossiers/${reference}/otp/verify`, {
    token,
    json: { code },
  })
}

export async function tickProcessing(reference, token) {
  return request('POST', `/dossiers/${reference}/processing/tick`, { token })
}

export async function fetchDossier(reference) {
  return request('GET', `/dossiers/${reference}`)
}

const STEP_MAP = ['prequal', 'identite', 'situation', 'projet', 'recap', 'recap']

export function formDataToStepPayload(stepIndex, data, { montant, duree } = {}) {
  switch (stepIndex) {
    case 0:
      return {
        situation_pro: data.situationPro,
        situation_logement: data.situationLogement,
        revenu_net: Number(data.revenuNet),
        charges_mensuelles: data.chargesMensuelles
          ? Number(data.chargesMensuelles)
          : 0,
      }
    case 1:
      return {
        civilite: data.civilite,
        prenom: data.prenom.trim(),
        nom: data.nom.trim(),
        email: data.email.trim(),
        telephone: data.telephone,
        date_naissance: data.dateNaissance,
        lieu_naissance: data.lieuNaissance || null,
        adresse: data.adresse.trim(),
        code_postal: data.codePostal.trim(),
        ville: data.ville.trim(),
      }
    case 2:
      return {
        employeur: data.employeur?.trim() || null,
        anciennete: data.anciennete,
        situation_logement: data.situationLogement,
        situation_pro: data.situationPro,
      }
    case 3:
      return {
        motif: data.motif,
        montant,
        duree_mois: duree,
      }
    case 4:
      return {}
    case 5:
      return {
        consent_1: Boolean(data.consent1),
        consent_2: Boolean(data.consent2),
        consent_3: Boolean(data.consent3),
      }
    default:
      return {}
  }
}

export function getStepId(stepIndex) {
  return STEP_MAP[stepIndex]
}

export function mapApiErrorsToForm(errors) {
  if (!errors || typeof errors !== 'object') return {}
  const map = {
    situation_pro: 'situationPro',
    situation_logement: 'situationLogement',
    revenu_net: 'revenuNet',
    charges_mensuelles: 'chargesMensuelles',
    date_naissance: 'dateNaissance',
    lieu_naissance: 'lieuNaissance',
    code_postal: 'codePostal',
    piece_identite_type: 'pieceIdentiteType',
    consent_1: 'consent1',
    consent_2: 'consent2',
    consent_3: 'consent3',
  }
  const out = {}
  for (const [key, messages] of Object.entries(errors)) {
    const field = map[key] ?? key
    out[field] = Array.isArray(messages) ? messages[0] : messages
  }
  return out
}

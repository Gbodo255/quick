import { calcMensualite } from './credit'

// ─────────────────────────────────────────────────────────────────────────
// MOCK MODE — le front est déconnecté du vrai backend pour le moment.
// Toutes les fonctions ci-dessous simulent un serveur en mémoire (aucun
// appel réseau réel). Repasser MOCK_MODE à false une fois le backend prêt :
// les implémentations réelles (fetch) sont conservées plus bas, inchangées.
// ─────────────────────────────────────────────────────────────────────────
const MOCK_MODE = import.meta.env.VITE_MOCK_MODE === 'true' || 
  (import.meta.env.PROD && (!import.meta.env.VITE_API_URL || String(import.meta.env.VITE_API_URL).trim() === ''))

export class ApiError extends Error {
  constructor(message, { status = 0, errors = null } = {}) {
    super(message)
    this.name = 'ApiError'
    this.status = status
    this.errors = errors
  }
}

function delay(ms = 400) {
  return new Promise((resolve) => setTimeout(resolve, ms))
}

function generateReference() {
  return `QC-${Date.now().toString(36).toUpperCase().slice(-6)}`
}

function generateToken() {
  return `${Math.random().toString(36).slice(2)}${Math.random().toString(36).slice(2)}`
}

// Store en mémoire — vidé à chaque rechargement de page (comportement voulu :
// pas de fausse persistance d'un faux dossier entre deux sessions).
const mockDossiers = new Map()

function buildSimulation(montant, dureeMois) {
  return {
    montant,
    duree_mois: dureeMois,
    mensualite: calcMensualite(montant, dureeMois),
  }
}

// ── Implémentations mock ────────────────────────────────────────────────

async function mockCheckApiHealth() {
  await delay(150)
  return { status: 'ok', mock: true }
}

async function mockSimulateCredit({ montant, duree_mois }) {
  await delay(200)
  return buildSimulation(montant, duree_mois)
}

async function mockCreateDossier(payload) {
  await delay(500)
  const reference = generateReference()
  const token = generateToken()
  const montant = payload.montant ?? 25000
  const dureeMois = payload.duree_mois ?? 48

  const dossier = {
    reference,
    token,
    status: 'a_qualifier',
    completed_steps: [],
    motif: payload.motif ?? null,
    simulation: buildSimulation(montant, dureeMois),
    documents: [],
  }

  mockDossiers.set(reference, dossier)
  return { dossier, token }
}

function getMockDossierOrThrow(reference) {
  const dossier = mockDossiers.get(reference)
  if (!dossier) {
    throw new ApiError('Dossier introuvable.', { status: 404 })
  }
  return dossier
}

async function mockUpdateDossierStep(reference, token, step, data) {
  await delay(450)
  const dossier = getMockDossierOrThrow(reference)

  if (data.motif) dossier.motif = data.motif
  const montant = data.montant ?? dossier.simulation.montant
  const dureeMois = data.duree_mois ?? dossier.simulation.duree_mois
  dossier.simulation = buildSimulation(montant, dureeMois)

  dossier.completed_steps = Array.from(new Set([...(dossier.completed_steps ?? []), step]))
  if (step === 'recap') dossier.status = 'dossier_conforme'

  mockDossiers.set(reference, dossier)
  return { ...dossier }
}

async function mockUploadDocument(reference, token, type, file) {
  await delay(400)
  const dossier = getMockDossierOrThrow(reference)
  dossier.documents = [
    ...(dossier.documents ?? []).filter((d) => d.type !== type),
    { type, original_filename: file?.name ?? `${type}.pdf` },
  ]
  mockDossiers.set(reference, dossier)
  return { success: true }
}

async function mockDeleteDocument(reference, token, type) {
  await delay(250)
  const dossier = getMockDossierOrThrow(reference)
  dossier.documents = (dossier.documents ?? []).filter((d) => d.type !== type)
  mockDossiers.set(reference, dossier)
  return { success: true }
}

async function mockSendOtp() {
  await delay(300)
  return { success: true }
}

async function mockVerifyOtpAndSubmit(reference, token, code) {
  await delay(500)
  if (!/^\d{4,6}$/.test(String(code ?? ''))) {
    throw new ApiError('Code invalide.', { status: 422, errors: { code: ['Code invalide.'] } })
  }
  const dossier = getMockDossierOrThrow(reference)
  dossier.status = 'dossier_conforme'
  mockDossiers.set(reference, dossier)
  return { dossier }
}

async function mockTickProcessing(reference) {
  await delay(200)
  const dossier = mockDossiers.get(reference)
  return { success: true, dossier: dossier ?? null }
}

async function mockFetchDossier(reference) {
  await delay(250)
  // Le store est en mémoire : après un rechargement, le dossier n'existe
  // plus. On lève une erreur pour laisser l'appli nettoyer la session
  // locale et repartir sur un état propre (comportement volontaire).
  return getMockDossierOrThrow(reference)
}

// ── Implémentations réelles (fetch) — conservées pour la reconnexion future ──

const envApiUrl = import.meta.env.VITE_API_URL
const defaultOrigin = typeof window !== 'undefined' && window.location && window.location.origin
  ? window.location.origin
  : 'http://localhost:8000'
const rawApiUrl = envApiUrl && envApiUrl.trim() !== '' ? envApiUrl : defaultOrigin
const normalizedApiUrl = rawApiUrl.replace(/\/+$|\/api\/?$/, '')
const API_BASE = normalizedApiUrl.endsWith('/api/v1')
  ? normalizedApiUrl
  : `${normalizedApiUrl}/api/v1`

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

async function realCheckApiHealth() {
  return request('GET', '/health')
}
async function realSimulateCredit({ montant, duree_mois }) {
  return request('POST', '/simulate', { json: { montant, duree_mois } })
}
async function realCreateDossier(payload) {
  return request('POST', '/dossiers', { json: payload })
}
async function realUpdateDossierStep(reference, token, step, data) {
  return request('PATCH', `/dossiers/${reference}`, { token, json: { step, ...data } })
}
async function realUploadDocument(reference, token, type, file) {
  const form = new FormData()
  form.append('file', file)
  return request('POST', `/dossiers/${reference}/documents/${type}`, { token, formData: form })
}
async function realDeleteDocument(reference, token, type) {
  return request('DELETE', `/dossiers/${reference}/documents/${type}`, { token })
}
async function realSendOtp(reference, token) {
  return request('POST', `/dossiers/${reference}/otp/send`, { token })
}
async function realVerifyOtpAndSubmit(reference, token, code) {
  return request('POST', `/dossiers/${reference}/otp/verify`, { token, json: { code } })
}
async function realTickProcessing(reference, token) {
  return request('POST', `/dossiers/${reference}/processing/tick`, { token })
}
async function realFetchDossier(reference) {
  return request('GET', `/dossiers/${reference}`)
}

// ── Exports (basculent mock/réel selon MOCK_MODE) ───────────────────────

export const checkApiHealth = MOCK_MODE ? mockCheckApiHealth : realCheckApiHealth
export const simulateCredit = MOCK_MODE ? mockSimulateCredit : realSimulateCredit
export const createDossier = MOCK_MODE ? mockCreateDossier : realCreateDossier
export const updateDossierStep = MOCK_MODE ? mockUpdateDossierStep : realUpdateDossierStep
export const uploadDocument = MOCK_MODE ? mockUploadDocument : realUploadDocument
export const deleteDocument = MOCK_MODE ? mockDeleteDocument : realDeleteDocument
export const sendOtp = MOCK_MODE ? mockSendOtp : realSendOtp
export const verifyOtpAndSubmit = MOCK_MODE ? mockVerifyOtpAndSubmit : realVerifyOtpAndSubmit
export const tickProcessing = MOCK_MODE ? mockTickProcessing : realTickProcessing
export const fetchDossier = MOCK_MODE ? mockFetchDossier : realFetchDossier

const STEP_MAP = ['prequal', 'identite', 'situation', 'projet', 'recap']

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
        telephone: `${data.indicatifPays || '+33'} ${data.telephone}`.trim(),
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
        assurance: Boolean(data.assurance),
      }
    case 4:
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

export const TAUX_ANNUEL = 3.9
export const BRAND = 'Quickcredit'
export const BRAND_WORDMARK = {
  prefix: 'Quick',
  accent: 'credit',
}

export const DUREES = [12, 24, 36, 48, 60, 84]
export const MONTANTS_RAPIDES = [5000, 10000, 15000, 25000, 35000, 50000]

export const FORM_STEPS = [
  { id: 'prequal', label: 'Pré-qualification', stepNum: 1 },
  { id: 'identite', label: 'Informations personnelles', stepNum: 2 },
  { id: 'situation', label: 'Situation financière', stepNum: 3 },
  { id: 'projet', label: 'Votre projet', stepNum: 4 },
  { id: 'documents', label: 'Pièces justificatives', stepNum: 5 },
  { id: 'recap', label: 'Récapitulatif & Validation', stepNum: 6 },
]

export const INITIAL_FORM_DATA = {
  civilite: '',
  prenom: '',
  nom: '',
  email: '',
  telephone: '',
  dateNaissance: '',
  lieuNaissance: '',
  adresse: '',
  codePostal: '',
  ville: '',
  situationPro: '',
  employeur: '',
  anciennete: '',
  revenuNet: '',
  chargesMensuelles: '',
  situationLogement: '',
  motif: '',
  assurance: true,
  pieceIdentiteType: '',
  pieceIdentite: null,
  rib: null,
  consent1: false,
  consent2: false,
  consent3: false,
}

export function calcMensualite(montant, dureesMois) {
  const r = TAUX_ANNUEL / 100 / 12
  const n = dureesMois
  const m = (montant * r * Math.pow(1 + r, n)) / (Math.pow(1 + r, n) - 1)
  return Math.round(m * 100) / 100
}

export function fmt(n) {
  return new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR',
    maximumFractionDigits: 0,
  }).format(n)
}

export function fmtDec(n) {
  return new Intl.NumberFormat('fr-FR', {
    style: 'currency',
    currency: 'EUR',
    minimumFractionDigits: 2,
    maximumFractionDigits: 2,
  }).format(n)
}

export function isEligible(data) {
  if (!data.revenuNet) return false
  const revenu = +data.revenuNet
  const charges = +(data.chargesMensuelles || 0)
  if (revenu <= 0) return false
  return (charges / revenu) * 100 < 45
}

export function validateStep(step, data) {
  const errs = {}

  if (step === 0) {
    if (!data.situationPro) errs.situationPro = 'Requis'
    if (!data.situationLogement) errs.situationLogement = 'Requis'
    if (!data.revenuNet) errs.revenuNet = 'Revenus requis'
  }

  if (step === 1) {
    if (!data.civilite) errs.civilite = 'Requis'
    if (!data.prenom.trim()) errs.prenom = 'Prénom requis'
    if (!data.nom.trim()) errs.nom = 'Nom requis'
    if (!data.email.includes('@')) errs.email = 'Email invalide'
    const digitsOnly = (data.telephone || '').replace(/\D/g, '')
    if (digitsOnly.length < 8 || digitsOnly.length > 15)
      errs.telephone = 'Téléphone invalide'
    if (!data.dateNaissance) errs.dateNaissance = 'Date de naissance requise'
    if (!data.adresse.trim()) errs.adresse = 'Adresse requise'
    if (!data.codePostal.trim()) errs.codePostal = 'Code postal requis'
    if (!data.ville.trim()) errs.ville = 'Ville requise'
  }

  if (step === 2) {
    if (!data.employeur?.trim() && ['cdi', 'cdd', 'fonctionnaire', 'salarie_cdi', 'salarie_cdd'].includes(data.situationPro))
      errs.employeur = 'Employeur requis'
    if (!data.anciennete) errs.anciennete = 'Ancienneté requise'
  }

  if (step === 3) {
    if (!data.motif) errs.motif = 'Motif requis'
  }

  if (step === 4) {
    // Document step - documents are uploaded asynchronously
  }

  if (step === 5) {
    if (!data.consent1) errs.consent1 = 'Consentement requis'
    if (!data.consent2) errs.consent2 = 'Consentement requis'
    if (!data.consent3) errs.consent3 = 'Consentement requis'
  }

  return errs
}

export function generateDossierId() {
  return `CR-${Date.now().toString(36).toUpperCase().slice(-6)}`
}

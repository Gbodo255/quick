import { INITIAL_FORM_DATA } from '@/lib/credit'

export function dossierToFormData(dossier) {
  const prequal = dossier?.prequal ?? {}
  const identite = dossier?.identite ?? {}
  const situation = dossier?.situation ?? {}
  const simulation = dossier?.simulation ?? {}
  const consents = dossier?.consents ?? {}

  return {
    ...INITIAL_FORM_DATA,
    situationPro: prequal.situation_pro ?? '',
    situationLogement: prequal.situation_logement ?? '',
    revenuNet: prequal.revenu_net != null ? String(prequal.revenu_net) : '',
    chargesMensuelles:
      prequal.charges_mensuelles != null ? String(prequal.charges_mensuelles) : '',
    civilite: identite.civilite ?? '',
    prenom: identite.prenom ?? '',
    nom: identite.nom ?? '',
    email: identite.email ?? '',
    telephone: identite.telephone ?? '',
    dateNaissance: identite.date_naissance ?? '',
    lieuNaissance: identite.lieu_naissance ?? '',
    adresse: identite.adresse ?? '',
    codePostal: identite.code_postal ?? '',
    ville: identite.ville ?? '',
    employeur: situation.employeur ?? '',
    anciennete: situation.anciennete ?? '',
    motif: simulation.motif ?? '',
    pieceIdentiteType: dossier?.piece_identite_type ?? '',
    consent1: Boolean(consents.consent_1),
    consent2: Boolean(consents.consent_2),
    consent3: Boolean(consents.consent_3),
    pieceIdentite: (dossier?.documents ?? []).find((d) => d.type === 'piece_identite')
      ? { name: (dossier?.documents ?? []).find((d) => d.type === 'piece_identite').original_filename, isUploaded: true }
      : null,
    rib: (dossier?.documents ?? []).find((d) => d.type === 'rib')
      ? { name: (dossier?.documents ?? []).find((d) => d.type === 'rib').original_filename, isUploaded: true }
      : null,
  }
}

export function simulationFromDossier(dossier) {
  const s = dossier?.simulation ?? {}
  return {
    montant: s.montant ?? 25000,
    duree: s.duree_mois ?? 48,
    mensualite: s.mensualite,
  }
}

export function uploadedDocumentTypes(dossier) {
  return new Set((dossier?.documents ?? []).map((d) => d.type))
}

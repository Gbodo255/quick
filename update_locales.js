const fs = require('fs');
const path = require('path');

const localesDir = path.join(__dirname, 'Front_app', 'src', 'i18n', 'locales');
const files = ['fr.json', 'en.json', 'de.json', 'es.json'];

const additions = {
  fr: {
    app: {
      motif_required: "Motif requis",
      doc_required: "Document requis (envoi en cours ou échec)",
      rib_required: "RIB requis (envoi en cours ou échec)",
      error_generic: "Une erreur est survenue. Réessayez plus tard.",
      error_backend: "Le backend doit être démarré avant de continuer.",
      error_session: "Session expirée. Recommencez depuis l’accueil.",
      not_found_title: "Page introuvable",
      not_found_body: "Ce parcours n'existe pas ou votre session a expiré.",
      home_button: "Retour à l'accueil",
      error_network: "Impossible de contacter le serveur. Vérifiez votre connexion."
    },
    otp: {
      email_fallback: "votre adresse e-mail",
      subtitle1: "Un code de vérification a été envoyé à",
      subtitle2: "Saisissez-le ci-dessous pour confirmer votre demande.",
      error_send: "Envoi du code impossible.",
      resend_success: "Un nouveau code a été envoyé.",
      error_resend: "Renvoi impossible.",
      title: "Vérification de sécurité",
      validating: "Validation…",
      validate_button: "Valider le code",
      resend_button: "Renvoyer le code par e-mail"
    },
    recap: {
      id_doc: "Pièce d'identité",
      rib_doc: "RIB",
      credit_details: "Détails du Crédit",
      personal_info: "Informations Personnelles",
      financial_info: "Situation Financière",
      documents: "Documents Transmis",
      amount: "Montant demandé",
      duration: "Durée",
      monthly: "Mensualité estimée",
      rate: "TAEG fixe",
      total_cost: "Coût total",
      credit_cost: "Coût du crédit",
      fullname: "Nom complet",
      birthdate: "Date de naissance",
      address: "Adresse",
      email: "Email",
      phone: "Téléphone",
      income: "Revenus nets",
      charges: "Charges",
      motif: "Motif",
      employer: "Employeur",
      not_provided: "Non fourni",
      consent_title: "Consentement et Validation",
      consent1: "Je certifie sur l'honneur l'exactitude des informations fournies.",
      consent2: "J'accepte les Conditions Générales et la politique de confidentialité de {{brand}}.",
      privacy_policy: "Lire la politique de confidentialité",
      consent3: "Je consens à l'utilisation de mes données pour le traitement de mon dossier et l'évaluation de ma solvabilité (RGPD).",
      intro: "Veuillez vérifier les informations ci-dessous avant de soumettre définitivement votre dossier.",
      edit: "Modifier"
    },
    loading: {
      step_id: "Vérification de votre identité",
      step_rib: "Analyse de votre RIB",
      step_profile: "Évaluation de votre profil",
      step_confirm: "Envoi de votre confirmation",
      title: "Analyse de votre dossier…",
      subtitle: "Nos outils vérifient vos documents en toute sécurité. Cette opération prend moins d'une minute."
    },
    success: {
      step_verify: "Vérification",
      step_verify_desc: "Nous vérifions l'exhaustivité de vos documents.",
      step_analysis: "Analyse",
      step_analysis_desc: "Nos experts étudient votre profil financier.",
      step_contact: "Contact",
      step_contact_desc: "Un conseiller vous appelle pour échanger.",
      step_decision: "Décision",
      step_decision_desc: "Proposition finale et signature.",
      reference: "Numéro de dossier",
      go_home: "Retour à l'accueil",
      confirmation_sent: "Confirmation envoyée à",
      title: "Votre dossier a bien été soumis",
      dossier_number: "Numéro de dossier",
      next_steps: "Prochaines étapes",
      amount: "Montant",
      duration: "Durée",
      monthly: "Mensualité",
      home: "Retour à l'accueil"
    }
  },
  en: {
    app: {
      motif_required: "Reason required",
      doc_required: "Document required",
      rib_required: "Bank details required",
      error_generic: "An error occurred. Please try again later.",
      error_backend: "The backend must be started before continuing.",
      error_session: "Session expired. Start over from home.",
      not_found_title: "Page not found",
      not_found_body: "This path does not exist or your session expired.",
      home_button: "Back to Home",
      error_network: "Unable to contact server. Check your connection."
    },
    otp: {
      email_fallback: "your email address",
      subtitle1: "A verification code has been sent to",
      subtitle2: "Enter it below to confirm your request.",
      error_send: "Failed to send code.",
      resend_success: "A new code has been sent.",
      error_resend: "Failed to resend.",
      title: "Security Verification",
      validating: "Validating...",
      validate_button: "Validate code",
      resend_button: "Resend code by email"
    },
    recap: {
      id_doc: "ID Document",
      rib_doc: "Bank Details (RIB)",
      credit_details: "Credit Details",
      personal_info: "Personal Information",
      financial_info: "Financial Situation",
      documents: "Submitted Documents",
      amount: "Requested amount",
      duration: "Duration",
      monthly: "Estimated monthly",
      rate: "Fixed APR",
      total_cost: "Total cost",
      credit_cost: "Cost of credit",
      fullname: "Full name",
      birthdate: "Birthdate",
      address: "Address",
      email: "Email",
      phone: "Phone",
      income: "Net income",
      charges: "Charges",
      motif: "Reason",
      employer: "Employer",
      not_provided: "Not provided",
      consent_title: "Consent & Validation",
      consent1: "I certify that the information provided is accurate.",
      consent2: "I accept the Terms and Conditions and the privacy policy of {{brand}}.",
      privacy_policy: "Read the privacy policy",
      consent3: "I consent to the use of my data to process my application (GDPR).",
      intro: "Please check the information below before finally submitting your application.",
      edit: "Edit"
    },
    loading: {
      step_id: "Identity verification",
      step_rib: "Bank details analysis",
      step_profile: "Profile evaluation",
      step_confirm: "Sending confirmation",
      title: "Analyzing your file...",
      subtitle: "Our tools are securely verifying your documents. This takes less than a minute."
    },
    success: {
      step_verify: "Verification",
      step_verify_desc: "We verify the completeness of your documents.",
      step_analysis: "Analysis",
      step_analysis_desc: "Our experts study your financial profile.",
      step_contact: "Contact",
      step_contact_desc: "An advisor will call you to discuss.",
      step_decision: "Decision",
      step_decision_desc: "Final proposal and signature.",
      reference: "Application number",
      go_home: "Back to Home",
      confirmation_sent: "Confirmation sent to",
      title: "Your application has been submitted",
      dossier_number: "Application number",
      next_steps: "Next steps",
      amount: "Amount",
      duration: "Duration",
      monthly: "Monthly",
      home: "Back to Home"
    }
  },
  de: {
    app: {
      motif_required: "Grund erforderlich",
      doc_required: "Dokument erforderlich",
      rib_required: "Bankverbindung erforderlich",
      error_generic: "Ein Fehler ist aufgetreten. Bitte versuchen Sie es später erneut.",
      error_backend: "Das Backend muss gestartet sein, um fortzufahren.",
      error_session: "Sitzung abgelaufen. Bitte starten Sie von vorne.",
      not_found_title: "Seite nicht gefunden",
      not_found_body: "Dieser Pfad existiert nicht oder Ihre Sitzung ist abgelaufen.",
      home_button: "Zurück zur Startseite",
      error_network: "Verbindung zum Server fehlgeschlagen. Überprüfen Sie Ihre Verbindung."
    },
    otp: {
      email_fallback: "Ihre E-Mail-Adresse",
      subtitle1: "Ein Bestätigungscode wurde gesendet an",
      subtitle2: "Geben Sie ihn unten ein, um Ihre Anfrage zu bestätigen.",
      error_send: "Code konnte nicht gesendet werden.",
      resend_success: "Ein neuer Code wurde gesendet.",
      error_resend: "Erneutes Senden fehlgeschlagen.",
      title: "Sicherheitsüberprüfung",
      validating: "Wird überprüft...",
      validate_button: "Code bestätigen",
      resend_button: "Code per E-Mail erneut senden"
    },
    recap: {
      id_doc: "Ausweisdokument",
      rib_doc: "Bankverbindung (RIB)",
      credit_details: "Kreditdetails",
      personal_info: "Persönliche Daten",
      financial_info: "Finanzielle Situation",
      documents: "Eingereichte Dokumente",
      amount: "Gewünschter Betrag",
      duration: "Laufzeit",
      monthly: "Geschätzte Rate",
      rate: "Fester effektiver Jahreszins",
      total_cost: "Gesamtkosten",
      credit_cost: "Kreditkosten",
      fullname: "Vollständiger Name",
      birthdate: "Geburtsdatum",
      address: "Adresse",
      email: "E-Mail",
      phone: "Telefon",
      income: "Nettoeinkommen",
      charges: "Ausgaben",
      motif: "Grund",
      employer: "Arbeitgeber",
      not_provided: "Nicht angegeben",
      consent_title: "Zustimmung & Validierung",
      consent1: "Ich bestätige die Richtigkeit der gemachten Angaben.",
      consent2: "Ich akzeptiere die Allgemeinen Geschäftsbedingungen und die Datenschutzrichtlinie von {{brand}}.",
      privacy_policy: "Datenschutzrichtlinie lesen",
      consent3: "Ich stimme der Verwendung meiner Daten zur Bearbeitung meines Antrags zu (DSGVO).",
      intro: "Bitte überprüfen Sie die folgenden Informationen, bevor Sie Ihren Antrag endgültig einreichen.",
      edit: "Bearbeiten"
    },
    loading: {
      step_id: "Identitätsprüfung",
      step_rib: "Analyse der Bankdaten",
      step_profile: "Profilauswertung",
      step_confirm: "Bestätigung senden",
      title: "Ihre Akte wird analysiert...",
      subtitle: "Unsere Tools überprüfen Ihre Dokumente sicher. Dies dauert weniger als eine Minute."
    },
    success: {
      step_verify: "Überprüfung",
      step_verify_desc: "Wir prüfen die Vollständigkeit Ihrer Dokumente.",
      step_analysis: "Analyse",
      step_analysis_desc: "Unsere Experten prüfen Ihr Finanzprofil.",
      step_contact: "Kontakt",
      step_contact_desc: "Ein Berater ruft Sie für ein Gespräch an.",
      step_decision: "Entscheidung",
      step_decision_desc: "Endgültiger Vorschlag und Unterschrift.",
      reference: "Antragsnummer",
      go_home: "Zurück zur Startseite",
      confirmation_sent: "Bestätigung gesendet an",
      title: "Ihr Antrag wurde eingereicht",
      dossier_number: "Antragsnummer",
      next_steps: "Nächste Schritte",
      amount: "Betrag",
      duration: "Laufzeit",
      monthly: "Rate",
      home: "Zurück zur Startseite"
    }
  },
  es: {
    app: {
      motif_required: "Motivo requerido",
      doc_required: "Documento requerido",
      rib_required: "Datos bancarios requeridos",
      error_generic: "Ocurrió un error. Por favor, inténtelo de nuevo más tarde.",
      error_backend: "El backend debe estar iniciado antes de continuar.",
      error_session: "Sesión expirada. Por favor, vuelva al inicio.",
      not_found_title: "Página no encontrada",
      not_found_body: "Esta ruta no existe o su sesión expiró.",
      home_button: "Volver al inicio",
      error_network: "Imposible contactar al servidor. Verifique su conexión."
    },
    otp: {
      email_fallback: "su dirección de correo electrónico",
      subtitle1: "Se ha enviado un código de verificación a",
      subtitle2: "Introdúzcalo a continuación para confirmar su solicitud.",
      error_send: "Fallo al enviar el código.",
      resend_success: "Se ha enviado un nuevo código.",
      error_resend: "Fallo al reenviar el código.",
      title: "Verificación de seguridad",
      validating: "Validando...",
      validate_button: "Validar código",
      resend_button: "Reenviar código por correo"
    },
    recap: {
      id_doc: "Documento de identidad",
      rib_doc: "Datos bancarios (RIB)",
      credit_details: "Detalles del Crédito",
      personal_info: "Información Personal",
      financial_info: "Situación Financiera",
      documents: "Documentos Enviados",
      amount: "Monto solicitado",
      duration: "Duración",
      monthly: "Cuota estimada",
      rate: "TAE fijo",
      total_cost: "Costo total",
      credit_cost: "Costo del crédito",
      fullname: "Nombre completo",
      birthdate: "Fecha de nacimiento",
      address: "Dirección",
      email: "Correo electrónico",
      phone: "Teléfono",
      income: "Ingresos netos",
      charges: "Cargos",
      motif: "Motivo",
      employer: "Empleador",
      not_provided: "No proporcionado",
      consent_title: "Consentimiento y Validación",
      consent1: "Certifico la exactitud de la información proporcionada.",
      consent2: "Acepto los Términos y Condiciones y la política de privacidad de {{brand}}.",
      privacy_policy: "Leer la política de privacidad",
      consent3: "Consiento el uso de mis datos para procesar mi solicitud (RGPD).",
      intro: "Por favor revise la siguiente información antes de enviar definitivamente su solicitud.",
      edit: "Editar"
    },
    loading: {
      step_id: "Verificación de identidad",
      step_rib: "Análisis de datos bancarios",
      step_profile: "Evaluación del perfil",
      step_confirm: "Envío de confirmación",
      title: "Analizando su expediente...",
      subtitle: "Nuestras herramientas verifican sus documentos de forma segura. Esto tomará menos de un minuto."
    },
    success: {
      step_verify: "Verificación",
      step_verify_desc: "Verificamos que sus documentos estén completos.",
      step_analysis: "Análisis",
      step_analysis_desc: "Nuestros expertos estudian su perfil financiero.",
      step_contact: "Contacto",
      step_contact_desc: "Un asesor le llamará para conversar.",
      step_decision: "Decisión",
      step_decision_desc: "Propuesta final y firma.",
      reference: "Número de expediente",
      go_home: "Volver al inicio",
      confirmation_sent: "Confirmación enviada a",
      title: "Su solicitud ha sido enviada",
      dossier_number: "Número de expediente",
      next_steps: "Próximos pasos",
      amount: "Monto",
      duration: "Duración",
      monthly: "Mensualidad",
      home: "Volver al inicio"
    }
  }
};

for (const file of files) {
  const lang = file.replace('.json', '');
  const filepath = path.join(localesDir, file);
  const data = JSON.parse(fs.readFileSync(filepath, 'utf8'));
  
  const adds = additions[lang];
  for (const [key, val] of Object.entries(adds)) {
    if (!data[key]) {
      data[key] = val;
    } else {
      Object.assign(data[key], val);
    }
  }
  
  fs.writeFileSync(filepath, JSON.stringify(data, null, 2));
}

console.log("Locales updated!");

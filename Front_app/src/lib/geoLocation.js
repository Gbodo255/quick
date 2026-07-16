/**
 * Service de détection géographique et de langue
 * Détecte le pays via l'IP et retourne la langue correspondante
 */

export const LANGUAGE_MAP = {
  'DE': 'de', // Allemagne
  'AT': 'de', // Autriche
  'CH': 'de', // Suisse (zone allemande)
  'ES': 'es', // Espagne
  'MX': 'es', // Mexique
  'AR': 'es', // Argentine
  'CL': 'es', // Chili
  'CO': 'es', // Colombie
  'PE': 'es', // Pérou
  // Autres pays par défaut en anglais
};

/**
 * Détecte le pays de l'utilisateur via son IP
 * @returns {Promise<string>} Code pays (ex: 'DE', 'ES', 'US')
 */
export const detectCountryFromIP = async () => {
  try {
    const response = await fetch(
      import.meta.env.VITE_GEOIP_URL || 'https://ipapi.co/json/'
    );
    const data = await response.json();
    return data.country_code || 'US';
  } catch {
    return 'US';
  }
};

/**
 * Détecte la langue préférée de l'utilisateur
 * Ordre: localStorage > pays détecté > navigateur > anglais (défaut)
 * @returns {Promise<string>} Code langue (en, de, es)
 */
export const detectLanguage = async () => {
  // 1. Vérifier localStorage
  const storedLang = localStorage.getItem('preferredLanguage');
  if (storedLang && ['en', 'de', 'es'].includes(storedLang)) {
    return storedLang;
  }

  // 2. Détecter via le pays
  const country = await detectCountryFromIP();
  const countryBasedLang = LANGUAGE_MAP[country];
  if (countryBasedLang) {
    return countryBasedLang;
  }

  // 3. Détecter via le navigateur
  const browserLang = navigator.language.split('-')[0];
  if (['de', 'es', 'en'].includes(browserLang)) {
    return browserLang;
  }

  // 4. Défaut: anglais
  return 'en';
};

/**
 * Sauvegarde la préférence de langue
 * @param {string} language - Code langue (en, de, es)
 */
export const saveLanguagePreference = (language) => {
  localStorage.setItem('preferredLanguage', language);
};

/**
 * Récupère la langue actuelle
 * @returns {string} Code langue
 */
export const getStoredLanguage = () => {
  return localStorage.getItem('preferredLanguage') || 'en';
};

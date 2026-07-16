/**
 * Service de traduction avec DeepL API
 * Stocke en cache les traductions pour optimiser les performances
 */

const CACHE_KEY = 'deepl_cache';
const CACHE_EXPIRY = 7 * 24 * 60 * 60 * 1000; // 7 jours

// Récupère le cache
const getCache = () => {
  try {
    const stored = localStorage.getItem(CACHE_KEY);
    if (!stored) return {};
    const cache = JSON.parse(stored);
    
    // Nettoyer les entrées expirées
    Object.keys(cache).forEach(key => {
      if (cache[key].expiry < Date.now()) {
        delete cache[key];
      }
    });
    
    return cache;
  } catch {
    return {};
  }
};

// Sauvegarde dans le cache
const saveToCache = (key, value) => {
  const cache = getCache();
  cache[key] = {
    value,
    expiry: Date.now() + CACHE_EXPIRY
  };
  localStorage.setItem(CACHE_KEY, JSON.stringify(cache));
};

/**
 * Traduit un texte via DeepL API
 * @param {string} text - Texte à traduire
 * @param {string} targetLanguage - Langue cible (en, de, es)
 * @returns {Promise<string>} Texte traduit
 */
export const translateWithDeepL = async (text, targetLanguage) => {
  if (!text) return text;

  const cacheKey = `${text}-${targetLanguage}`;
  const cached = getCache()[cacheKey];
  if (cached) {
    return cached.value;
  }

  try {
    const response = await fetch('/api/translate', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({
        text,
        targetLanguage,
      }),
    });

    if (!response.ok) {
      throw new Error(`DeepL API error: ${response.status}`);
    }

    const data = await response.json();
    const translatedText = data.translations[0]?.text || text;
    
    saveToCache(cacheKey, translatedText);
    return translatedText;
  } catch {
    return text; // Retourner le texte original en cas d'erreur
  }
};

/**
 * Traduit un objet JSON complet
 * @param {object} obj - Objet à traduire
 * @param {string} targetLanguage - Langue cible
 * @returns {Promise<object>} Objet traduit
 */
export const translateObject = async (obj, targetLanguage) => {
  if (targetLanguage === 'en') return obj; // Pas de traduction pour l'anglais

  const result = {};

  for (const [key, value] of Object.entries(obj)) {
    if (typeof value === 'string') {
      result[key] = await translateWithDeepL(value, targetLanguage);
    } else if (typeof value === 'object' && value !== null) {
      result[key] = await translateObject(value, targetLanguage);
    } else {
      result[key] = value;
    }
  }

  return result;
};

/**
 * Récupère la langue cible pour DeepL
 * @param {string} language - Code langue (en, de, es)
 * @returns {string} Code langue DeepL (EN, DE, ES)
 */
export const getDeepLLanguageCode = (language) => {
  const map = {
    en: 'EN',
    de: 'DE',
    es: 'ES',
  };
  return map[language] || 'EN';
};

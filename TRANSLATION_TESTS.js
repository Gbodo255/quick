/**
 * Tests pour le système de traduction
 * À exécuter dans la console du navigateur ou avec Node.js
 */

// ==================== TESTS FRONTEND ====================

// Test 1: Vérifier que i18next est initialisé
console.log('Test 1: i18next initialized?');
console.log('i18next.language:', window.i18next?.language);
console.log('i18next.isInitialized:', window.i18next?.isInitialized);

// Test 2: Tester une traduction simple
console.log('\nTest 2: Simple translation');
console.log('t("header.title"):', window.i18next?.t('header.title'));

// Test 3: Vérifier localStorage
console.log('\nTest 3: localStorage');
console.log('Preferred language:', localStorage.getItem('preferredLanguage'));

// Test 4: Tester la détection géographique
console.log('\nTest 4: Géolocalisation');
fetch('https://ipapi.co/json/')
  .then(r => r.json())
  .then(data => {
    console.log('Votre pays:', data.country_code);
    console.log('Votre IP:', data.ip);
  });

// Test 5: Tester l'API Backend
console.log('\nTest 5: DeepL API Backend');
fetch('/api/v1/translate', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify({
    text: 'Hello world',
    targetLanguage: 'de'
  })
})
  .then(r => r.json())
  .then(data => console.log('DeepL Response:', data));

// ==================== TESTS BACKEND ====================

// Lancer ces commandes dans le terminal

/*

# Test 1: Vérifier que l'API est accessible
curl http://localhost:8000/api/v1/health

# Test 2: Tester la traduction simple
curl -X POST http://localhost:8000/api/v1/translate \
  -H "Content-Type: application/json" \
  -d '{"text":"Hello world","targetLanguage":"de"}'

# Test 3: Tester la traduction d'un objet
curl -X POST http://localhost:8000/api/v1/translate/object \
  -H "Content-Type: application/json" \
  -d '{
    "data": {"title": "Hello", "desc": "World"},
    "targetLanguage": "de",
    "keysToTranslate": ["title", "desc"]
  }'

# Test 4: Vérifier l'utilisation de l'API
curl http://localhost:8000/api/v1/translate/usage

# Test 5: Vérifier les logs Laravel
tail -f storage/logs/laravel.log

*/

// ==================== HELPERS ====================

/**
 * Helper: Nettoyer le cache de traduction
 */
function clearTranslationCache() {
  localStorage.removeItem('deepl_cache');
  console.log('✅ Cache de traduction nettoyé');
}

/**
 * Helper: Tester toutes les langues
 */
async function testAllLanguages() {
  const text = 'Welcome to our platform';
  const languages = ['en', 'de', 'es'];

  for (const lang of languages) {
    try {
      const response = await fetch('/api/v1/translate', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          text,
          targetLanguage: lang
        })
      });
      const data = await response.json();
      console.log(`${lang}: ${data.translations[0].text}`);
    } catch (e) {
      console.error(`${lang}: Error -`, e.message);
    }
  }
}

/**
 * Helper: Changer la langue et rafraîchir
 */
function setLanguage(lang) {
  localStorage.setItem('preferredLanguage', lang);
  if (window.i18next) {
    window.i18next.changeLanguage(lang);
    console.log(`✅ Langue changée à: ${lang}`);
  }
}

/**
 * Helper: Afficher l'état du système
 */
function systemStatus() {
  return {
    i18nextReady: !!window.i18next?.isInitialized,
    currentLanguage: window.i18next?.language,
    preferredLanguage: localStorage.getItem('preferredLanguage'),
    backendUrl: window.location.origin === 'http://localhost:5173' 
      ? 'http://localhost:8000' 
      : 'production',
    cacheSize: localStorage.getItem('deepl_cache')?.length || 0,
  };
}

console.log('📚 Helpers disponibles:');
console.log('  - clearTranslationCache()');
console.log('  - testAllLanguages()');
console.log('  - setLanguage("en" | "de" | "es")');
console.log('  - systemStatus()');

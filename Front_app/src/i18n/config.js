import i18next from 'i18next';
import { initReactI18next } from 'react-i18next';
import en from './locales/en.json';
import de from './locales/de.json';
import es from './locales/es.json';
import fr from './locales/fr.json';

const SUPPORTED_LANGS = ['fr', 'en', 'de', 'es'];

// Toujours charger le site en français par défaut lors de l'arrivée sur le site
const detectLanguage = () => {
  return 'fr';
};

i18next
  .use(initReactI18next)
  .init({
    resources: {
      fr: { translation: fr },
      en: { translation: en },
      de: { translation: de },
      es: { translation: es },
    },
    lng: detectLanguage(),
    fallbackLng: 'fr',
    interpolation: {
      escapeValue: false,
    },
    react: {
      useSuspense: false,
    },
    debug: false,
  });

export default i18next;

/* eslint-disable react-refresh/only-export-components */
import { useTranslation } from 'react-i18next';

/**
 * Exemple d'utilisation de i18next dans un composant React
 * 
 * Utilisation basique:
 * const { t } = useTranslation();
 * 
 * <h1>{t('header.title')}</h1>
 * <p>{t('landing.description')}</p>
 */

export function ExampleComponent() {
  const { t, i18n } = useTranslation();

  return (
    <div>
      {/* Utilisation simple */}
      <h1>{t('header.title')}</h1>
      
      {/* Accès à des clés imbriquées */}
      <p>{t('landing.welcome')}</p>
      
      {/* Afficher la langue actuelle */}
      <p>Langue actuelle: {i18n.language}</p>
      
      {/* Changer de langue directement */}
      <button onClick={() => i18n.changeLanguage('en')}>English</button>
      <button onClick={() => i18n.changeLanguage('de')}>Deutsch</button>
      <button onClick={() => i18n.changeLanguage('es')}>Español</button>
    </div>
  );
}

/**
 * Hook personnalisé pour les traductions dynamiques
 */
export function useDynamicTranslation() {
  const { t, i18n } = useTranslation();

  return {
    t,
    language: i18n.language,
    changeLanguage: (lang) => i18n.changeLanguage(lang),
    isLoading: i18n.isInitialized === false,
  };
}

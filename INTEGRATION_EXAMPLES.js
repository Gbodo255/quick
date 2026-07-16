/**
 * EXEMPLES D'INTÉGRATION - Comment utiliser les traductions dans vos composants
 * 
 * Copier/coller ces exemples pour adapter vos composants existants
 */

// ==================== EXEMPLE 1: Composant simple ====================

// AVANT (sans traductions)
/*
export function LandingScreen() {
  return (
    <div>
      <h1>Welcome to Our Credit Service</h1>
      <p>Apply for a loan quickly and securely</p>
      <button>Get Started</button>
    </div>
  );
}
*/

// APRÈS (avec traductions)
import { useTranslation } from 'react-i18next';

export function LandingScreen() {
  const { t } = useTranslation();

  return (
    <div className="space-y-4">
      <h1>{t('landing.welcome')}</h1>
      <p>{t('landing.description')}</p>
      <button className="btn-primary">
        {t('landing.start')}
      </button>
    </div>
  );
}

// Ajouter au JSON (en.json):
// {
//   "landing": {
//     "welcome": "Welcome to Our Credit Service",
//     "description": "Apply for a loan quickly and securely",
//     "start": "Get Started"
//   }
// }

// ==================== EXEMPLE 2: Composant avec conditions ====================

import { useTranslation } from 'react-i18next';

export function FormScreen({ step, totalSteps }) {
  const { t } = useTranslation();

  return (
    <div>
      {/* Afficher l'étape avec traduction */}
      <h2>
        {t('form.step')} {step + 1} {t('form.of')} {totalSteps}
      </h2>

      {/* Contenu selon l'étape */}
      {step === 0 && (
        <div>
          <h3>{t('form.personal_info')}</h3>
          {/* ... formulaire ... */}
        </div>
      )}

      {step === 1 && (
        <div>
          <h3>{t('form.contact_info')}</h3>
          {/* ... formulaire ... */}
        </div>
      )}

      {/* Boutons */}
      <div className="flex gap-2">
        <button>{t('form.previous')}</button>
        <button>{t('form.next')}</button>
      </div>
    </div>
  );
}

// ==================== EXEMPLE 3: Composant avec erreurs/messages ====================

import { useTranslation } from 'react-i18next';

export function OtpScreen({ error, loading }) {
  const { t } = useTranslation();

  return (
    <div>
      <h2>{t('otp.title')}</h2>
      <p>{t('otp.description')}</p>

      {error && (
        <div className="error-banner">
          {t('otp.error')}
        </div>
      )}

      <input 
        type="text"
        placeholder={t('otp.title')}
      />

      <button disabled={loading}>
        {loading ? 'Verifying...' : t('otp.verify')}
      </button>

      <button className="text-link">
        {t('otp.resend')}
      </button>
    </div>
  );
}

// ==================== EXEMPLE 4: Composant avec liste ====================

import { useTranslation } from 'react-i18next';

export function FeaturesList() {
  const { t } = useTranslation();

  const features = [
    { id: 'fast', label: t('landing.features.fast') },
    { id: 'secure', label: t('landing.features.secure') },
    { id: 'transparent', label: t('landing.features.transparent') },
  ];

  return (
    <ul className="features">
      {features.map(feature => (
        <li key={feature.id}>{feature.label}</li>
      ))}
    </ul>
  );
}

// ==================== EXEMPLE 5: Composant avec traductions dynamiques ====================

import { useTranslation } from 'react-i18next';
import { useState, useEffect } from 'react';

export function DynamicContent() {
  const { t, i18n } = useTranslation();
  const [content, setContent] = useState('');

  useEffect(() => {
    // Recharger le contenu quand la langue change
    fetchContent(i18n.language);
  }, [i18n.language]);

  const fetchContent = async (language) => {
    const response = await fetch(`/api/content/${language}`);
    const data = await response.json();
    setContent(data);
  };

  return (
    <div>
      <h1>{t('header.title')}</h1>
      <p>{content}</p>
    </div>
  );
}

// ==================== EXEMPLE 6: Traductions avec variables ====================

import { useTranslation } from 'react-i18next';

export function WelcomeUser({ userName }) {
  const { t } = useTranslation();

  return (
    <div>
      {/* JSON: "welcome_user": "Welcome, {{name}}!" */}
      <h1>{t('welcome_user', { name: userName })}</h1>
    </div>
  );
}

// ==================== EXEMPLE 7: Composant avec switch de langue ====================

import { useTranslation } from 'react-i18next';
import { LanguageSwitcher } from '@/components/lumina/LanguageSwitcher';

export function Header() {
  const { t } = useTranslation();

  return (
    <header className="flex justify-between items-center p-4">
      <h1>{t('header.title')}</h1>
      <LanguageSwitcher />
    </header>
  );
}

// ==================== EXEMPLE 8: Hook personnalisé ====================

import { useTranslation } from 'react-i18next';
import { useEffect, useState } from 'react';

/**
 * Hook pour tracer les changements de langue
 */
export function useLanguageChange(callback) {
  const { i18n } = useTranslation();
  const [previousLanguage, setPreviousLanguage] = useState(i18n.language);

  useEffect(() => {
    if (i18n.language !== previousLanguage) {
      callback(i18n.language);
      setPreviousLanguage(i18n.language);
    }
  }, [i18n.language]);
}

// Usage:
function MyComponent() {
  useLanguageChange((newLang) => {
    console.log('Langue changée à:', newLang);
    // Faire quelque chose quand la langue change
  });

  return <div>Content</div>;
}

// ==================== EXEMPLE 9: Pluralisations ====================

import { useTranslation } from 'react-i18next';

export function DocumentCount({ count }) {
  const { t } = useTranslation();

  // JSON: "documents_count": "{{count}} document",
  //       "documents_count_plural": "{{count}} documents"
  return (
    <p>
      {t('documents_count', { count, defaultValue: 'document' })}
    </p>
  );
}

// ==================== EXEMPLE 10: Formatage des dates ====================

import { useTranslation } from 'react-i18next';
import { format } from 'date-fns';
import { de, es, enUS } from 'date-fns/locale';

export function FormattedDate({ date }) {
  const { i18n } = useTranslation();

  const localeMap = {
    en: enUS,
    de: de,
    es: es,
  };

  const locale = localeMap[i18n.language] || enUS;

  return (
    <span>
      {format(new Date(date), 'PPP', { locale })}
    </span>
  );
}

// ==================== CHECKLIST DE MIGRATION ====================

/*

Quand vous migrez un composant vers les traductions, suivez cette checklist:

□ 1. Importer useTranslation
   import { useTranslation } from 'react-i18next';

□ 2. Initialiser le hook dans le composant
   const { t } = useTranslation();

□ 3. Remplacer tous les textes hardcodés
   "Old text" → {t('key.for.text')}

□ 4. Ajouter les traductions dans les fichiers JSON
   src/i18n/locales/en.json (et de.json, es.json)

□ 5. Tester la traduction
   - Sélectionner différentes langues
   - Vérifier que tous les textes changent

□ 6. Vérifier la mise en page
   - Certaines langues sont plus longues (allemand)
   - S'assurer que les textes ne cassent pas la mise en page

□ 7. Tester la persistance
   - Rafraîchir la page
   - La langue devrait rester la même

*/

// ==================== OUTILS UTILES ====================

/*

# Rechercher tous les t() manquants:
grep -r "t('.*')" src/ | grep -v ".json" | wc -l

# Lister toutes les clés de traduction utilisées:
grep -r "t('" src/ --include="*.jsx" | sed "s/.*t('\([^']*\)'.*/\1/" | sort -u

# Vérifier qu'une clé existe dans tous les fichiers:
for file in src/i18n/locales/*.json; do
  grep -l '"my.key"' "$file" || echo "Manquant dans $file"
done

*/

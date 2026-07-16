import { useEffect, useState, useRef } from 'react';
import { useTranslation } from 'react-i18next';

// flagcdn.com fournit des images de drapeaux fiables (format: /w20/{country_code}.png)
const LANGUAGES = [
  { code: 'fr', name: 'Français',  countryCode: 'fr' },
  { code: 'en', name: 'English',   countryCode: 'gb' },
  { code: 'de', name: 'Deutsch',   countryCode: 'de' },
  { code: 'es', name: 'Español',   countryCode: 'es' },
];

function FlagImg({ countryCode, size = 24, className = '' }) {
  return (
    <img
      src={`https://flagcdn.com/w40/${countryCode}.png`}
      srcSet={`https://flagcdn.com/w80/${countryCode}.png 2x`}
      width={size}
      height={Math.round(size * 0.75)}
      alt={countryCode.toUpperCase()}
      className={`object-cover rounded-sm shadow-sm ${className}`}
      loading="lazy"
    />
  );
}

export function LanguageSwitcher({ variant = 'default' }) {
  const { t, i18n } = useTranslation();
  const [isOpen, setIsOpen] = useState(false);
  const ref = useRef(null);

  // Fermer le dropdown si clic à l'extérieur
  useEffect(() => {
    const handleClickOutside = (e) => {
      if (ref.current && !ref.current.contains(e.target)) {
        setIsOpen(false);
      }
    };
    document.addEventListener('mousedown', handleClickOutside);
    return () => document.removeEventListener('mousedown', handleClickOutside);
  }, []);

  const handleLanguageChange = (code) => {
    i18n.changeLanguage(code);
    localStorage.setItem('preferredLanguage', code);
    setIsOpen(false);
  };

  const currentLang = LANGUAGES.find((l) => l.code === i18n.language) || LANGUAGES[0];

  // Style du bouton selon le contexte (header sombre hero vs header clair)
  const isLight = variant === 'light';

  const btnClass = isLight
    ? 'flex items-center gap-2 rounded-lg px-2 py-1.5 text-white transition-colors hover:bg-white/20'
    : 'flex items-center gap-2 rounded-lg px-2 py-1.5 text-lumina-on-surface transition-colors hover:bg-lumina-surface-container-low';

  return (
    <div className="relative" ref={ref}>
      <button
        type="button"
        onClick={() => setIsOpen((o) => !o)}
        className={btnClass}
        aria-haspopup="listbox"
        aria-expanded={isOpen}
        title={t('select_language')}
      >
        <FlagImg countryCode={currentLang.countryCode} size={22} />
        <span className="text-sm font-semibold tracking-wide">{currentLang.code.toUpperCase()}</span>
        {/* Petite flèche */}
        <svg
          className={`h-3 w-3 opacity-60 transition-transform ${isOpen ? 'rotate-180' : ''}`}
          viewBox="0 0 20 20"
          fill="currentColor"
          aria-hidden
        >
          <path fillRule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clipRule="evenodd" />
        </svg>
      </button>

      {isOpen && (
        <div
          role="listbox"
          className="absolute right-0 top-full z-50 mt-2 min-w-[100px] overflow-hidden rounded-xl border border-lumina-outline bg-lumina-surface-lowest shadow-xl"
        >
          {LANGUAGES.map((lang) => {
            const isActive = i18n.language === lang.code;
            return (
              <button
                key={lang.code}
                role="option"
                aria-selected={isActive}
                type="button"
                onClick={() => handleLanguageChange(lang.code)}
                className={`flex w-full items-center gap-3 px-4 py-2.5 text-left text-sm transition-colors
                  ${isActive
                    ? 'bg-lumina-secondary/10 font-semibold text-lumina-secondary'
                    : 'text-lumina-on-surface hover:bg-lumina-surface-container-low'
                  }`}
              >
                <FlagImg countryCode={lang.countryCode} size={22} />
                <span className="flex-1 font-semibold tracking-wide">{lang.code.toUpperCase()}</span>
                {isActive && (
                  <svg className="h-4 w-4 text-lumina-secondary" viewBox="0 0 20 20" fill="currentColor" aria-hidden>
                    <path fillRule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clipRule="evenodd" />
                  </svg>
                )}
              </button>
            );
          })}
        </div>
      )}
    </div>
  );
}

import React from 'react';
import { SEO } from '@/components/SEO';
import { useTranslation } from 'react-i18next';
import { HeaderSection } from '../landing/HeaderSection';
import { BrandLogo } from '../BrandLogo';
import { BRAND_WORDMARK } from '@/lib/credit';

export function FaqScreen({ onBack, onNavigate }) {
  const { t } = useTranslation();

  const faqSchema = {
    "@type": "FAQPage",
    "mainEntity": [
      {
        "@type": "Question",
        "name": "Comment obtenir un crédit rapidement ?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Pour obtenir un crédit rapidement, remplissez notre formulaire en ligne, téléchargez vos documents et signez électroniquement."
        }
      },
      {
        "@type": "Question",
        "name": "Quels documents sont nécessaires ?",
        "acceptedAnswer": {
          "@type": "Answer",
          "text": "Vous aurez besoin d'une pièce d'identité valide, d'un justificatif de domicile et de vos derniers relevés bancaires ou fiches de paie."
        }
      }
    ]
  };

  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO 
        title="Foire Aux Questions (FAQ)" 
        description="Trouvez les réponses à toutes vos questions sur la demande de crédit rapide en ligne avec CreditEco."
        schema={faqSchema}
      />
      <header className="sticky top-0 z-40 bg-lumina-surface-lowest/80 backdrop-blur-md border-b border-lumina-outline px-6 py-4 flex items-center justify-between">
        <button onClick={onBack} className="inline-flex items-center gap-2 hover:opacity-80">
          <BrandLogo size="lg" />
        </button>
        <button onClick={onBack} className="text-sm font-medium hover:underline">
          Retour
        </button>
      </header>

      <main className="flex-1 max-w-4xl mx-auto px-6 py-12 w-full">
        <h1 className="text-3xl font-bold mb-8">Foire Aux Questions (FAQ)</h1>
        
        <div className="space-y-6">
          <div>
            <h3 className="font-semibold text-lg">Comment obtenir un crédit rapidement en ligne ?</h3>
            <p className="text-lumina-on-surface-variant mt-2">La simulation prend 2 minutes. Si votre dossier est pré-accepté, le déblocage des fonds se fait généralement sous 24 à 48 heures ouvrées après vérification de vos pièces justificatives.</p>
          </div>
          <div>
            <h3 className="font-semibold text-lg">Quels sont les documents à fournir ?</h3>
            <p className="text-lumina-on-surface-variant mt-2">Nous demandons les pièces standard : une pièce d'identité en cours de validité (carte d'identité ou passeport) et un RIB pour le versement des fonds.</p>
          </div>
          <div>
            <h3 className="font-semibold text-lg">La simulation est-elle gratuite ?</h3>
            <p className="text-lumina-on-surface-variant mt-2">Oui, la simulation de crédit sur {BRAND_WORDMARK.prefix}{BRAND_WORDMARK.accent} est 100% gratuite et sans aucun engagement.</p>
          </div>
        </div>
      </main>
    </div>
  );
}

import React from 'react';
import { SEO } from '@/components/SEO';
import { BrandLogo } from '../BrandLogo';
import { BRAND_WORDMARK } from '@/lib/credit';

export function AboutScreen({ onBack }) {
  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO 
        title="À propos de nous" 
        description={`Découvrez l'histoire de ${BRAND_WORDMARK.prefix}${BRAND_WORDMARK.accent}, la plateforme de financement rapide en ligne européenne.`}
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
        <h1 className="text-3xl font-bold mb-8">Notre Mission</h1>
        
        <div className="space-y-6 text-lumina-on-surface-variant leading-relaxed">
          <p>
            {BRAND_WORDMARK.prefix}{BRAND_WORDMARK.accent} est né d'une conviction simple : l'accès au financement doit être transparent, rapide et accessible à tous, sans tracasseries administratives.
          </p>
          <p>
            En tant qu'acteur européen du crédit à la consommation 100% digital, nous repensons le parcours d'emprunt. Fini les rendez-vous en agence et les dossiers papier interminables. Grâce à l'Open Banking et aux dernières technologies financières, nous vous offrons une décision de principe immédiate.
          </p>
          <h2 className="text-xl font-semibold text-lumina-heading mt-6">Notre Expertise E-E-A-T</h2>
          <p>
            Nous travaillons avec des partenaires bancaires certifiés pour garantir la sécurité de vos données (Expertise et Fiabilité). Tous nos conseillers sont basés en Europe et formés aux normes de régulation financière (Autorité).
          </p>
        </div>
      </main>
    </div>
  );
}

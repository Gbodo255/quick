import React from 'react';
import { SEO } from '@/components/SEO';
import { BrandLogo } from '../BrandLogo';

export function ContactScreen({ onBack }) {
  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO title="Contactez-nous" />
      <header className="sticky top-0 z-40 bg-lumina-surface-lowest/80 backdrop-blur-md border-b border-lumina-outline px-6 py-4 flex items-center justify-between">
        <button onClick={onBack} className="inline-flex items-center gap-2 hover:opacity-80">
          <BrandLogo size="lg" />
        </button>
        <button onClick={onBack} className="text-sm font-medium hover:underline">
          Retour
        </button>
      </header>
      <main className="flex-1 max-w-4xl mx-auto px-6 py-12 w-full">
        <h1 className="text-3xl font-bold mb-8">Nous Contacter</h1>
        <div className="space-y-6 text-lumina-on-surface-variant leading-relaxed">
          <p>Besoin d'aide avec votre dossier de financement ? Notre équipe est là pour vous répondre.</p>
          <div className="bg-lumina-surface-lowest p-6 rounded-lg border border-lumina-outline">
            <h2 className="text-lg font-semibold text-lumina-heading mb-2">Service Client</h2>
            <p>Email : support@crediteco.app</p>
            <p>Horaires : Du lundi au vendredi, de 9h à 18h.</p>
          </div>
        </div>
      </main>
    </div>
  );
}

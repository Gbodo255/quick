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
          <div className="grid gap-6 md:grid-cols-2">
            <div className="bg-lumina-surface-lowest p-6 rounded-lg border border-lumina-outline shadow-sm">
              <div className="flex items-center gap-3 mb-4">
                <div className="size-12 rounded-lg bg-lumina-surface-container flex items-center justify-center text-lumina-primary text-xl font-bold">
                  🏠
                </div>
                <div>
                  <h2 className="text-lg font-bold text-lumina-heading">Julien Verran</h2>
                  <p className="text-xs font-semibold text-lumina-secondary">Courtier en crédit immobilier &amp; prêt à la consommation</p>
                </div>
              </div>
              <div className="space-y-2 text-sm text-lumina-on-surface">
                <p className="flex items-center gap-2">
                  <span className="font-bold">Téléphone :</span>
                  <a href="tel:+33780961216" className="font-bold text-lumina-heading hover:text-lumina-secondary hover:underline">
                    +33 7 80 96 12 16
                  </a>
                </p>
                <p className="flex items-center gap-2">
                  <span className="font-bold">E-mail :</span>
                  <a href="mailto:support@crediteco.app" className="text-lumina-secondary hover:underline">
                    support@crediteco.app
                  </a>
                </p>
                <p className="flex items-center gap-2">
                  <span className="font-bold">Site Web :</span>
                  <a href="https://crediteco.app" className="text-lumina-secondary hover:underline">
                    crediteco.app
                  </a>
                </p>
              </div>
            </div>

            <div className="bg-lumina-surface-lowest p-6 rounded-lg border border-lumina-outline shadow-sm flex flex-col justify-between">
              <div>
                <h2 className="text-lg font-semibold text-lumina-heading mb-2">Horaires &amp; Accompagnement</h2>
                <p className="text-sm text-lumina-on-surface-variant leading-relaxed mb-4">
                  Accompagnement personnalisé pour le financement de vos projets immobiliers &amp; prêts à la consommation (Résidence principale, Investissement locatif, Renégociation, Prêt personnel).
                </p>
              </div>
              <div className="text-xs text-lumina-on-surface-variant border-t border-lumina-outline-variant pt-3">
                🕒 Lun – Ven : 9h00 – 18h00
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  );
}

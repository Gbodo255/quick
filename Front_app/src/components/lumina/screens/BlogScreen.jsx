import React from 'react';
import { SEO } from '@/components/SEO';
import { BrandLogo } from '../BrandLogo';
import { articles } from '@/data/articles';

export function BlogScreen({ onBack, onReadArticle }) {
  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO 
        title="Nos conseils et actualités" 
        description="Découvrez tous nos articles et conseils pour mieux comprendre le crédit, améliorer votre profil emprunteur et réussir votre demande de financement."
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
        <h1 className="text-3xl font-bold mb-8">Conseils Financiers</h1>
        <div className="grid gap-6">
          {articles.map((article) => (
            <div 
              key={article.id} 
              onClick={() => onReadArticle(article.id)}
              className="bg-lumina-surface-lowest p-6 rounded-lg border border-lumina-outline hover:border-lumina-primary cursor-pointer transition"
            >
              <span className="text-xs text-lumina-on-surface-variant font-medium">
                {new Date(article.date).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' })}
              </span>
              <h2 className="text-xl font-semibold text-lumina-heading mt-2">{article.title}</h2>
              <p className="text-sm text-lumina-on-surface-variant mt-2 mb-4 leading-relaxed line-clamp-2">
                {article.excerpt}
              </p>
              <span className="text-sm font-medium text-lumina-primary hover:underline">
                Lire l'article complet →
              </span>
            </div>
          ))}
        </div>
      </main>
    </div>
  );
}

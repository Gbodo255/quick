import React, { useEffect, useRef } from 'react';
import { SEO } from '@/components/SEO';
import { BrandLogo } from '../BrandLogo';
import { articles } from '@/data/articles';

export function ArticleScreen({ articleId, onBack, onStartSimulator }) {
  const article = articles.find(a => a.id === articleId);
  const contentRef = useRef(null);

  useEffect(() => {
    window.scrollTo(0, 0);
  }, [articleId]);

  if (!article) {
    return (
      <div className="flex flex-col items-center justify-center min-h-screen">
        <h1 className="text-2xl font-bold">Article introuvable</h1>
        <button onClick={onBack} className="mt-4 text-lumina-primary hover:underline">
          Retour aux conseils
        </button>
      </div>
    );
  }

  const articleSchema = {
    "@type": "Article",
    "headline": article.title,
    "datePublished": article.date,
    "description": article.excerpt,
    "author": {
      "@type": "Organization",
      "name": "CreditEco"
    }
  };

  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO 
        title={article.title} 
        description={article.excerpt}
        schema={articleSchema}
      />
      <header className="sticky top-0 z-40 bg-lumina-surface-lowest/80 backdrop-blur-md border-b border-lumina-outline px-6 py-4 flex items-center justify-between">
        <button onClick={onBack} className="inline-flex items-center gap-2 hover:opacity-80">
          <BrandLogo size="lg" />
        </button>
        <button onClick={onBack} className="text-sm font-medium hover:underline">
          Retour aux articles
        </button>
      </header>

      <main className="flex-1 max-w-3xl mx-auto px-6 py-12 w-full">
        <div className="mb-8">
          <span className="text-sm text-lumina-on-surface-variant font-medium">
            Publié le {new Date(article.date).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' })}
          </span>
          <h1 className="text-3xl sm:text-4xl font-bold mt-4 leading-tight">{article.title}</h1>
        </div>

        <article 
          ref={contentRef}
          className="prose prose-lumina max-w-none 
            prose-headings:font-bold prose-headings:text-lumina-heading 
            prose-p:text-lumina-on-surface-variant prose-p:leading-relaxed 
            prose-a:text-lumina-primary prose-a:no-underline hover:prose-a:underline
            prose-strong:text-lumina-heading prose-strong:font-semibold
            prose-ul:text-lumina-on-surface-variant
            prose-h2:text-2xl prose-h2:mt-10 prose-h2:mb-4
            prose-h3:text-xl prose-h3:mt-8 prose-h3:mb-3"
          dangerouslySetInnerHTML={{ __html: article.content }}
        />

        <div className="mt-16 p-8 bg-lumina-surface-lowest border border-lumina-outline rounded-xl text-center">
          <h3 className="text-xl font-bold mb-3">Besoin d'un financement rapide ?</h3>
          <p className="text-lumina-on-surface-variant mb-6">
            Obtenez une réponse de principe immédiate en simulant votre projet en ligne. C'est 100% gratuit et sans engagement.
          </p>
          <button 
            onClick={onStartSimulator}
            className="btn-clenar py-3 px-8 text-base font-semibold inline-flex items-center justify-center w-full sm:w-auto"
          >
            Faire ma simulation maintenant
          </button>
        </div>
      </main>
    </div>
  );
}

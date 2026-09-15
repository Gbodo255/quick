import { useEffect, useRef } from 'react';
import { SEO } from '@/components/SEO';
import { articles } from '@/data/articles';

export function ArticleScreen({ articleId, onBack, onStartSimulator, footer }) {
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
      "name": "StudCredit"
    }
  };

  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO
        title={article.title}
        description={article.excerpt}
        schema={articleSchema}
      />

      <main className="flex-1 mx-auto w-full max-w-3xl px-6 pt-24 pb-20 md:pt-32">
        <div className="mb-10">
          <span className="text-sm text-lumina-on-surface-variant font-medium">
            Publié le {new Date(article.date).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' })}
          </span>
          <h1 className="font-[family-name:var(--font-headline)] text-3xl sm:text-4xl font-semibold tracking-tight text-lumina-heading mt-4 leading-tight">{article.title}</h1>
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

        <div className="mt-16 border border-lumina-outline bg-lumina-surface-lowest p-8 text-center">
          <h3 className="text-xl font-bold mb-3">Besoin d'un financement rapide ?</h3>
          <p className="text-lumina-on-surface-variant mb-6">
            Obtenez une réponse de principe immédiate en simulant votre projet en ligne. C'est 100% gratuit et sans engagement.
          </p>
          <button
            onClick={onStartSimulator}
            className="inline-flex h-11 items-center justify-center rounded-md bg-lumina-primary px-8 text-sm font-semibold text-white transition-colors hover:bg-lumina-brand w-full sm:w-auto"
          >
            Faire ma simulation maintenant
          </button>
        </div>
      </main>
      {footer}
    </div>
  );
}

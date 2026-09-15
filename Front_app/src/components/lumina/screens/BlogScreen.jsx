import { SEO } from '@/components/SEO';
import { articles } from '@/data/articles';

export function BlogScreen({ onReadArticle, footer }) {
  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO
        title="Nos conseils et actualités | StudCredit"
        description="Découvrez tous nos articles et conseils pour mieux comprendre le crédit, améliorer votre profil emprunteur et réussir votre demande de financement."
      />

      <main className="flex-1 mx-auto w-full max-w-4xl px-6 pt-24 pb-20 md:pt-32">
        <p className="mb-3 text-xs font-semibold tracking-widest text-lumina-primary uppercase">Le mag</p>
        <h1 className="font-[family-name:var(--font-headline)] text-4xl font-semibold tracking-tight text-lumina-heading md:text-5xl mb-10">
          Conseils Financiers
        </h1>

        <div className="border-t border-lumina-outline">
          {articles.map((article) => (
            <button
              type="button"
              key={article.id}
              onClick={() => onReadArticle(article.id)}
              className="block w-full border-b border-lumina-outline py-8 text-left transition-colors hover:bg-lumina-surface-container-low"
            >
              <span className="text-xs text-lumina-on-surface-variant font-medium">
                {new Date(article.date).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' })}
              </span>
              <h2 className="font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-heading mt-2">{article.title}</h2>
              <p className="max-w-2xl text-sm text-lumina-on-surface-variant mt-2 mb-3 leading-relaxed line-clamp-2">
                {article.excerpt}
              </p>
              <span className="text-sm font-semibold text-lumina-primary">
                Lire l'article complet →
              </span>
            </button>
          ))}
        </div>
      </main>
      {footer}
    </div>
  );
}

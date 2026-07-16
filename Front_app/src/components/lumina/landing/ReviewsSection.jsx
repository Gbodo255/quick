import { Star, ShieldCheck } from 'lucide-react'
import { useTranslation } from 'react-i18next'

const REVIEW_INDICES = [0, 1, 2, 3, 4, 5]
const REVIEW_IMAGES = [
  'https://randomuser.me/api/portraits/women/44.jpg',
  'https://randomuser.me/api/portraits/men/32.jpg',
  'https://randomuser.me/api/portraits/men/65.jpg',
  'https://randomuser.me/api/portraits/women/68.jpg',
  'https://randomuser.me/api/portraits/men/12.jpg',
  'https://randomuser.me/api/portraits/women/52.jpg',
]

export function ReviewsSection() {
  const { t } = useTranslation()
  return (
    <section id="avis" className="bg-lumina-surface-light border-y border-lumina-outline py-16 scroll-mt-24">
      <div className="mx-auto max-w-6xl px-6">
        
        <div className="flex flex-col items-start justify-between gap-5 md:flex-row md:items-center">
          <div className="max-w-2xl">
            <span className="inline-flex items-center gap-2 rounded-full border border-lumina-outline bg-lumina-surface-lowest px-3 py-1 text-xs font-medium text-lumina-on-surface shadow-sm">
              {t('landing.reviews_badge', 'Ils ont signé avec nous')}
            </span>
            <h2 className="mt-3 font-[family-name:var(--font-headline)] text-3xl leading-tight font-semibold md:text-4xl text-balance text-lumina-heading">
              {t('landing.reviews_title', '2 000+ projets financés.')}
            </h2>
          </div>
          
          <div className="flex flex-col gap-4 rounded-2xl bg-white px-5 py-4 sm:flex-row sm:items-center sm:gap-5 border border-lumina-outline shadow-sm">
            <div className="flex flex-col items-start gap-1">
              <div className="flex items-center gap-2">
                <div className="flex text-[#00b67a]">
                  <Star className="h-5 w-5 fill-current" />
                  <Star className="h-5 w-5 fill-current" />
                  <Star className="h-5 w-5 fill-current" />
                  <Star className="h-5 w-5 fill-current" />
                  <Star className="h-5 w-5 fill-current" />
                </div>
                <span className="font-[family-name:var(--font-headline)] font-bold text-lumina-heading">Trustpilot</span>
              </div>
              <span className="text-xs text-lumina-on-surface-variant font-medium">4,8/5 {t('landing.reviews_verified', 'sur 1 247 avis vérifiés')}</span>
            </div>
            
            <div className="flex items-center gap-2 border-t border-lumina-outline pt-3 sm:border-t-0 sm:border-l sm:pt-0 sm:pl-5">
              <ShieldCheck className="h-8 w-8 shrink-0 text-lumina-primary" />
              <span className="max-w-[120px] text-xs font-medium leading-tight text-lumina-on-surface-variant">
                {t('landing.reviews_regulated', 'Plate-forme régulée par les autorités françaises')}
              </span>
            </div>
          </div>
        </div>
        
        <div className="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-3">
          {REVIEW_INDICES.map((i) => (
            <article key={i} className="surface-card p-6 flex flex-col hover:border-lumina-primary/40 transition-colors">
              <header className="flex items-center gap-3">
                <img 
                  src={REVIEW_IMAGES[i]} 
                  alt={t(`landing.review_${i}_name`)} 
                  loading="lazy" 
                  className="h-11 w-11 rounded-full object-cover border-2 border-lumina-surface-light shadow-sm"
                />
                <div className="min-w-0 flex-1">
                  <p className="font-semibold text-lumina-heading truncate">{t(`landing.review_${i}_name`)}</p>
                  <p className="text-xs text-lumina-on-surface-variant">{t(`landing.review_${i}_city`)}</p>
                </div>
                <div className="flex gap-0.5 shrink-0 text-lumina-warning">
                  <Star className="h-3.5 w-3.5 fill-current" />
                  <Star className="h-3.5 w-3.5 fill-current" />
                  <Star className="h-3.5 w-3.5 fill-current" />
                  <Star className="h-3.5 w-3.5 fill-current" />
                  <Star className="h-3.5 w-3.5 fill-current" />
                </div>
              </header>
              <p className="mt-4 text-sm leading-relaxed text-lumina-on-surface font-medium flex-1">
                {t(`landing.review_${i}_text`)}
              </p>
              <footer className="mt-4 border-t border-lumina-outline pt-3">
                <p className="text-xs text-lumina-on-surface-variant font-medium">
                  {t(`landing.review_${i}_project`).split('taux obtenu').map((part, index) => (
                    <span key={index}>
                      {index === 0 ? part : <span className="font-semibold text-lumina-primary">taux obtenu{part}</span>}
                    </span>
                  ))}
                </p>
              </footer>
            </article>
          ))}
        </div>
        
      </div>
    </section>
  )
}

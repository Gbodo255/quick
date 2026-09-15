import { useState } from 'react'
import { Star, ChevronLeft, ChevronRight } from 'lucide-react'
import { useTranslation } from 'react-i18next'
import reviewCamille from '@/assets/reviews/review-0-camille.jpg'
import reviewThomas from '@/assets/reviews/review-1-thomas.jpg'
import reviewHakim from '@/assets/reviews/review-2-hakim.jpg'
import reviewSophie from '@/assets/reviews/review-3-sophie.jpg'
import reviewJules from '@/assets/reviews/review-4-jules.jpg'
import reviewAicha from '@/assets/reviews/review-5-aicha.jpg'

const REVIEW_INDICES = [0, 1, 2, 3, 4, 5]
const REVIEW_IMAGES = [
  reviewCamille,
  reviewThomas,
  reviewHakim,
  reviewSophie,
  reviewJules,
  reviewAicha,
]

export function ReviewsSection() {
  const { t } = useTranslation()
  const [index, setIndex] = useState(0)
  const count = REVIEW_INDICES.length

  const prev = () => setIndex((i) => (i - 1 + count) % count)
  const next = () => setIndex((i) => (i + 1) % count)

  return (
    <section id="avis" className="flex min-h-[85svh] flex-col justify-center bg-lumina-surface-light border-y border-lumina-outline py-16 scroll-mt-24">
      <div className="mx-auto w-full max-w-6xl px-6">

        <div className="flex flex-wrap items-end justify-between gap-4">
          <div className="max-w-2xl">
            <h2 className="font-[family-name:var(--font-headline)] text-3xl leading-tight font-semibold md:text-4xl text-balance text-lumina-heading">
              {t('landing.reviews_title', 'Avis et commentaires')}
            </h2>
          </div>

          <div className="flex items-center gap-2">
            <button
              type="button"
              onClick={prev}
              aria-label="Avis précédent"
              className="flex h-10 w-10 items-center justify-center rounded-full border border-lumina-outline bg-white text-lumina-on-surface transition-colors hover:bg-lumina-surface-container-low"
            >
              <ChevronLeft className="h-5 w-5" />
            </button>
            <button
              type="button"
              onClick={next}
              aria-label="Avis suivant"
              className="flex h-10 w-10 items-center justify-center rounded-full border border-lumina-outline bg-white text-lumina-on-surface transition-colors hover:bg-lumina-surface-container-low"
            >
              <ChevronRight className="h-5 w-5" />
            </button>
          </div>
        </div>

        <div className="mt-10 overflow-hidden">
          <div
            className="flex transition-transform duration-500 ease-in-out"
            style={{ transform: `translateX(-${index * 100}%)` }}
          >
            {REVIEW_INDICES.map((i) => (
              <div key={i} className="w-full shrink-0 px-1">
                <div className="flex h-[480px] flex-col overflow-hidden rounded-lg border border-lumina-outline bg-white shadow-[var(--shadow-lumina-card)] sm:h-[320px] sm:flex-row md:h-[380px]">
                  <div className="h-56 shrink-0 sm:h-full sm:w-2/5">
                    <img
                      src={REVIEW_IMAGES[i]}
                      alt={t(`landing.review_${i}_name`)}
                      loading="lazy"
                      className="h-full w-full object-cover"
                    />
                  </div>

                  <div className="relative flex flex-1 flex-col justify-center overflow-hidden p-6 md:p-10">
                    <div className="absolute top-6 right-6 flex gap-0.5 text-lumina-warning">
                      <Star className="h-5 w-5 fill-current" />
                      <Star className="h-5 w-5 fill-current" />
                      <Star className="h-5 w-5 fill-current" />
                      <Star className="h-5 w-5 fill-current" />
                      <Star className="h-5 w-5 fill-current" />
                    </div>
                    <p className="font-[family-name:var(--font-headline)] text-lg font-semibold text-lumina-heading">
                      {t(`landing.review_${i}_name`)}
                    </p>
                    <p className="mt-4 line-clamp-4 text-xl leading-relaxed text-lumina-on-surface-variant md:text-2xl">
                      {t(`landing.review_${i}_text`)}
                    </p>
                  </div>
                </div>
              </div>
            ))}
          </div>
        </div>

      </div>
    </section>
  )
}

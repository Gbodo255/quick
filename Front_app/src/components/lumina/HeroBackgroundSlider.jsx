import { useCallback, useEffect, useState } from 'react'
import { cn } from '@/lib/utils'

const INTERVAL_MS = 4000
const TRANSITION_MS = 1200

export function HeroBackgroundSlider({ images, className }) {
  const count = images.length
  const slides = count > 1 ? [...images, images[0]] : images
  const slideCount = slides.length

  const [index, setIndex] = useState(0)
  const [paused, setPaused] = useState(false)
  const [reduceMotion, setReduceMotion] = useState(() => window.matchMedia('(prefers-reduced-motion: reduce)').matches)
  const [noTransition, setNoTransition] = useState(false)
  useEffect(() => {
    const mq = window.matchMedia('(prefers-reduced-motion: reduce)')
    const handler = (e) => setReduceMotion(e.matches)
    mq.addEventListener('change', handler)
    return () => mq.removeEventListener('change', handler)
  }, [])

  const advance = useCallback(() => {
    if (count <= 1) return
    setIndex((i) => {
      if (reduceMotion) return (i + 1) % count
      return i + 1
    })
  }, [count, reduceMotion])

  useEffect(() => {
    if (count <= 1 || paused) return undefined
    const id = setInterval(advance, INTERVAL_MS)
    return () => clearInterval(id)
  }, [count, paused, advance])

  const handleTransitionEnd = useCallback(() => {
    if (count <= 1 || reduceMotion) return
    if (index === slideCount - 1) {
      setNoTransition(true)
      setIndex(0)
      requestAnimationFrame(() => {
        requestAnimationFrame(() => setNoTransition(false))
      })
    }
  }, [index, slideCount, count, reduceMotion])

  if (count === 0) {
    return (
      <div
        className={cn('absolute inset-0 bg-lumina-surface-container', className)}
        aria-hidden
      />
    )
  }

  const translatePercent = (index * 100) / slideCount

  return (
    <div
      className={cn('absolute inset-0 overflow-hidden', className)}
      aria-hidden
      onMouseEnter={() => setPaused(true)}
      onMouseLeave={() => setPaused(false)}
    >
      <div
        className="hero-slider-track flex h-full will-change-transform"
        onTransitionEnd={handleTransitionEnd}
        style={{
          width: `${slideCount * 100}%`,
          transform: `translateX(-${translatePercent}%)`,
          transition:
            noTransition || reduceMotion
              ? 'none'
              : `transform ${TRANSITION_MS}ms cubic-bezier(0.4, 0, 0.2, 1)`,
        }}
      >
        {slides.map((src, i) => (
          <img
            key={`${src}-${i}`}
            src={src}
            alt=""
            className="h-full shrink-0 object-cover"
            style={{ width: `${100 / slideCount}%` }}
            loading={i <= 1 ? 'eager' : 'lazy'}
            decoding="async"
          />
        ))}
      </div>
    </div>
  )
}

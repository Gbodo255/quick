import { useEffect, useState } from 'react'
import { AlertTriangle } from 'lucide-react'
import { useTranslation } from 'react-i18next'
import { cn } from '@/lib/utils'

export function StickyCtaBar({ onOpenObjectifModal }) {
  const { t } = useTranslation()
  const [visible, setVisible] = useState(false)

  useEffect(() => {
    const hero = document.getElementById('simulateur')
    if (!hero) return undefined

    const observer = new IntersectionObserver(
      ([entry]) => setVisible(!entry.isIntersecting),
      { threshold: 0 },
    )
    observer.observe(hero)
    return () => observer.disconnect()
  }, [])

  return (
    <div
      aria-hidden={!visible}
      className={cn(
        'fixed inset-x-0 bottom-0 z-40 flex items-center justify-end gap-4 border-t border-lumina-outline bg-lumina-surface-lowest px-4 py-3 shadow-[0_-2px_12px_rgba(0,0,0,0.08)] transition-transform duration-300 sm:justify-between sm:px-6',
        visible ? 'translate-y-0' : 'pointer-events-none translate-y-full',
      )}
    >
      <p className="hidden max-w-none flex-1 items-center gap-3 text-base leading-snug text-lumina-on-surface-variant sm:flex">
        <AlertTriangle className="h-7 w-7 shrink-0 text-[#f43f5e]" />
        <span>
          {t(
            'landing.sticky_warning_text',
            "Un prêt coûte de l'argent et doit être remboursé. Assurez-vous d'être en mesure de le rembourser avant de le demander.",
          )}
        </span>
      </p>

      <button
        type="button"
        onClick={onOpenObjectifModal}
        className="inline-flex h-12 shrink-0 items-center justify-center rounded-md bg-lumina-primary px-6 text-sm font-semibold text-white transition-colors hover:bg-lumina-brand sm:px-12"
      >
        {t('landing.sticky_cta', 'Faire mon prêt')}
      </button>
    </div>
  )
}

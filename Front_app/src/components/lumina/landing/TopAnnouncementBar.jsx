import { useTranslation } from 'react-i18next'

export function TopAnnouncementBar() {
  const { t } = useTranslation()

  return (
    <div className="flex h-[5svh] min-h-9 items-center justify-center gap-2 bg-black px-4 text-center text-xs font-semibold tracking-tight text-white sm:text-sm md:text-base">
      <span className="truncate">{t('landing.top_bar', 'Un prêt étudiant simple, rapide et sans engagement.')}</span>
    </div>
  )
}

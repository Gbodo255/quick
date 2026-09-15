import { useTranslation } from 'react-i18next'
import { GraduationIllustration } from './GraduationIllustration'

export function TransparencyBanner() {
  const { t } = useTranslation()

  return (
    <section className="mx-auto flex min-h-[70svh] max-w-6xl items-center px-6 pb-24">
      <div className="flex w-full flex-col overflow-hidden bg-lumina-primary/70 md:flex-row">
        <div className="order-2 flex flex-col justify-center p-8 text-white md:order-1 md:w-1/2 md:p-14">
          <p className="font-[family-name:var(--font-headline)] font-semibold text-2xl md:text-3xl leading-tight">
            {t('landing.how_bottom_title', 'Un crédit reste un engagement financier.')}
          </p>
          <p className="mt-4 text-white/80 font-medium">
            {t('landing.how_bottom_text', 'Avant de vous engager, vérifiez le montant emprunté, le taux, le coût total, la durée, les mensualités et les conditions de remboursement. N’empruntez que ce que votre situation vous permet de rembourser.')}
          </p>
        </div>

        <div className="order-1 flex h-56 items-center justify-center p-8 md:order-2 md:h-auto md:w-1/2">
          <GraduationIllustration className="h-full w-full max-w-72" />
        </div>
      </div>
    </section>
  )
}

import { ShieldCheck, Star } from 'lucide-react'
import { useTranslation } from 'react-i18next'
import { SimulatorPanel } from '@/components/lumina/SimulatorPanel'

export function HeroSection({
  montant,
  setMontant,
  duree,
  setDuree,
  mensualite,
  motif,
  setMotif,
  revenuEstime,
  setRevenuEstime,
  coutTotal,
  totalRembourse,
  onStart,
  isLoading
}) {
  const { t } = useTranslation()
  return (
    <section className="relative -mt-[88px] flex pb-16 lg:pb-24 overflow-hidden pt-[88px]">
      {/* Background gradients using Lumina colors */}
      <div 
        aria-hidden="true" 
        className="pointer-events-none absolute inset-0 -z-10 opacity-30" 
        style={{
          background: 'radial-gradient(60% 50% at 15% 0%, var(--clenar-primary) 0%, transparent 55%), radial-gradient(40% 30% at 95% 80%, var(--clenar-primary) 0%, transparent 60%)'
        }}
      />
      
      <div className="mx-auto w-full max-w-6xl px-6 pb-12 pt-4 lg:pt-6">
        <div className="grid gap-12 lg:grid-cols-12 lg:items-center">
          
          <div className="lg:col-span-6">
            <span className="inline-flex items-center gap-2 rounded-full border border-lumina-outline bg-lumina-surface-lowest px-3 py-1 text-xs font-medium text-lumina-on-surface shadow-sm">
              <span className="h-1.5 w-1.5 rounded-full bg-lumina-primary" />
              {t('landing.hero_badge', 'Courtier IOBSP indépendant agréé ORIAS')}
            </span>
            <h1 className="mt-6 font-[family-name:var(--font-headline)] text-4xl leading-[1.05] font-semibold sm:text-5xl md:text-6xl text-balance text-lumina-heading">
              {t('landing.hero_title_1', 'Le prêt éco,')}<br />
              {t('landing.hero_title_2', 'enfin')} <span className="italic text-lumina-primary">{t('landing.hero_title_3', 'simple.')}</span>
            </h1>
            <p className="mt-6 max-w-2xl text-lg text-lumina-on-surface-variant leading-relaxed">
              {t('landing.hero_subtitle', 'On négocie ton prêt éco auprès de 30+ banques partenaires. Toi, tu compares les meilleures offres. Et tu signes.')}
            </p>
            
            <div className="mt-10 flex flex-wrap items-center gap-x-6 gap-y-3 text-sm text-lumina-on-surface-variant">
              <div className="flex items-center gap-2">
                <div className="flex text-lumina-warning">
                  <Star className="h-4 w-4 fill-current" />
                  <Star className="h-4 w-4 fill-current" />
                  <Star className="h-4 w-4 fill-current" />
                  <Star className="h-4 w-4 fill-current" />
                  <Star className="h-4 w-4 fill-current" />
                </div>
                <span><strong className="text-lumina-heading">4,8/5</strong> {t('landing.stats_reviews', 'sur 1 247 avis')}</span>
              </div>
              <span className="text-lumina-outline">·</span>
              <span><strong className="text-lumina-heading">2 000+</strong> {t('landing.stats_projects', 'projets financés')}</span>
              <span className="text-lumina-outline">·</span>
              <span>{t('landing.stats_free', 'Étude gratuite & sans engagement')}</span>
            </div>
          </div>
          
          <div className="lg:col-span-6 z-10">
            <SimulatorPanel
              montant={montant}
              setMontant={setMontant}
              duree={duree}
              setDuree={setDuree}
              mensualite={mensualite}
              coutTotal={coutTotal}
              totalRembourse={totalRembourse}
              motif={motif}
              setMotif={setMotif}
              revenuEstime={revenuEstime}
              setRevenuEstime={setRevenuEstime}
              onStart={onStart}
              compact={false}
              isLoading={isLoading}
            />
          </div>
          
        </div>
      </div>
    </section>
  )
}

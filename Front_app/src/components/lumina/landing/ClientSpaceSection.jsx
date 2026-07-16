import { FileText, Check, Lock, Phone, BarChart2, Users } from 'lucide-react'
import { useTranslation } from 'react-i18next'

export function ClientSpaceSection() {
  const { t } = useTranslation()
  return (
    <section className="mx-auto max-w-6xl px-6 py-24">
      <div className="grid gap-12 lg:grid-cols-12 lg:items-center">
        
        {/* Visual Side (Mockup) */}
        <div className="order-2 lg:order-1 lg:col-span-7">
          <div className="relative">
            <div 
              aria-hidden="true" 
              className="absolute -inset-6 -z-10 rounded-[3rem] opacity-60" 
              style={{
                background: 'radial-gradient(50% 50% at 30% 30%, var(--clenar-primary) 0%, transparent 60%)'
              }}
            />
            
            <div className="surface-card overflow-hidden md:-rotate-1 transition-transform hover:rotate-0 shadow-lg">
              <div className="flex items-center gap-2 border-b border-lumina-outline bg-lumina-surface-light px-4 py-3">
                <span className="h-3 w-3 rounded-full bg-red-400" />
                <span className="h-3 w-3 rounded-full bg-yellow-400" />
                <span className="h-3 w-3 rounded-full bg-green-400" />
                <div className="ml-3 flex-1 truncate rounded-full bg-white px-3 py-1 text-xs text-lumina-on-surface-variant">
                  espace-client
                </div>
              </div>
              
              <div className="p-6 md:p-8 space-y-6">
                <div className="flex flex-col items-start justify-between gap-3 sm:flex-row sm:items-center sm:gap-4">
                  <div>
                    <p className="text-xs uppercase tracking-[0.16em] font-semibold text-lumina-on-surface-variant">Mon espace</p>
                    <p className="mt-1 font-[family-name:var(--font-headline)] text-xl sm:text-2xl font-bold text-lumina-heading">
                      Bonjour Camille 👋
                    </p>
                  </div>
                  <span className="inline-flex items-center gap-1 rounded-full bg-lumina-surface-container px-3 py-1 text-xs font-semibold text-lumina-secondary shrink-0">
                    Étape 2/4 · Documents
                  </span>
                </div>
                
                {/* Stepper */}
                <ol className="flex items-center gap-2">
                  <li className="flex flex-col items-center gap-1">
                    <span className="flex h-8 w-8 items-center justify-center rounded-full bg-lumina-primary text-white">
                      <Check className="h-4 w-4" />
                    </span>
                    <span className="text-[10px] text-lumina-on-surface-variant font-medium">Profil</span>
                  </li>
                  <span className="h-px flex-1 bg-lumina-primary -mt-3" aria-hidden="true" />
                  <li className="flex flex-col items-center gap-1">
                    <span className="flex h-8 w-8 items-center justify-center rounded-full bg-white border-2 border-lumina-primary text-lumina-primary font-bold text-xs">
                      2
                    </span>
                    <span className="text-[10px] text-lumina-heading font-bold">Documents</span>
                  </li>
                  <span className="h-px flex-1 bg-lumina-outline -mt-3" aria-hidden="true" />
                  <li className="flex flex-col items-center gap-1">
                    <span className="flex h-8 w-8 items-center justify-center rounded-full bg-lumina-surface-light border border-lumina-outline text-lumina-on-surface-variant text-xs">
                      3
                    </span>
                    <span className="text-[10px] text-lumina-on-surface-variant font-medium">Étude</span>
                  </li>
                  <span className="h-px flex-1 bg-lumina-outline -mt-3" aria-hidden="true" />
                  <li className="flex flex-col items-center gap-1">
                    <span className="flex h-8 w-8 items-center justify-center rounded-full bg-lumina-surface-light border border-lumina-outline text-lumina-on-surface-variant text-xs">
                      4
                    </span>
                    <span className="text-[10px] text-lumina-on-surface-variant font-medium">Offres</span>
                  </li>
                </ol>
                
                {/* Documents List */}
                <div className="space-y-2">
                  <p className="text-xs font-bold uppercase tracking-wider text-lumina-on-surface-variant">Documents transmis</p>
                  
                  {['piece-identite.pdf', 'avis-imposition-2024.pdf', 'bulletin-salaire-mai.pdf'].map((doc, idx) => (
                    <div key={idx} className="flex items-center justify-between gap-3 rounded-xl border border-lumina-outline bg-white px-3 py-2 shadow-sm">
                      <div className="flex items-center gap-3 min-w-0">
                        <div className="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-lumina-primary/10 text-lumina-primary">
                          <FileText className="h-4 w-4" />
                        </div>
                        <p className="truncate text-sm font-medium text-lumina-heading">{doc}</p>
                      </div>
                      <span className="shrink-0 rounded-full bg-green-100 px-2.5 py-0.5 text-[10px] font-bold text-green-700">
                        ✓ Reçu
                      </span>
                    </div>
                  ))}
                </div>
                
                {/* Advisor */}
                <div className="flex items-center gap-3 rounded-2xl border border-lumina-outline bg-lumina-surface-light p-3">
                  <div className="flex h-10 w-10 items-center justify-center rounded-full bg-lumina-primary/20 font-[family-name:var(--font-headline)] font-bold text-sm text-lumina-primary">
                    JM
                  </div>
                  <div className="min-w-0 flex-1">
                    <p className="text-sm font-bold text-lumina-heading">Conseiller · Julien M.</p>
                    <p className="text-xs text-lumina-on-surface-variant font-medium">Disponible · te rappelle aujourd'hui</p>
                  </div>
                  <span className="h-2.5 w-2.5 rounded-full bg-green-500 animate-pulse shadow-[0_0_8px_rgba(34,197,94,0.6)]" />
                </div>
                
              </div>
            </div>
          </div>
        </div>
        
        {/* Text Side */}
        <div className="order-1 lg:order-2 lg:col-span-5">
          <span className="inline-flex items-center gap-2 rounded-full border border-lumina-outline bg-lumina-surface-lowest px-3 py-1 text-xs font-medium text-lumina-on-surface shadow-sm">
            {t('landing.client_badge', 'Ton espace')}
          </span>
          <h2 className="mt-4 font-[family-name:var(--font-headline)] text-4xl leading-tight font-semibold md:text-5xl text-balance text-lumina-heading">
            {t('landing.client_title', 'Un espace pensé pour ton dossier.')}
          </h2>
          <p className="mt-4 text-lumina-on-surface-variant leading-relaxed text-lg">
            {t('landing.client_subtitle', "On constitue ton dossier proprement et on le défend auprès de nos 30+ banques partenaires. Toi, tu suis l'avancement à ton rythme.")}
          </p>
          
          <ul className="mt-8 space-y-6">
            {[
              { icon: <Lock />, title: t('landing.client_feature1_title', 'Dépôt sécurisé'), desc: t('landing.client_feature1_desc', 'Hébergement européen, chiffrement TLS, accès uniquement à ton conseiller.') },
              { icon: <Phone />, title: t('landing.client_feature2_title', 'Conseiller dédié'), desc: t('landing.client_feature2_desc', 'Ton conseiller te rappelle sous 24h et reste à tes côtés du début à la fin. Joignable par email pour toute question.') },
              { icon: <BarChart2 />, title: t('landing.client_feature3_title', 'Suivi en temps réel'), desc: t('landing.client_feature3_desc', 'Tu sais où en est ton dossier à chaque étape — Profil, Documents, Étude, Offres.') },
              { icon: <Users />, title: t('landing.client_feature4_title', 'On défend ton dossier'), desc: t('landing.client_feature4_desc', "On présente ton profil à nos 30+ banques et on négocie jusqu'à la meilleure offre.") },
            ].map((item, i) => (
              <li key={i} className="flex gap-4">
                <div className="flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-lumina-surface-container text-lumina-primary">
                  {item.icon}
                </div>
                <div>
                  <p className="font-semibold text-lumina-heading">{item.title}</p>
                  <p className="mt-1 text-sm text-lumina-on-surface-variant leading-relaxed">
                    {item.desc}
                  </p>
                </div>
              </li>
            ))}
          </ul>
        </div>
        
      </div>
    </section>
  )
}

import { RecapCard } from '@/components/credit/RecapCard'
import { Footer } from '@/components/credit/screens/LandingScreen'
import { StepDocuments } from '@/components/credit/steps/StepDocuments'
import { StepIdentite } from '@/components/credit/steps/StepIdentite'
import { StepRecap } from '@/components/credit/steps/StepRecap'
import { StepSituation } from '@/components/credit/steps/StepSituation'
import { Button } from '@/components/ui/button'
import { STEPS } from '@/lib/credit'
import { cn } from '@/lib/utils'

export function FormScreen({
  step,
  setStep,
  setScreen,
  data,
  setField,
  errors,
  montant,
  duree,
  mensualite,
  totalRembourse,
  coutTotal,
  onNext,
}) {
  const progressPct = ((step + 1) / STEPS.length) * 100

  return (
    <div className="min-h-svh bg-gray-50">
      <div className="sticky top-0 z-50 border-b border-gray-200 bg-white px-5">
        <div className="mx-auto flex max-w-[680px] items-center gap-4 py-4">
          <button
            type="button"
            className="text-xl text-gray-500 transition-colors hover:text-[#0A0F1E]"
            onClick={() => {
              if (step > 0) {
                setStep((s) => s - 1)
                window.scrollTo(0, 0)
              } else {
                setScreen('landing')
              }
            }}
            aria-label="Retour"
          >
            ←
          </button>
          <div className="flex-1">
            <div className="mb-1.5 flex justify-between text-[11px] font-medium text-gray-500">
              <span>
                Étape {step + 1} sur {STEPS.length} — {STEPS[step].label}
              </span>
              <span className="font-bold text-[#0A0F1E]">{Math.round(progressPct)}%</span>
            </div>
            <div className="h-1 overflow-hidden rounded-full bg-gray-200">
              <div
                className="h-full rounded-full bg-[#F5C842] transition-all duration-500"
                style={{ width: `${progressPct}%` }}
              />
            </div>
          </div>
        </div>
      </div>

      <div className="mx-auto max-w-[680px] px-5 py-10 pb-20">
        <RecapCard montant={montant} duree={duree} mensualite={mensualite} />

        {step === 0 && (
          <StepIdentite data={data} setField={setField} errors={errors} />
        )}
        {step === 1 && (
          <StepSituation data={data} setField={setField} errors={errors} />
        )}
        {step === 2 && (
          <StepDocuments data={data} setField={setField} errors={errors} />
        )}
        {step === 3 && (
          <StepRecap
            data={data}
            setField={setField}
            errors={errors}
            montant={montant}
            duree={duree}
            mensualite={mensualite}
            totalRembourse={totalRembourse}
            coutTotal={coutTotal}
          />
        )}

        <Button
          type="button"
          onClick={onNext}
          className={cn(
            'mt-2 h-auto w-full rounded-[14px] py-[18px] font-[family-name:var(--font-sora)] text-base font-bold',
            step === 3
              ? 'bg-[#F5C842] text-[#0A0F1E] hover:bg-[#E6B830]'
              : 'bg-[#0A0F1E] text-white hover:bg-[#1a2236]',
          )}
        >
          {step < 3 ? (
            <>
              Continuer <span>→</span>
            </>
          ) : (
            <>🚀 Soumettre ma demande</>
          )}
        </Button>

        <p className="mt-4 text-center text-[10px] leading-relaxed text-gray-400">
          🔒 Vos données sont chiffrées et sécurisées · RGPD · Aucun engagement
        </p>
      </div>

      <Footer />
    </div>
  )
}

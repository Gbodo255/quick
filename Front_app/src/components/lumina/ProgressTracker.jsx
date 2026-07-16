import { FORM_STEPS } from '@/lib/credit'

export function ProgressTracker({ step }) {
  const VISUAL_STEPS = [
    { label: 'Pré-qualification' },
    { label: 'Mes Informations' },
    { label: 'Validation' }
  ]

  let visualStepIndex = 0
  if (step >= 1 && step <= 3) visualStepIndex = 1
  if (step === 4) visualStepIndex = 2

  const currentVisual = VISUAL_STEPS[visualStepIndex]

  return (
    <div className="flex flex-col gap-3">
      <div className="flex items-end justify-between">
        <span className="text-xs font-medium tracking-widest text-lumina-on-surface-variant uppercase">
          Étape {visualStepIndex + 1} sur {VISUAL_STEPS.length}
        </span>
        <span className="text-xs font-semibold tracking-wide text-lumina-on-surface">
          {currentVisual.label}
        </span>
      </div>
      <div className="flex gap-2">
        {VISUAL_STEPS.map((s, i) => (
          <div
            key={i}
            className={`h-1.5 flex-1 rounded-full transition-colors duration-500 ${
              i <= visualStepIndex
                ? 'bg-lumina-accent'
                : 'bg-lumina-outline'
            }`}
          />
        ))}
      </div>
    </div>
  )
}

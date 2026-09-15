export function ProgressTracker({ step }) {
  const VISUAL_STEPS = [
    { label: 'Pré-qualification' },
    { label: 'Mes Informations' },
    { label: 'Validation' }
  ]

  let visualStepIndex = 0
  if (step >= 1 && step <= 3) visualStepIndex = 1
  if (step === 4) visualStepIndex = 2

  return (
    <div className="flex flex-col gap-3">
      <div className="flex gap-2">
        {VISUAL_STEPS.map((s, i) => (
          <div
            key={i}
            className={`h-1.5 flex-1 rounded-none transition-colors duration-500 ${
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

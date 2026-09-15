import { ApiErrorBanner } from '@/components/lumina/ApiErrorBanner'
import { FormActions, FormShell } from '@/components/lumina/FormShell'
import { StepDocuments } from '@/components/lumina/steps/StepDocuments'
import { StepIdentite } from '@/components/lumina/steps/StepIdentite'
import { StepPrequal } from '@/components/lumina/steps/StepPrequal'
import { StepProjet } from '@/components/lumina/steps/StepProjet'
import { StepSituation } from '@/components/lumina/steps/StepSituation'
import { FORM_STEPS, isIdentiteStepComplete } from '@/lib/credit'

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
  coutTotal,
  onNext,
  onUploadDocument,
  globalError,
  onDismissError,
  uploadedDocs,
  onPrivacy,
  isSubmitting = false,
}) {
  const handleBack = () => {
    if (step > 0) {
      setStep((s) => s - 1)
      window.scrollTo(0, 0)
    } else {
      setScreen('landing')
    }
  }

  return (
    <FormShell step={step}>
      <ApiErrorBanner error={globalError} onDismiss={onDismissError} />
      {step === 0 && <StepPrequal data={data} setField={setField} errors={errors} />}
      {step === 1 && <StepIdentite data={data} setField={setField} errors={errors} />}
      {step === 2 && <StepSituation data={data} setField={setField} errors={errors} />}
      {step === 3 && (
        <StepProjet
          data={data}
          setField={setField}
          errors={errors}
          montant={montant}
          duree={duree}
          mensualite={mensualite}
          coutTotal={coutTotal}
        />
      )}
      {step === 4 && (
        <StepDocuments
          data={data}
          setField={setField}
          errors={errors}
          onUploadDocument={onUploadDocument}
          uploadedDocs={uploadedDocs}
          onPrivacy={onPrivacy}
        />
      )}

      {(step !== 1 || isIdentiteStepComplete(data)) && (
        <FormActions
          onBack={handleBack}
          onNext={onNext}
          isLast={step === FORM_STEPS.length - 1}
          isSubmitting={isSubmitting}
        />
      )}
    </FormShell>
  )
}

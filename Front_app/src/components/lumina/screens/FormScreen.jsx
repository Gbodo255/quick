import { useTranslation } from 'react-i18next'
import { ApiErrorBanner } from '@/components/lumina/ApiErrorBanner'
import { FormActions, FormShell } from '@/components/lumina/FormShell'
import { CreditRecapBar } from '@/components/lumina/CreditRecapBar'
import { StepDocuments } from '@/components/lumina/steps/StepDocuments'
import { StepIdentite } from '@/components/lumina/steps/StepIdentite'
import { StepPrequal } from '@/components/lumina/steps/StepPrequal'
import { StepProjet } from '@/components/lumina/steps/StepProjet'
import { StepRecap } from '@/components/lumina/steps/StepRecap'
import { StepSituation } from '@/components/lumina/steps/StepSituation'
import { FORM_STEPS } from '@/lib/credit'

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
  onUploadDocument,
  globalError,
  onDismissError,
  uploadedDocs,
  onPrivacy,
  isSubmitting = false,
}) {
  const { t } = useTranslation()
  const handleBack = () => {
    if (step > 0) {
      setStep((s) => s - 1)
      window.scrollTo(0, 0)
    } else {
      setScreen('landing')
    }
  }

  return (
    <FormShell
      step={step}
      onQuit={() => setScreen('landing')}
      showRecap={step > 0}
      recap={
        <CreditRecapBar montant={montant} duree={duree} mensualite={mensualite} />
      }
    >
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
          onUploadDocument={onUploadDocument}
          uploadedDocs={uploadedDocs}
        />
      )}
      {step === 5 && (
        <StepRecap
          data={data}
          setField={setField}
          errors={errors}
          montant={montant}
          duree={duree}
          mensualite={mensualite}
          totalRembourse={totalRembourse}
          coutTotal={coutTotal}
          onPrivacy={onPrivacy}
          onUploadDocument={onUploadDocument}
          uploadedDocs={uploadedDocs}
        />
      )}

      <FormActions
        onBack={handleBack}
        onNext={onNext}
        isLast={step === FORM_STEPS.length - 1}
        nextLabel={step === 0 ? t('form.continue_analysis') : undefined}
        isSubmitting={isSubmitting}
      />
    </FormShell>
  )
}

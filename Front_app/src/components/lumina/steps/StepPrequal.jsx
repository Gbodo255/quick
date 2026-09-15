import { LuminaInput, LuminaSelect } from '@/components/lumina/LuminaField'
import { Icon } from '@/components/lumina/Icon'
import { useTranslation } from 'react-i18next'

export function StepPrequal({ data, setField, errors }) {
  const { t } = useTranslation()

  const PRO_OPTIONS = [
    ['cdi', t('prequal.pro_options.cdi')],
    ['cdd', t('prequal.pro_options.cdd')],
    ['independant', t('prequal.pro_options.independant')],
    ['retraite', t('prequal.pro_options.retraite')],
    ['autre', t('prequal.pro_options.autre')],
  ]

  const HOUSING_OPTIONS = [
    ['proprietaire', t('prequal.housing_options.proprietaire')],
    ['locataire', t('prequal.housing_options.locataire')],
    ['heberge', t('prequal.housing_options.heberge')],
  ]

  return (
    <div className="flex flex-col gap-4">
      <div className="grid gap-4">
        <LuminaSelect
          id="situationPro"
          label={t('prequal.pro_status')}
          value={data.situationPro}
          onChange={(v) => setField('situationPro', v)}
          options={PRO_OPTIONS}
          error={errors.situationPro}
          required
        />
        <LuminaSelect
          id="situationLogement"
          label={t('prequal.housing_status')}
          value={data.situationLogement}
          onChange={(v) => setField('situationLogement', v)}
          options={HOUSING_OPTIONS}
          error={errors.situationLogement}
          required
        />
        <LuminaInput
          id="revenuNet"
          label={t('prequal.income')}
          inputKind="number"
          value={data.revenuNet}
          onChange={(v) => setField('revenuNet', v)}
          placeholder="0"
          icon={<Icon name="euro" size={20} />}
          error={errors.revenuNet}
          required
        />
        <LuminaInput
          id="chargesMensuelles"
          label={t('prequal.charges')}
          inputKind="number"
          value={data.chargesMensuelles}
          onChange={(v) => setField('chargesMensuelles', v)}
          placeholder="0"
          icon={<Icon name="euro" size={20} />}
        />
      </div>
    </div>
  )
}

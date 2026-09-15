import { GlassBanner, LuminaInput, LuminaSelect } from '@/components/lumina/LuminaField'
import { Icon } from '@/components/lumina/Icon'
import { cn } from '@/lib/utils'
import { useTranslation } from 'react-i18next'

export function StepSituation({ data, setField, errors }) {
  const { t } = useTranslation()
  const showEmployeur = ['cdi', 'cdd', 'fonctionnaire'].includes(data.situationPro)

  const ANCIENNETE_OPTIONS = [
    ['moins6mois', t('situation.anciennete_options.moins6mois')],
    ['6a12mois', t('situation.anciennete_options.6a12mois')],
    ['1a3ans', t('situation.anciennete_options.1a3ans')],
    ['3a5ans', t('situation.anciennete_options.3a5ans')],
    ['plus5ans', t('situation.anciennete_options.plus5ans')],
  ]

  const HOUSING_RADIO = [
    ['proprietaire', 'home', t('situation.housing_options.proprietaire')],
    ['locataire', 'apartment', t('situation.housing_options.locataire')],
    ['heberge', 'group', t('situation.housing_options.heberge')],
  ]

  return (
    <div className="flex flex-col gap-4">
      <GlassBanner icon="lightbulb" title={t('situation.info_title')}>
        {t('situation.info_body')}
      </GlassBanner>

      <div className="grid gap-4 md:grid-cols-2">
        {showEmployeur && (
          <>
            <LuminaInput
              id="employeur"
              label={t('situation.employer')}
              inputKind="letters"
              value={data.employeur}
              onChange={(v) => setField('employeur', v)}
              placeholder={t('situation.employer_placeholder')}
              error={errors.employeur}
              required
            />
            <LuminaSelect
              id="anciennete"
              label={t('situation.seniority')}
              value={data.anciennete}
              onChange={(v) => setField('anciennete', v)}
              options={ANCIENNETE_OPTIONS}
              error={errors.anciennete}
              required
            />
          </>
        )}
        {!showEmployeur && (
          <LuminaSelect
            id="anciennete"
            label={t('situation.seniority_current')}
            value={data.anciennete}
            onChange={(v) => setField('anciennete', v)}
            options={ANCIENNETE_OPTIONS}
            error={errors.anciennete}
            required
            className="md:col-span-2"
          />
        )}
      </div>

      <div className="flex flex-col gap-3">
        <p className="text-sm font-medium tracking-wide text-lumina-on-surface">
          {t('situation.housing')}
        </p>
        <div className="grid gap-4 md:grid-cols-3">
          {HOUSING_RADIO.map(([value, icon, label]) => (
            <label key={value} className="cursor-pointer">
              <input
                type="radio"
                name="housing"
                value={value}
                checked={data.situationLogement === value}
                onChange={() => setField('situationLogement', value)}
                className="peer sr-only"
              />
              <div
                className={cn(
                  'flex h-full flex-col items-center justify-center gap-1.5 rounded-none border border-lumina-outline-variant p-3 text-center text-sm transition-all',
                  'peer-checked:border-lumina-primary peer-checked:bg-lumina-surface-container peer-checked:shadow-sm',
                )}
              >
                <Icon name={icon} className="text-lumina-on-surface-variant peer-checked:text-lumina-primary" />
                <span className="text-sm font-medium text-lumina-on-surface">{label}</span>
              </div>
            </label>
          ))}
        </div>
      </div>
    </div>
  )
}

import { GlassBanner, LuminaInput, LuminaSelect } from '@/components/lumina/LuminaField'
import { LuminaDatePicker } from '@/components/lumina/LuminaDatePicker'
import { Icon } from '@/components/lumina/Icon'
import { BRAND } from '@/lib/credit'
import { useTranslation } from 'react-i18next'

function FormCard({ icon, title, children }) {
  return (
    <div className="surface-card flex flex-col gap-4 p-4 md:p-5">
      <div className="flex items-center gap-2.5 border-b border-lumina-outline-variant/30 pb-3">
        <span className="flex size-8 items-center justify-center rounded-md bg-lumina-surface-container text-lumina-primary">
          <Icon name={icon} size={18} />
        </span>
        <h2 className="font-[family-name:var(--font-headline)] text-base font-semibold text-lumina-on-surface">
          {title}
        </h2>
      </div>
      {children}
    </div>
  )
}

export function StepIdentite({ data, setField, errors }) {
  const { t } = useTranslation()

  const CIVILITE_OPTIONS = [
    ['M.', t('identite.civility_options.M.')],
    ['Mme', t('identite.civility_options.Mme')],
  ]

  return (
    <div className="flex flex-col gap-4">
      <p className="text-sm leading-relaxed text-lumina-on-surface-variant">
        {t('identite.intro')}
      </p>

      <FormCard icon="person" title={t('identite.identity_card')}>
        <div className="grid gap-4 md:grid-cols-12">
          <div className="md:col-span-4">
            <LuminaSelect
              id="civilite"
              label={t('identite.civility')}
              value={data.civilite}
              onChange={(v) => setField('civilite', v)}
              options={CIVILITE_OPTIONS}
              placeholder={t('identite.select')}
              error={errors.civilite}
              required
            />
          </div>
          <div className="md:col-span-4">
            <LuminaInput
              id="prenom"
              label={t('identite.firstname')}
              inputKind="name"
              value={data.prenom}
              onChange={(v) => setField('prenom', v)}
              placeholder="Ex: Jean"
              error={errors.prenom}
              required
            />
          </div>
          <div className="md:col-span-4">
            <LuminaInput
              id="nom"
              label={t('identite.lastname')}
              inputKind="name"
              value={data.nom}
              onChange={(v) => setField('nom', v)}
              placeholder="Ex: Dupont"
              error={errors.nom}
              required
            />
          </div>
          <div className="md:col-span-6">
            <LuminaDatePicker
              id="dateNaissance"
              label={t('identite.birthdate')}
              value={data.dateNaissance}
              onChange={(v) => setField('dateNaissance', v)}
              error={errors.dateNaissance}
              required
            />
          </div>
          <div className="md:col-span-6">
            <LuminaInput
              id="lieuNaissance"
              label={t('identite.birthplace')}
              inputKind="name"
              value={data.lieuNaissance}
              onChange={(v) => setField('lieuNaissance', v)}
              placeholder={t('identite.birthplace_placeholder')}
            />
          </div>
        </div>
      </FormCard>

      <FormCard icon="contact_mail" title={t('identite.contact_card')}>
        <div className="grid gap-4 md:grid-cols-2">
          <LuminaInput
            id="email"
            label={t('identite.email')}
            type="email"
            value={data.email}
            onChange={(v) => setField('email', v)}
            placeholder="jean.dupont@email.com"
            icon={<Icon name="mail" size={20} />}
            error={errors.email}
            required
          />
          <div className="flex gap-2">
            <div className="w-28">
              <LuminaSelect
                id="indicatifPays"
                label={t('identite.country_code', 'Indicatif')}
                value={data.indicatifPays || '+33'}
                onChange={(v) => setField('indicatifPays', v)}
                options={[
                  ['+33', '🇫🇷 +33'],
                  ['+32', '🇧🇪 +32'],
                  ['+41', '🇨🇭 +41'],
                  ['+352', '🇱🇺 +352'],
                  ['+49', '🇩🇪 +49'],
                  ['+34', '🇪🇸 +34'],
                  ['+39', '🇮🇹 +39'],
                  ['+44', '🇬🇧 +44'],
                  ['+1', '🇺🇸 +1'],
                ]}
              />
            </div>
            <div className="flex-1">
              <LuminaInput
                id="telephone"
                label={t('identite.phone')}
                inputKind="phone"
                value={data.telephone}
                onChange={(v) => setField('telephone', v)}
                placeholder="6 12 34 56 78"
                error={errors.telephone}
                required
              />
            </div>
          </div>
        </div>
      </FormCard>

      <FormCard icon="home" title={t('identite.address_card')}>
        <div className="grid gap-4">
          <LuminaInput
            id="adresse"
            label={t('identite.address')}
            value={data.adresse}
            onChange={(v) => setField('adresse', v)}
            placeholder={t('identite.address_placeholder')}
            error={errors.adresse}
            required
          />
          <div className="grid gap-4 md:grid-cols-2">
            <LuminaInput
              id="codePostal"
              label={t('identite.zipcode')}
              inputKind="postal"
              value={data.codePostal}
              onChange={(v) => setField('codePostal', v)}
              placeholder="75008"
              error={errors.codePostal}
              required
            />
            <LuminaInput
              id="ville"
              label={t('identite.city')}
              inputKind="name"
              value={data.ville}
              onChange={(v) => setField('ville', v)}
              placeholder={t('identite.city_placeholder')}
              error={errors.ville}
              required
            />
          </div>
        </div>
      </FormCard>

      <GlassBanner icon="shield_lock" title={t('identite.gdpr_title')} variant="security">
        {t('identite.gdpr_body', { brand: BRAND })}
      </GlassBanner>
    </div>
  )
}

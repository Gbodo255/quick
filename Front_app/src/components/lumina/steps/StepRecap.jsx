import { BRAND, TAUX_ANNUEL, fmt, fmtDec } from '@/lib/credit'
import { Icon } from '@/components/lumina/Icon'
import { cn } from '@/lib/utils'
import { useTranslation } from 'react-i18next'

function SummaryCard({ icon, title, onEdit, children }) {
  const { t } = useTranslation()
  return (
    <div className="surface-card group relative overflow-hidden p-4 md:p-5">
      <div className="absolute -top-16 -right-16 size-32 rounded-bl-full bg-lumina-surface-container-low transition-transform group-hover:scale-110" />
      <div className="relative z-10 mb-4 flex items-center justify-between">
        <div className="flex items-center gap-3">
          <div className="flex size-10 items-center justify-center rounded-full bg-lumina-surface-container-low">
            <Icon name={icon} size={22} />
          </div>
          <h2 className="font-[family-name:var(--font-headline)] text-base font-semibold text-lumina-on-surface">
            {title}
          </h2>
        </div>
        {onEdit && (
          <button
            type="button"
            onClick={onEdit}
            className="flex items-center gap-1 text-xs font-medium tracking-wide text-lumina-secondary hover:text-lumina-brand"
          >
            <Icon name="edit" size={14} />
            {t('recap.edit')}
          </button>
        )}
      </div>
      <div className="relative z-10 grid gap-4 md:grid-cols-2">{children}</div>
    </div>
  )
}

function SummaryField({ label, value, highlight }) {
  return (
    <div>
      <p className="text-xs font-medium tracking-wide text-lumina-on-surface-variant uppercase">
        {label}
      </p>
      <p
        className={cn(
          'mt-1 text-base font-medium text-lumina-on-surface',
          highlight && 'font-bold text-lumina-secondary',
        )}
      >
        {value || '—'}
      </p>
    </div>
  )
}

function ConsentItem({ checked, onChange, children }) {
  return (
    <label className="flex cursor-pointer items-start gap-3">
      <div className="relative mt-1 flex items-center justify-center">
        <input
          type="checkbox"
          checked={checked}
          onChange={onChange}
          className="peer size-5 appearance-none rounded border-2 border-lumina-on-surface-variant shadow-sm focus:ring-2 focus:ring-lumina-accent focus:ring-offset-2 checked:border-lumina-accent checked:bg-lumina-accent transition-all"
        />
        <Icon
          name="check"
          size={14}
          className="pointer-events-none absolute text-white opacity-0 peer-checked:opacity-100"
        />
      </div>
      <span className="text-sm leading-relaxed text-lumina-on-surface-variant">{children}</span>
    </label>
  )
}

export function StepRecap({
  data,
  setField,
  errors,
  montant,
  duree,
  mensualite,
  totalRembourse,
  coutTotal,
  onPrivacy,
  onUploadDocument,
  uploadedDocs,
}) {
  const { t } = useTranslation()

  const handleFileUpload = async (type, file) => {
    if (!file || !onUploadDocument) return
    try {
      await onUploadDocument(type, file)
    } catch (err) {
      console.error("Upload error", err)
    }
  }

  const getMotifLabel = (motif) => {
    switch (motif) {
      case 'travaux': return t('projet.motifs.travaux');
      case 'auto': return t('projet.motifs.auto');
      case 'tresorerie': return t('projet.motifs.tresorerie');
      case 'vacances': return t('projet.motifs.vacances');
      case 'autre': return t('projet.motifs.autre');
      default: return motif;
    }
  }

  return (
    <div className="flex flex-col gap-4">
      <p className="text-sm text-lumina-on-surface-variant">
        {t('recap.intro')}
      </p>

      <SummaryCard icon="payments" title={t('recap.credit_details')}>
        <SummaryField label={t('recap.amount')} value={fmt(montant)} highlight />
        <SummaryField label={t('recap.duration')} value={t('simulator.duration_months', { n: duree })} />
        <SummaryField label={t('recap.monthly')} value={fmtDec(mensualite)} highlight />
        <SummaryField label={t('recap.rate')} value={`${TAUX_ANNUEL}%`} />
        <SummaryField label={t('recap.total_cost')} value={fmtDec(totalRembourse)} />
        <SummaryField label={t('recap.credit_cost')} value={fmtDec(coutTotal)} />
      </SummaryCard>

      <SummaryCard icon="person" title={t('recap.personal_info')}>
        <SummaryField
          label={t('recap.fullname')}
          value={`${data.civilite} ${data.prenom} ${data.nom}`}
        />
        <SummaryField
          label={t('recap.birthdate')}
          value={
            data.dateNaissance
              ? data.dateNaissance.split('-').reverse().join('/')
              : '—'
          }
        />
        <SummaryField
          label={t('recap.address')}
          value={`${data.adresse}, ${data.codePostal} ${data.ville}`}
          className="md:col-span-2"
        />
        <SummaryField label={t('recap.email')} value={data.email} />
        <SummaryField label={t('recap.phone')} value={data.telephone} />
      </SummaryCard>

      <SummaryCard icon="account_balance" title={t('recap.financial_info')}>
        <SummaryField label={t('recap.income')} value={data.revenuNet ? `${data.revenuNet} €` : '—'} />
        <SummaryField
          label={t('recap.charges')}
          value={data.chargesMensuelles ? `${data.chargesMensuelles} €` : '—'}
        />
        <SummaryField label={t('recap.motif')} value={getMotifLabel(data.motif)} />
        <SummaryField label={t('recap.employer')} value={data.employeur || '—'} />
      </SummaryCard>

      <SummaryCard icon="folder_open" title={t('recap.documents')}>
        <div className="col-span-2 flex flex-col gap-2.5">
          {[
            ['piece_identite', t('recap.id_doc', 'Pièce d\'identité'), data.pieceIdentite, uploadedDocs?.has('piece_identite')],
            ['rib', t('recap.rib_doc', 'RIB'), data.rib, uploadedDocs?.has('rib')],
          ].map(([type, label, file, isUploaded]) => {
            const hasDoc = Boolean(file || isUploaded)
            return (
              <div
                key={type}
                className="flex items-center justify-between rounded-lg border border-lumina-outline-variant bg-lumina-surface-light p-3"
              >
                <div className="flex items-center gap-3 overflow-hidden pr-2">
                  <div className={cn(
                    "flex size-8 shrink-0 items-center justify-center rounded-md",
                    hasDoc ? "bg-lumina-status-success/15 text-lumina-status-success" : "bg-lumina-surface-container text-lumina-on-surface-variant"
                  )}>
                    <Icon name={hasDoc ? "check_circle" : "description"} filled={hasDoc} size={18} />
                  </div>
                  <div className="truncate">
                    <p className="truncate text-sm font-semibold text-lumina-on-surface">{label}</p>
                    <p className="text-xs text-lumina-on-surface-variant">
                      {hasDoc
                        ? (file?.name || file?.original_filename || t('documents.verified', 'Document téléversé'))
                        : t('recap.not_provided', 'Non fourni')}
                    </p>
                  </div>
                </div>

                <label className={cn(
                  "cursor-pointer text-xs font-semibold px-3 py-1.5 rounded-md transition-colors shrink-0",
                  hasDoc ? "bg-lumina-surface-container hover:bg-lumina-outline-variant/30 text-lumina-on-surface" : "bg-lumina-secondary hover:bg-lumina-brand text-white"
                )}>
                  {hasDoc ? t('documents.replace', 'Remplacer') : t('documents.add', '+ Ajouter')}
                  <input
                    type="file"
                    accept=".pdf,.jpg,.jpeg,.png"
                    className="hidden"
                    onChange={(e) => {
                      if (e.target.files && e.target.files[0]) {
                        handleFileUpload(type, e.target.files[0])
                      }
                    }}
                  />
                </label>
              </div>
            )
          })}
        </div>
      </SummaryCard>

      <div className="rounded-lg border border-lumina-outline bg-lumina-surface-container-low p-4">
        <div className="mb-4 flex items-center gap-2">
          <Icon name="lock" filled className="text-lumina-secondary" />
          <h3 className="font-[family-name:var(--font-headline)] font-semibold text-lumina-on-surface">
            {t('recap.consent_title')}
          </h3>
        </div>
        <div className="space-y-4">
          <ConsentItem
            checked={data.consent1}
            onChange={() => setField('consent1', !data.consent1)}
          >
            {t('recap.consent1')}
          </ConsentItem>
          {errors.consent1 && <p className="text-xs text-lumina-error">⚠ {errors.consent1}</p>}
          <ConsentItem
            checked={data.consent2}
            onChange={() => setField('consent2', !data.consent2)}
          >
            {t('recap.consent2', { brand: BRAND })}
          </ConsentItem>
          <button
            type="button"
            onClick={onPrivacy}
            className="ml-8 text-left text-xs font-medium text-lumina-secondary underline underline-offset-4 hover:text-lumina-brand"
          >
            {t('recap.privacy_policy')}
          </button>
          {errors.consent2 && <p className="text-xs text-lumina-error">⚠ {errors.consent2}</p>}
          <ConsentItem
            checked={data.consent3}
            onChange={() => setField('consent3', !data.consent3)}
          >
            {t('recap.consent3')}
          </ConsentItem>
          {errors.consent3 && <p className="text-xs text-lumina-error">⚠ {errors.consent3}</p>}
        </div>
      </div>
    </div>
  )
}

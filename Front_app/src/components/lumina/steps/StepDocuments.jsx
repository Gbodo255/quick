import { useState } from 'react'
import { useTranslation } from 'react-i18next'
import { Info } from 'lucide-react'
import { GlassBanner, LuminaSelect } from '@/components/lumina/LuminaField'
import { Icon } from '@/components/lumina/Icon'
import { DotSpinner } from '@/components/lumina/DotSpinner'
import { BRAND } from '@/lib/credit'
import { cn } from '@/lib/utils'

function InfoTooltip({ text }) {
  return (
    <span className="group relative inline-flex">
      <Info className="h-4 w-4 shrink-0 cursor-help text-lumina-on-surface-variant" />
      <span
        role="tooltip"
        className="pointer-events-none absolute bottom-full left-1/2 z-20 mb-2 w-64 -translate-x-1/2 rounded-md border border-lumina-outline-variant bg-lumina-surface-lowest p-2.5 text-xs leading-relaxed font-normal normal-case text-lumina-on-surface opacity-0 shadow-[var(--shadow-lumina-card)] transition-opacity duration-150 group-hover:opacity-100 group-focus-within:opacity-100"
      >
        {text}
      </span>
    </span>
  )
}

function DocumentCard({
  type,
  title,
  subtitle,
  tooltip,
  icon,
  file,
  isUploaded,
  onUpload,
  accept = '.pdf,.jpg,.jpeg,.png',
  selectOptions,
  selectedOptionValue,
  onSelectOptionChange,
}) {
  const { t } = useTranslation()
  const [isDragOver, setIsDragOver] = useState(false)
  const [isUploading, setIsUploading] = useState(false)
  const [uploadError, setUploadError] = useState('')

  const handleFileChange = async (selectedFile) => {
    if (!selectedFile) return
    setIsUploading(true)
    setUploadError('')
    try {
      await onUpload(type, selectedFile)
    } catch (err) {
      setUploadError(err?.message || 'Erreur lors du téléversement')
    } finally {
      setIsUploading(false)
    }
  }

  const handleDrop = (e) => {
    e.preventDefault()
    setIsDragOver(false)
    if (e.dataTransfer.files && e.dataTransfer.files[0]) {
      handleFileChange(e.dataTransfer.files[0])
    }
  }

  return (
    <div className="surface-card flex flex-col gap-4 p-4 md:p-5">
      <div className="flex items-center justify-between border-b border-lumina-outline-variant/30 pb-3">
        <div className="flex items-center gap-3">
          <div className="flex size-10 items-center justify-center rounded-md bg-lumina-surface-container text-lumina-primary">
            <Icon name={icon} size={22} />
          </div>
          <div>
            <div className="flex items-center gap-1.5">
              <h2 className="font-[family-name:var(--font-headline)] text-base font-semibold text-lumina-on-surface">
                {title}
              </h2>
              {tooltip && <InfoTooltip text={tooltip} />}
            </div>
            <p className="text-xs text-lumina-on-surface-variant">{subtitle}</p>
          </div>
        </div>
        {isUploaded && (
          <span className="inline-flex items-center gap-1.5 rounded-full bg-lumina-status-success/15 px-3 py-1 text-xs font-semibold text-lumina-status-success">
            <Icon name="check_circle" filled size={16} />
            {t('documents.verified', 'Vérifié')}
          </span>
        )}
      </div>

      {selectOptions && (
        <div className="max-w-xs">
          <LuminaSelect
            id={`${type}_subtype`}
            label={t('documents.id_type_label', 'Type de document')}
            value={selectedOptionValue}
            onChange={onSelectOptionChange}
            options={selectOptions}
          />
        </div>
      )}

      {isUploading ? (
        <div className="flex flex-col items-center justify-center rounded-lg border border-dashed border-lumina-secondary bg-lumina-surface-container-low p-6 text-center">
          <DotSpinner size={32} dots={8} className="mb-2 text-lumina-secondary" />
          <p className="text-sm font-semibold text-lumina-on-surface">
            {t('documents.uploading', 'Téléversement en cours…')}
          </p>
        </div>
      ) : file || isUploaded ? (
        <div className="flex items-center justify-between rounded-lg border border-lumina-status-success/30 bg-lumina-status-success/5 p-3.5">
          <div className="flex items-center gap-3 overflow-hidden">
            <div className="flex size-9 shrink-0 items-center justify-center rounded-md bg-lumina-status-success/20 text-lumina-status-success">
              <Icon name="description" size={20} />
            </div>
            <div className="truncate">
              <p className="truncate text-sm font-semibold text-lumina-on-surface">
                {file?.name || file?.original_filename || 'Document transmis'}
              </p>
              <p className="text-xs text-lumina-status-success font-medium">
                ✓ Document en cours de validation
              </p>
            </div>
          </div>
          <label className="btn-secondary text-xs shrink-0 cursor-pointer">
            {t('documents.replace', 'Remplacer')}
            <input
              type="file"
              accept={accept}
              className="hidden"
              onChange={(e) => handleFileChange(e.target.files[0])}
            />
          </label>
        </div>
      ) : (
        <div
          onDragOver={(e) => {
            e.preventDefault()
            setIsDragOver(true)
          }}
          onDragLeave={() => setIsDragOver(false)}
          onDrop={handleDrop}
          className={cn(
            'flex flex-col items-center justify-center rounded-lg border-2 border-dashed p-6 text-center transition-all',
            isDragOver
              ? 'border-lumina-secondary bg-lumina-surface-container'
              : 'border-lumina-outline-variant bg-lumina-surface-lowest hover:border-lumina-secondary/50',
          )}
        >
          <div className="mb-2 flex size-12 items-center justify-center rounded-md bg-lumina-surface-container text-lumina-on-surface-variant">
            <Icon name="cloud_upload" size={28} />
          </div>
          <p className="text-sm font-medium text-lumina-on-surface">
            {t('documents.drag_drop', 'Glissez-déposez votre document ici ou')}{' '}
            <label className="cursor-pointer font-bold text-lumina-secondary underline hover:text-lumina-brand">
              {t('documents.browse', 'parcourez vos fichiers')}
              <input
                type="file"
                accept={accept}
                className="hidden"
                onChange={(e) => handleFileChange(e.target.files[0])}
              />
            </label>
          </p>
          <p className="mt-1 text-xs text-lumina-on-surface-variant">
            {t('documents.file_hint', 'Formats acceptés : PDF, JPG, PNG · Max. 10 Mo')}
          </p>
        </div>
      )}

      {uploadError && <p className="text-xs text-lumina-error">⚠ {uploadError}</p>}
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
          className="peer size-5 appearance-none rounded-sm border-2 border-lumina-on-surface-variant shadow-sm focus:ring-2 focus:ring-lumina-accent focus:ring-offset-2 checked:border-lumina-accent checked:bg-lumina-accent transition-all"
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

export function StepDocuments({ data, setField, errors = {}, onUploadDocument, uploadedDocs, onPrivacy }) {
  const { t } = useTranslation()

  const ID_TYPES = [
    ['cni', t('documents.id_types.cni', 'Carte d\'identité')],
    ['passeport', t('documents.id_types.passeport', 'Passeport')],
    ['titre_sejour', t('documents.id_types.titre_sejour', 'Titre de séjour')],
  ]

  return (
    <div className="flex flex-col gap-4">
      <p className="text-sm leading-relaxed text-lumina-on-surface-variant">
        {t('documents.intro', 'Pour finaliser l\'étude de votre dossier, veuillez nous transmettre vos pièces justificatives.')}
      </p>

      <DocumentCard
        type="certificat_scolarite"
        title={t('documents.school_title', 'Certificat de scolarité')}
        subtitle={t('documents.school_subtitle', 'Datant de moins de 3 mois, il justifie votre statut étudiant.')}
        icon="school"
        file={data.certificatScolarite}
        isUploaded={uploadedDocs?.has('certificat_scolarite') || data.certificatScolarite?.isUploaded}
        onUpload={onUploadDocument}
      />

      <DocumentCard
        type="piece_identite"
        title={t('documents.id_title', 'Pièce d\'identité')}
        subtitle={t('documents.id_subtitle', 'Carte nationale d\'identité, passeport ou titre de séjour en cours de validité.')}
        icon="badge"
        file={data.pieceIdentite}
        isUploaded={uploadedDocs?.has('piece_identite') || data.pieceIdentite?.isUploaded}
        onUpload={onUploadDocument}
        selectOptions={ID_TYPES}
        selectedOptionValue={data.pieceIdentiteType || 'cni'}
        onSelectOptionChange={(v) => setField('pieceIdentiteType', v)}
      />

      <DocumentCard
        type="rib"
        title={t('documents.residence_title', 'Justificatif de résidence')}
        subtitle={t('documents.residence_subtitle', 'Datant de moins de 3 mois, à votre nom.')}
        tooltip={t(
          'documents.residence_tooltip',
          "Facture EDF ou Bouygues, contrat de location, attestation de domicile, ou tout autre document prouvant votre adresse de résidence.",
        )}
        icon="home"
        file={data.rib}
        isUploaded={uploadedDocs?.has('rib') || data.rib?.isUploaded}
        onUpload={onUploadDocument}
      />

      <GlassBanner icon="shield" title={t('documents.security_title', 'Sécurité bancaire garantie')} variant="security">
        {t('documents.security_body', 'Vos documents sont chiffrés de bout en bout et conservés dans un coffre-fort numérique conforme aux normes bancaires européennes.')}
      </GlassBanner>

      <div className="rounded-lg border border-lumina-outline bg-lumina-surface-container-low p-4">
        <div className="mb-4 flex items-center gap-2">
          <Icon name="lock" filled className="text-lumina-secondary" />
          <h3 className="font-[family-name:var(--font-headline)] font-semibold text-lumina-on-surface">
            {t('documents.consent_title', 'Consentement et validation')}
          </h3>
        </div>
        <div className="space-y-4">
          <ConsentItem
            checked={data.consent1}
            onChange={() => setField('consent1', !data.consent1)}
          >
            {t('documents.consent1', "Je certifie sur l'honneur l'exactitude des informations fournies.")}
          </ConsentItem>
          {errors.consent1 && <p className="text-xs text-lumina-error">⚠ {errors.consent1}</p>}

          <ConsentItem
            checked={data.consent2}
            onChange={() => setField('consent2', !data.consent2)}
          >
            {t('documents.consent2', "J'accepte les Conditions Générales et la politique de confidentialité de {{brand}}.", { brand: BRAND })}
          </ConsentItem>
          {onPrivacy && (
            <button
              type="button"
              onClick={onPrivacy}
              className="ml-8 text-left text-xs font-medium text-lumina-secondary underline underline-offset-4 hover:text-lumina-brand"
            >
              {t('documents.privacy_policy', 'Lire la politique de confidentialité')}
            </button>
          )}
          {errors.consent2 && <p className="text-xs text-lumina-error">⚠ {errors.consent2}</p>}

          <ConsentItem
            checked={data.consent3}
            onChange={() => setField('consent3', !data.consent3)}
          >
            {t('documents.consent3', 'Je consens à l\'utilisation de mes données pour le traitement de mon dossier et l\'évaluation de ma solvabilité (RGPD).')}
          </ConsentItem>
          {errors.consent3 && <p className="text-xs text-lumina-error">⚠ {errors.consent3}</p>}
        </div>
      </div>
    </div>
  )
}

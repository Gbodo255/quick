import { useState } from 'react'
import { useTranslation } from 'react-i18next'
import { GlassBanner, LuminaSelect } from '@/components/lumina/LuminaField'
import { Icon } from '@/components/lumina/Icon'
import { cn } from '@/lib/utils'

function DocumentCard({
  type,
  title,
  subtitle,
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
          <div className="flex size-10 items-center justify-center rounded-full bg-lumina-surface-container text-lumina-primary">
            <Icon name={icon} size={22} />
          </div>
          <div>
            <h2 className="font-[family-name:var(--font-headline)] text-base font-semibold text-lumina-on-surface">
              {title}
            </h2>
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
          <div className="mb-2 size-8 animate-spin rounded-full border-3 border-lumina-secondary border-t-transparent" />
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
          <div className="mb-2 flex size-12 items-center justify-center rounded-full bg-lumina-surface-container text-lumina-on-surface-variant">
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

export function StepDocuments({ data, setField, onUploadDocument, uploadedDocs }) {
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
        title={t('documents.rib_title', 'Relevé d\'Identité Bancaire (RIB)')}
        subtitle={t('documents.rib_subtitle', 'RIB à votre nom pour effectuer le virement de vos fonds.')}
        icon="account_balance"
        file={data.rib}
        isUploaded={uploadedDocs?.has('rib') || data.rib?.isUploaded}
        onUpload={onUploadDocument}
      />

      <GlassBanner icon="shield" title={t('documents.security_title', 'Sécurité bancaire garantie')} variant="security">
        {t('documents.security_body', 'Vos documents sont chiffrés de bout en bout et conservés dans un coffre-fort numérique conforme aux normes bancaires européennes.')}
      </GlassBanner>
    </div>
  )
}

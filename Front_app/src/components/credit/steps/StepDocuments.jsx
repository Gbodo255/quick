import { RadioCards } from '@/components/credit/RadioCards'
import { UploadZone } from '@/components/credit/UploadZone'
import { StepHeader } from '@/components/credit/steps/StepIdentite'
import { Label } from '@/components/ui/label'

const ID_OPTIONS = [
  ['cni', '🪪', "Carte d'identité"],
  ['passeport', '📗', 'Passeport'],
  ['titre_sejour', '📋', 'Titre de séjour'],
]

export function StepDocuments({ data, setField, errors }) {
  return (
    <>
      <StepHeader
        tag="Étape 3 · Vos documents"
        title="Uploadez vos pièces"
        sub="Vos documents sont analysés pour sécuriser votre dossier et valider votre identité."
      />

      <div className="mb-6 flex gap-3 rounded-[14px] border border-[#F5C842]/30 bg-[#FFF8E7] px-4 py-4">
        <span className="text-xl">🔒</span>
        <p className="text-[13px] leading-relaxed text-amber-900">
          <strong>Vérification sécurisée :</strong> Vos documents sont analysés par nos
          outils de vérification d&apos;identité. Cette étape garantit la sécurité de
          votre dossier.
        </p>
      </div>

      <div className="mb-5">
        <Label className="mb-2 block text-[13px] font-semibold text-[#0A0F1E]">
          Type de pièce d&apos;identité<span className="ml-0.5 text-[#E6B830]">*</span>
        </Label>
        <RadioCards
          name="pieceIdentiteType"
          value={data.pieceIdentiteType}
          onChange={(v) => setField('pieceIdentiteType', v)}
          options={ID_OPTIONS}
          columns={3}
          error={errors.pieceIdentiteType}
        />
      </div>

      <UploadZone
        label="Pièce d'identité (recto-verso)"
        hint="Assurez-vous que la photo est nette, tous les coins visibles, sans reflet."
        accept="image/*,.pdf"
        value={data.pieceIdentite}
        onChange={(f) => setField('pieceIdentite', f)}
        required
        error={errors.pieceIdentite}
      />

      <UploadZone
        label="RIB (Relevé d'identité bancaire)"
        hint="Votre RIB doit correspondre à un compte ouvert en France. IBAN visible obligatoire."
        accept="image/*,.pdf"
        value={data.rib}
        onChange={(f) => setField('rib', f)}
        required
        error={errors.rib}
      />

      <div className="rounded-xl border border-sky-200 bg-sky-50 px-4 py-3.5">
        <p className="text-xs leading-relaxed text-sky-900">
          <strong>🛡️ Anti-fraude :</strong> Nos outils analysent l&apos;authenticité de
          vos documents.
        </p>
      </div>
    </>
  )
}

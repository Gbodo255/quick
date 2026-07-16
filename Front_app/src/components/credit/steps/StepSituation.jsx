import { Field } from '@/components/credit/Field'
import { RadioCards } from '@/components/credit/RadioCards'
import { StepHeader } from '@/components/credit/steps/StepIdentite'
import { Label } from '@/components/ui/label'
import { calcMensualite } from '@/lib/credit'

const selectClass =
  'h-auto w-full cursor-pointer appearance-none rounded-xl border-[1.5px] border-gray-200 bg-white px-4 py-3.5 text-[15px] text-[#0A0F1E] outline-none focus:border-[#0A0F1E]'

const PRO_OPTIONS = [
  ['salarie_cdi', '💼', 'Salarié CDI'],
  ['salarie_cdd', '📄', 'Salarié CDD'],
  ['independant', '🏢', 'Indépendant'],
  ['fonctionnaire', '🏛️', 'Fonctionnaire'],
  ['retraite', '👴', 'Retraité'],
  ['autre', '📋', 'Autre'],
]

const MOTIF_OPTIONS = [
  ['travaux', '🔨', 'Travaux'],
  ['auto', '🚗', 'Automobile'],
  ['vacances', '✈️', 'Vacances'],
  ['sante', '🏥', 'Santé'],
  ['tresorerie', '💳', 'Trésorerie'],
  ['autre', '📦', 'Autre'],
]

export function StepSituation({ data, setField, errors }) {
  const showEmployeur =
    data.situationPro === 'salarie_cdi' ||
    data.situationPro === 'salarie_cdd' ||
    data.situationPro === 'fonctionnaire'

  const endettement =
    data.revenuNet && data.chargesMensuelles
      ? Math.round(
          ((+data.chargesMensuelles + calcMensualite(5000, 36)) / +data.revenuNet) *
            100,
        )
      : null

  return (
    <>
      <StepHeader
        tag="Étape 2 · Situation financière"
        title="Votre situation professionnelle"
        sub="Ces informations sont confidentielles et nous permettent d'évaluer votre dossier."
      />

      <div className="mb-5">
        <Label className="mb-2 block text-[13px] font-semibold text-[#0A0F1E]">
          Statut professionnel<span className="ml-0.5 text-[#E6B830]">*</span>
        </Label>
        <RadioCards
          name="situationPro"
          value={data.situationPro}
          onChange={(v) => setField('situationPro', v)}
          options={PRO_OPTIONS}
          error={errors.situationPro}
        />
      </div>

      {showEmployeur && (
        <div className="grid gap-4 sm:grid-cols-2">
          <Field
            label="Nom de l'employeur"
            name="employeur"
            placeholder="Entreprise SAS"
            value={data.employeur}
            onChange={setField}
          />
          <div className="mb-5">
            <Label className="mb-2 block text-[13px] font-semibold text-[#0A0F1E]">
              Ancienneté
            </Label>
            <select
              className={selectClass}
              value={data.anciennete}
              onChange={(e) => setField('anciennete', e.target.value)}
            >
              <option value="">Sélectionnez…</option>
              <option value="moins6mois">Moins de 6 mois</option>
              <option value="6a12mois">6 à 12 mois</option>
              <option value="1a3ans">1 à 3 ans</option>
              <option value="3a10ans">3 à 10 ans</option>
              <option value="plus10ans">Plus de 10 ans</option>
            </select>
          </div>
        </div>
      )}

      <div className="grid gap-4 sm:grid-cols-2">
        <Field
          label="Revenu net mensuel (€)"
          name="revenuNet"
          type="number"
          placeholder="2500"
          value={data.revenuNet}
          onChange={setField}
          error={errors.revenuNet}
          required
        />
        <Field
          label="Charges mensuelles (€)"
          name="chargesMensuelles"
          type="number"
          placeholder="600"
          value={data.chargesMensuelles}
          onChange={setField}
        />
      </div>

      {endettement !== null && (
        <div className="mb-5 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3.5">
          <p className="text-xs font-semibold text-emerald-800">
            ✅ Taux d&apos;endettement estimé : {endettement}%
            {endettement < 35
              ? ' — Profil favorable 🎉'
              : ' — Nous étudierons votre dossier'}
          </p>
        </div>
      )}

      <div className="mb-5">
        <Label className="mb-2 block text-[13px] font-semibold text-[#0A0F1E]">
          Motif du crédit<span className="ml-0.5 text-[#E6B830]">*</span>
        </Label>
        <RadioCards
          name="motif"
          value={data.motif}
          onChange={(v) => setField('motif', v)}
          options={MOTIF_OPTIONS}
          error={errors.motif}
        />
      </div>
    </>
  )
}

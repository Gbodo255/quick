import { StepHeader } from '@/components/credit/steps/StepIdentite'
import { Checkbox } from '@/components/ui/checkbox'
import { BRAND, TAUX_ANNUEL, fmt, fmtDec } from '@/lib/credit'
import { cn } from '@/lib/utils'

const MOTIF_LABELS = {
  travaux: 'Travaux',
  auto: 'Automobile',
  vacances: 'Vacances',
  sante: 'Santé',
  tresorerie: 'Trésorerie',
  autre: 'Autre',
}

const PRO_LABELS = {
  salarie_cdi: 'Salarié CDI',
  salarie_cdd: 'Salarié CDD',
  independant: 'Indépendant',
  fonctionnaire: 'Fonctionnaire',
  retraite: 'Retraité',
  autre: 'Autre',
}

function SummarySection({ title, rows }) {
  return (
    <div className="mb-7">
      <p className="mb-3 border-b border-gray-200 pb-2 text-[11px] font-bold tracking-widest text-gray-400 uppercase">
        {title}
      </p>
      {rows.map(([key, val, cls]) => (
        <div
          key={key}
          className="flex items-center justify-between border-b border-gray-100 py-2.5 last:border-0"
        >
          <span className="text-[13px] text-gray-500">{key}</span>
          <span
            className={cn(
              'text-sm font-semibold text-[#0A0F1E]',
              cls === 'gold' && 'text-[#E6B830]',
              cls === 'green' && 'text-emerald-600',
            )}
          >
            {val}
          </span>
        </div>
      ))}
    </div>
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
}) {
  return (
    <>
      <StepHeader
        tag="Étape 4 · Récapitulatif"
        title="Vérifiez votre dossier"
        sub="Relisez vos informations avant la soumission finale."
      />

      <div className="mb-6 rounded-[20px] bg-white p-6 shadow-[0_4px_20px_rgba(0,0,0,0.06)]">
        <SummarySection
          title="💰 Votre crédit"
          rows={[
            ['Montant demandé', fmt(montant), 'gold'],
            ['Durée', `${duree} mois`],
            ['Mensualité', fmtDec(mensualite), 'gold'],
            ['Coût total', fmtDec(totalRembourse)],
            ['Coût du crédit', fmtDec(coutTotal)],
            ['TAEG fixe', `${TAUX_ANNUEL}%`],
          ]}
        />
        <SummarySection
          title="👤 Identité"
          rows={[
            ['Nom complet', `${data.civilite} ${data.prenom} ${data.nom}`],
            ['Date de naissance', data.dateNaissance || '—'],
            ['Email', data.email],
            ['Téléphone', data.telephone],
            ['Adresse', `${data.adresse}, ${data.codePostal} ${data.ville}`],
          ]}
        />
        <SummarySection
          title="💼 Situation"
          rows={[
            ['Statut professionnel', PRO_LABELS[data.situationPro] || '—'],
            [
              'Revenu net mensuel',
              data.revenuNet ? `${data.revenuNet} €` : '—',
            ],
            [
              'Charges mensuelles',
              data.chargesMensuelles ? `${data.chargesMensuelles} €` : '—',
            ],
            ['Motif', MOTIF_LABELS[data.motif] || '—'],
          ]}
        />
        <SummarySection
          title="📎 Documents"
          rows={[
            [
              "Pièce d'identité",
              data.pieceIdentite
                ? `✅ ${data.pieceIdentite.name}`
                : '❌ Manquant',
              data.pieceIdentite ? 'green' : '',
            ],
            [
              'RIB',
              data.rib ? `✅ ${data.rib.name}` : '❌ Manquant',
              data.rib ? 'green' : '',
            ],
          ]}
        />
      </div>

      <ConsentBox
        checked={data.consent1}
        onChange={() => setField('consent1', !data.consent1)}
        text={`J'accepte que mes informations personnelles et mes documents soient traités par ${BRAND} SAS dans le cadre de ma demande de crédit, conformément à la politique de confidentialité RGPD.`}
        error={errors.consent1}
      />
      <ConsentBox
        checked={data.consent2}
        onChange={() => setField('consent2', !data.consent2)}
        text="Je certifie sur l'honneur l'exactitude des informations fournies. Je comprends que toute fausse déclaration expose à des poursuites."
        error={errors.consent2}
      />

      <div className="rounded-[14px] border border-emerald-200 bg-emerald-50 px-4 py-4">
        <p className="text-[13px] leading-relaxed text-emerald-800">
          <strong>⚡ Réponse en 60 minutes</strong> — Une fois votre dossier soumis,
          notre équipe l&apos;analyse immédiatement.
        </p>
      </div>
    </>
  )
}

function ConsentBox({ checked, onChange, text, error }) {
  return (
    <div>
      <label className="mb-5 flex cursor-pointer gap-3 rounded-[14px] bg-gray-50 p-4">
        <Checkbox
          checked={checked}
          onCheckedChange={() => onChange()}
          className="mt-0.5"
        />
        <span className="text-xs leading-relaxed text-gray-500">{text}</span>
      </label>
      {error && <p className="-mt-3 mb-3 text-xs text-red-500">⚠ {error}</p>}
    </div>
  )
}

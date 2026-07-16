import { Field } from '@/components/credit/Field'
import { RadioCards } from '@/components/credit/RadioCards'
import { Label } from '@/components/ui/label'

const selectClass =
  'h-auto w-full cursor-pointer appearance-none rounded-xl border-[1.5px] border-gray-200 bg-white px-4 py-3.5 text-[15px] text-[#0A0F1E] outline-none focus:border-[#0A0F1E]'

export function StepIdentite({ data, setField, errors }) {
  return (
    <>
      <StepHeader
        tag="Étape 1 · Informations personnelles"
        title="Qui êtes-vous ?"
        sub="Ces informations nous permettent d'identifier votre dossier de façon sécurisée."
      />

      <div className="mb-5">
        <Label className="mb-2 block text-[13px] font-semibold text-[#0A0F1E]">
          Civilité<span className="ml-0.5 text-[#E6B830]">*</span>
        </Label>
        <RadioCards
          name="civilite"
          value={data.civilite}
          onChange={(v) => setField('civilite', v)}
          columns={2}
          options={[
            ['M.', '👨', 'Monsieur'],
            ['Mme', '👩', 'Madame'],
          ]}
          error={errors.civilite}
        />
      </div>

      <div className="grid gap-4 sm:grid-cols-2">
        <Field
          label="Prénom"
          name="prenom"
          placeholder="Jean"
          value={data.prenom}
          onChange={setField}
          error={errors.prenom}
          required
        />
        <Field
          label="Nom"
          name="nom"
          placeholder="Dupont"
          value={data.nom}
          onChange={setField}
          error={errors.nom}
          required
        />
      </div>

      <div className="grid gap-4 sm:grid-cols-2">
        <Field
          label="Date de naissance"
          name="dateNaissance"
          type="date"
          value={data.dateNaissance}
          onChange={setField}
          error={errors.dateNaissance}
          required
        />
        <Field
          label="Lieu de naissance"
          name="lieuNaissance"
          placeholder="Paris"
          value={data.lieuNaissance}
          onChange={setField}
        />
      </div>

      <Field
        label="Email"
        name="email"
        type="email"
        placeholder="jean.dupont@email.com"
        value={data.email}
        onChange={setField}
        error={errors.email}
        required
      />
      <Field
        label="Téléphone mobile"
        name="telephone"
        type="tel"
        placeholder="06 12 34 56 78"
        value={data.telephone}
        onChange={setField}
        error={errors.telephone}
        required
      />

      <hr className="my-7 border-gray-200" />

      <h3 className="mb-5 font-[family-name:var(--font-sora)] text-base font-bold text-[#0A0F1E]">
        Adresse de résidence
      </h3>

      <Field
        label="Adresse"
        name="adresse"
        placeholder="12 rue de la Paix"
        value={data.adresse}
        onChange={setField}
        error={errors.adresse}
        required
      />
      <div className="grid gap-4 sm:grid-cols-2">
        <Field
          label="Code postal"
          name="codePostal"
          placeholder="75001"
          value={data.codePostal}
          onChange={setField}
          error={errors.codePostal}
          required
        />
        <Field
          label="Ville"
          name="ville"
          placeholder="Paris"
          value={data.ville}
          onChange={setField}
          error={errors.ville}
          required
        />
      </div>

      <div className="mb-5">
        <Label className="mb-2 block text-[13px] font-semibold text-[#0A0F1E]">
          Situation de logement
        </Label>
        <select
          className={selectClass}
          value={data.situationLogement}
          onChange={(e) => setField('situationLogement', e.target.value)}
        >
          <option value="">Sélectionnez…</option>
          <option value="proprietaire">Propriétaire</option>
          <option value="locataire">Locataire</option>
          <option value="heberge">Hébergé chez un tiers</option>
          <option value="logement_social">Logement social</option>
        </select>
      </div>
    </>
  )
}

export function StepHeader({ tag, title, sub }) {
  return (
    <div className="mb-8">
      <p className="mb-2 text-xs font-semibold tracking-widest text-[#E6B830] uppercase">
        {tag}
      </p>
      <h2 className="font-[family-name:var(--font-sora)] text-2xl font-extrabold tracking-tight text-[#0A0F1E] sm:text-[28px]">
        {title}
      </h2>
      {sub && <p className="mt-2 text-sm leading-relaxed text-gray-500">{sub}</p>}
    </div>
  )
}

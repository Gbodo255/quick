import { BRAND } from '@/lib/credit'

const POLICY_SECTIONS = [
  {
    title: 'Responsable du traitement',
    body: [
      `${BRAND} est responsable des traitements réalisés sur la plateforme de demande de crédit.`,
      'Pour exercer vos droits ou poser une question sur vos données, vous pouvez écrire à privacy@studcredit.local.',
    ],
  },
  {
    title: 'Données collectées',
    body: [
      'Nous collectons les informations nécessaires à la simulation, à la création et à l’étude de votre dossier : identité, coordonnées, situation professionnelle, logement, revenus, charges, montant demandé, durée souhaitée et motif du crédit.',
      "Les seuls documents demandés sont votre pièce d'identité et votre RIB. Aucune fiche de paie n’est demandée dans ce parcours.",
      'Nous conservons aussi les preuves de consentement, les informations techniques strictement nécessaires à la sécurité, ainsi que les codes OTP envoyés pour vérifier votre adresse e-mail.',
    ],
  },
  {
    title: 'Finalités et bases légales',
    body: [
      'Vos données servent à simuler une mensualité, créer votre dossier, vérifier votre identité, analyser votre demande, échanger avec vous et prévenir la fraude.',
      'Ces traitements reposent principalement sur l’exécution de mesures précontractuelles demandées par vous, sur nos obligations légales et sur notre intérêt légitime à sécuriser la plateforme.',
    ],
  },
  {
    title: 'Destinataires',
    body: [
      'Les données sont accessibles uniquement aux personnes habilitées de StudCredit et à nos prestataires techniques nécessaires au fonctionnement du service : hébergement, stockage, envoi d’e-mails, sécurité et maintenance.',
      'Nous ne vendons pas vos données. Elles ne sont transmises à des partenaires financiers que lorsque cela est nécessaire à l’étude de votre demande ou lorsque la loi l’exige.',
    ],
  },
  {
    title: 'Durées de conservation',
    body: [
      'Un dossier commencé mais non soumis peut être supprimé après 30 jours d’inactivité.',
      'Un dossier soumis est conservé pendant la durée nécessaire à son instruction, puis archivé pour une durée maximale de 5 ans afin de gérer la preuve, les réclamations et les obligations applicables.',
      'Les codes OTP et journaux techniques sont conservés pour des durées courtes, proportionnées à la sécurité du service.',
    ],
  },
  {
    title: 'Sécurité',
    body: [
      'Les échanges avec la plateforme sont protégés par chiffrement. Les documents transmis sont stockés dans des espaces à accès restreint.',
      'Nous limitons les accès aux seules personnes ayant besoin de traiter votre dossier et journalisons les opérations nécessaires à la sécurité.',
    ],
  },
  {
    title: 'Vos droits',
    body: [
      'Vous pouvez demander l’accès à vos données, leur rectification, leur effacement, la limitation du traitement, la portabilité de certaines données et, selon les cas, vous opposer au traitement.',
      'Vous pouvez également retirer un consentement donné, sans remettre en cause les traitements déjà réalisés avant ce retrait.',
      'Si vous estimez que vos droits ne sont pas respectés, vous pouvez adresser une réclamation à la CNIL.',
    ],
  },
  {
    title: 'Cookies et traceurs',
    body: [
      'La plateforme utilise uniquement les éléments techniques nécessaires au fonctionnement du parcours, à la conservation temporaire de votre session et à la sécurité.',
      'Aucun cookie publicitaire n’est déposé dans ce parcours.',
    ],
  },
  {
    title: 'Mise à jour',
    body: [
      'Cette politique peut évoluer pour refléter les changements du service, des traitements ou de la réglementation applicable.',
      'Dernière mise à jour : 26 mai 2026.',
    ],
  },
]

export function PrivacyPolicyScreen({ footer }) {
  return (
    <div className="min-h-svh bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface">
      <main className="mx-auto w-full max-w-4xl px-6 pt-24 pb-20 md:pt-32">
        <div className="mb-8 border-b border-lumina-outline pb-6">
          <p className="mb-2 text-xs font-medium tracking-widest text-lumina-secondary uppercase">
            Données personnelles
          </p>
          <h1 className="font-[family-name:var(--font-headline)] text-3xl font-semibold tracking-tight text-lumina-heading md:text-4xl">
            Politique de confidentialité
          </h1>
          <p className="mt-4 max-w-2xl text-sm leading-relaxed text-lumina-on-surface-variant md:text-base">
            Cette page explique comment {BRAND} collecte, utilise, protège et conserve
            les données personnelles transmises dans le cadre d’une simulation ou d’une
            demande de crédit.
          </p>
        </div>

        <div className="divide-y divide-lumina-outline">
          {POLICY_SECTIONS.map((section) => (
            <section key={section.title} className="py-6">
              <h2 className="font-[family-name:var(--font-headline)] text-lg font-semibold text-lumina-heading">
                {section.title}
              </h2>
              <div className="mt-3 space-y-3">
                {section.body.map((paragraph) => (
                  <p key={paragraph} className="text-sm leading-relaxed text-lumina-on-surface-variant">
                    {paragraph}
                  </p>
                ))}
              </div>
            </section>
          ))}
        </div>
      </main>
      {footer}
    </div>
  )
}

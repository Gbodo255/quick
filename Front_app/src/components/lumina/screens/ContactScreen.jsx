import { useState } from 'react';
import { SEO } from '@/components/SEO';

const CONTACT_EMAIL = 'contacts@studcredit.com';

const rawApiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000';
const normalizedApiUrl = rawApiUrl.replace(/\/+$|\/api\/?$/, '');
const API_BASE = normalizedApiUrl.endsWith('/api/v1')
  ? normalizedApiUrl
  : `${normalizedApiUrl}/api/v1`;

export function ContactScreen({ footer }) {
  const [form, setForm] = useState({ nom: '', email: '', message: '' });
  const [sent, setSent] = useState(false);
  const [error, setError] = useState('');
  const [isSubmitting, setIsSubmitting] = useState(false);

  const setField = (key) => (e) => setForm((f) => ({ ...f, [key]: e.target.value }));

  const handleSubmit = async (e) => {
    e.preventDefault();
    setError('');
    setIsSubmitting(true);
    try {
      const response = await fetch(`${API_BASE}/contact`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', Accept: 'application/json' },
        body: JSON.stringify(form),
      });
      if (!response.ok) {
        const body = await response.json().catch(() => ({}));
        throw new Error(body.message || 'Une erreur est survenue.');
      }
      setSent(true);
    } catch {
      setError("Une erreur est survenue lors de l'envoi. Réessayez ou contactez-nous directement par e-mail.");
    } finally {
      setIsSubmitting(false);
    }
  };

  return (
    <div className="bg-lumina-background font-[family-name:var(--font-body)] text-lumina-on-surface antialiased min-h-screen flex flex-col">
      <SEO title="Contact | StudCredit" description="Une question sur votre prêt étudiant ? Contactez notre équipe par téléphone ou par email." />

      <main className="flex-1 mx-auto w-full max-w-4xl px-6 pt-8 pb-20 md:pt-10">
        <h1 className="font-[family-name:var(--font-headline)] text-4xl font-semibold tracking-tight text-lumina-heading md:text-5xl mb-4">
          Nous Contacter
        </h1>
        <p className="max-w-2xl text-lg leading-relaxed text-lumina-on-surface-variant mb-4">
          Besoin d'aide avec votre dossier de financement ? Notre équipe est là pour vous répondre.
        </p>

        <div className="grid gap-0 md:grid-cols-2">
          <div className="border-b border-lumina-outline pt-4 pb-8 md:border-r md:border-b-0 md:pr-10">
            <h2 className="text-lg font-semibold text-lumina-heading mb-2">Horaires &amp; Accompagnement</h2>
            <p className="text-sm text-lumina-on-surface-variant leading-relaxed mb-4">
              Accompagnement personnalisé pour le financement de vos études : frais de scolarité, logement étudiant, matériel &amp; fournitures, permis de conduire ou autre projet étudiant.
            </p>
            <p className="text-xs text-lumina-on-surface-variant mb-8">🕒 Lun – Ven : 9h00 – 18h00</p>

            <div className="mb-4">
              <h2 className="text-lg font-bold text-lumina-heading">Julien Verran</h2>
              <p className="text-xs font-semibold text-lumina-secondary">Conseiller financement étudiant</p>
            </div>
            <div className="space-y-2 text-sm text-lumina-on-surface">
              <p className="flex items-center gap-2">
                <span className="font-bold">Téléphone :</span>
                <a href="tel:+33780961216" className="font-bold text-lumina-heading hover:text-lumina-secondary hover:underline">
                  +33 7 80 96 12 16
                </a>
              </p>
              <p className="flex items-center gap-2">
                <span className="font-bold">E-mail :</span>
                <a href={`mailto:${CONTACT_EMAIL}`} className="text-lumina-secondary hover:underline">
                  {CONTACT_EMAIL}
                </a>
              </p>
            </div>
          </div>

          <div className="border-b border-lumina-outline pt-4 pb-8 md:border-b-0 md:pl-10">
            {sent ? (
              <p className="text-sm font-medium text-lumina-secondary">
                Votre message a bien été envoyé. Notre équipe vous répondra rapidement. Merci !
              </p>
            ) : (
              <form onSubmit={handleSubmit} className="flex flex-col gap-4">
                {error && (
                  <p className="rounded-md border border-lumina-error/30 bg-lumina-error/5 px-3 py-2 text-sm text-lumina-error">
                    {error}
                  </p>
                )}
                <div className="flex flex-col gap-1.5">
                  <label htmlFor="contact-nom" className="text-xs font-semibold tracking-wide text-lumina-on-surface-variant uppercase">
                    Nom
                  </label>
                  <input
                    id="contact-nom"
                    type="text"
                    required
                    value={form.nom}
                    onChange={setField('nom')}
                    className="h-10 rounded-md border border-lumina-outline bg-white px-3 text-sm text-lumina-on-surface outline-none transition-colors focus:border-lumina-secondary"
                    placeholder="Votre nom"
                  />
                </div>
                <div className="flex flex-col gap-1.5">
                  <label htmlFor="contact-email" className="text-xs font-semibold tracking-wide text-lumina-on-surface-variant uppercase">
                    E-mail
                  </label>
                  <input
                    id="contact-email"
                    type="email"
                    required
                    value={form.email}
                    onChange={setField('email')}
                    className="h-10 rounded-md border border-lumina-outline bg-white px-3 text-sm text-lumina-on-surface outline-none transition-colors focus:border-lumina-secondary"
                    placeholder="vous@exemple.com"
                  />
                </div>
                <div className="flex flex-col gap-1.5">
                  <label htmlFor="contact-message" className="text-xs font-semibold tracking-wide text-lumina-on-surface-variant uppercase">
                    Message
                  </label>
                  <textarea
                    id="contact-message"
                    required
                    rows={5}
                    value={form.message}
                    onChange={setField('message')}
                    className="resize-none rounded-md border border-lumina-outline bg-white px-3 py-2 text-sm text-lumina-on-surface outline-none transition-colors focus:border-lumina-secondary"
                    placeholder="Votre message"
                  />
                </div>
                <button
                  type="submit"
                  disabled={isSubmitting}
                  className="mt-2 inline-flex h-11 items-center justify-center rounded-md bg-lumina-primary px-6 text-sm font-semibold text-white transition-colors hover:bg-lumina-brand disabled:cursor-not-allowed disabled:opacity-60"
                >
                  {isSubmitting ? 'Envoi…' : 'Envoyer'}
                </button>
              </form>
            )}
          </div>
        </div>
      </main>
      {footer}
    </div>
  );
}

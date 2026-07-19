import React, { Suspense, lazy, useCallback, useEffect, useState } from 'react'

class ErrorBoundary extends React.Component {
  constructor(props) {
    super(props);
    this.state = { hasError: false, error: null, errorInfo: null };
  }
  static getDerivedStateFromError(error) {
    return { hasError: true, error };
  }
  componentDidCatch(error, errorInfo) {
    console.error("ErrorBoundary caught an error", error, errorInfo);
    this.setState({ errorInfo });
  }
  render() {
    if (this.state.hasError) {
      return (
        <div style={{ padding: '20px', background: '#fdd', color: '#900', fontFamily: 'monospace' }}>
          <h2>Something went wrong.</h2>
          <details style={{ whiteSpace: 'pre-wrap' }}>
            <summary>Click for error details</summary>
            {this.state.error && this.state.error.toString()}
            <br />
            {this.state.errorInfo && this.state.errorInfo.componentStack}
          </details>
        </div>
      );
    }
    return this.props.children;
  }
}

const ApiErrorBanner = lazy(() => import('@/components/lumina/ApiErrorBanner').then(m => ({ default: m.ApiErrorBanner })))
const LandingScreen = lazy(() => import('@/components/lumina/screens/LandingScreen'))
const FormScreen = lazy(() => import('@/components/lumina/screens/FormScreen').then(m => ({ default: m.FormScreen })))
const OtpScreen = lazy(() => import('@/components/lumina/screens/OtpScreen').then(m => ({ default: m.OtpScreen })))
const LoadingScreen = lazy(() => import('@/components/lumina/screens/LoadingScreen').then(m => ({ default: m.LoadingScreen })))
const SuccessScreen = lazy(() => import('@/components/lumina/screens/SuccessScreen').then(m => ({ default: m.SuccessScreen })))
const PrivacyPolicyScreen = lazy(() => import('@/components/lumina/screens/PrivacyPolicyScreen').then(m => ({ default: m.PrivacyPolicyScreen })))

// New SEO Screens
const AboutScreen = lazy(() => import('@/components/lumina/screens/AboutScreen').then(m => ({ default: m.AboutScreen })))
const LegalScreen = lazy(() => import('@/components/lumina/screens/LegalScreen').then(m => ({ default: m.LegalScreen })))
const FaqScreen = lazy(() => import('@/components/lumina/screens/FaqScreen').then(m => ({ default: m.FaqScreen })))
const ContactScreen = lazy(() => import('@/components/lumina/screens/ContactScreen').then(m => ({ default: m.ContactScreen })))
const BlogScreen = lazy(() => import('@/components/lumina/screens/BlogScreen').then(m => ({ default: m.BlogScreen })))
const ArticleScreen = lazy(() => import('@/components/lumina/screens/ArticleScreen').then(m => ({ default: m.ArticleScreen })))

import {
  ApiError,
  checkApiHealth,
  createDossier,
  fetchDossier,
  formDataToStepPayload,
  getStepId,
  mapApiErrorsToForm,
  tickProcessing,
  updateDossierStep,
  uploadDocument,
  verifyOtpAndSubmit,
} from '@/lib/api'
import {
  FORM_STEPS,
  INITIAL_FORM_DATA,
  calcMensualite,
  validateStep,
} from '@/lib/credit'
import {
  dossierToFormData,
  simulationFromDossier,
  uploadedDocumentTypes,
} from '@/lib/dossierMapper'
import {
  clearDossierSession,
  loadDossierSession,
  saveDossierSession,
} from '@/lib/dossierSession'
import { useTranslation } from 'react-i18next'
import { SEO } from '@/components/SEO'

export default function App() {
  const { t } = useTranslation()
  const [screen, setScreen] = useState(() => {
    const hash = window.location.hash
    if (hash === '#confidentialite') return 'privacy'
    if (hash === '#a-propos') return 'about'
    if (hash === '#mentions-legales') return 'legal'
    if (hash === '#faq') return 'faq'
    if (hash === '#contact') return 'contact'
    if (hash === '#conseils') return 'blog'
    if (hash.startsWith('#article-')) return 'article'
    return 'landing'
  })
  
  const [activeArticleId, setActiveArticleId] = useState(() => {
    const hash = window.location.hash
    if (hash.startsWith('#article-')) {
      return hash.replace('#article-', '')
    }
    return null
  })
  
  const [startsOnStaticPage] = useState(() => {
    const hash = window.location.hash
    return ['#confidentialite', '#a-propos', '#mentions-legales', '#faq', '#contact', '#conseils'].includes(hash) || hash.startsWith('#article-')
  })
  
  const [returnScreen, setReturnScreen] = useState('landing')
  const [step, setStep] = useState(0)
  const [loadStep, setLoadStep] = useState(0)
  const [initialSession] = useState(() => loadDossierSession())
  const [dossierId, setDossierId] = useState(initialSession?.reference ?? '')
  const [dossierToken, setDossierToken] = useState(initialSession?.token ?? '')
  const [submittedDossier, setSubmittedDossier] = useState(null)
  const [uploadedDocs, setUploadedDocs] = useState(() => new Set())

  const [montant, setMontant] = useState(25000)
  const [duree, setDuree] = useState(48)
  const [revenuEstime, setRevenuEstime] = useState('')

  const [data, setData] = useState(INITIAL_FORM_DATA)
  const [errors, setErrors] = useState({})
  const [globalError, setGlobalError] = useState('')
  const [isSubmitting, setIsSubmitting] = useState(false)

  const mensualite = calcMensualite(montant, duree)
  const totalRembourse = mensualite * duree
  const coutTotal = totalRembourse - montant

  const setField = useCallback((key, value) => {
    setData((d) => ({ ...d, [key]: value }))
    setErrors((e) => (e[key] ? { ...e, [key]: null } : e))
    setGlobalError('')
  }, [])

  const handleApiError = useCallback((err) => {
    if (err instanceof ApiError) {
      if (err.errors) {
        setErrors(mapApiErrorsToForm(err.errors))
      }
      setGlobalError(err.message)
      return
    }
    setGlobalError(t('app.error_network'))
  }, [t])

  useEffect(() => {
    checkApiHealth()
      .then(() => {/* backend ready */})
      .catch(() => {/* backend unavailable */})
  }, [])

  useEffect(() => {
    if (startsOnStaticPage) return
    if (!initialSession) return

    fetchDossier(initialSession.reference)
      .then((dossier) => {
        setData(dossierToFormData(dossier))
        const sim = simulationFromDossier(dossier)
        setMontant(sim.montant)
        setDuree(sim.duree)
        setUploadedDocs(uploadedDocumentTypes(dossier))

        if (['a_qualifier', 'dossier_conforme', 'mandat_envoye', 'offre_emise', 'fonds_decaisses', 'cloture_succes'].includes(dossier.status)) {
          setSubmittedDossier({ reference: dossier.reference })
          setScreen(dossier.status === 'cloture_succes' ? 'success' : 'success')
        } else {
          const completed = dossier.completed_steps?.length ?? 0
          setStep(Math.min(completed, FORM_STEPS.length - 1))
          setScreen('form')
        }
      })
      .catch(() => clearDossierSession())
  }, [initialSession, startsOnStaticPage])

  const openPrivacy = useCallback(() => {
    setReturnScreen(screen === 'privacy' ? 'landing' : screen)
    setScreen('privacy')
    if (window.location.hash !== '#confidentialite') {
      window.history.pushState(null, '', '#confidentialite')
    }
    window.scrollTo(0, 0)
  }, [screen])

  const openScreen = useCallback((newScreen, hash) => {
    setReturnScreen(screen === newScreen ? 'landing' : screen)
    setScreen(newScreen)
    if (hash && window.location.hash !== hash) {
      window.history.pushState(null, '', hash)
    }
    window.scrollTo(0, 0)
  }, [screen])

  const openArticle = useCallback((articleId) => {
    setActiveArticleId(articleId)
    setReturnScreen(screen === 'article' ? returnScreen : screen)
    setScreen('article')
    window.history.pushState(null, '', `#article-${articleId}`)
    window.scrollTo(0, 0)
  }, [screen, returnScreen])

  const closePrivacy = useCallback(() => {
    setScreen(returnScreen && !['privacy','about','legal','faq','contact','blog','article'].includes(returnScreen) ? returnScreen : 'landing')
    if (window.location.hash === '#confidentialite' || ['#a-propos', '#mentions-legales', '#faq', '#contact', '#conseils'].includes(window.location.hash) || window.location.hash.startsWith('#article-')) {
      window.history.pushState(null, '', window.location.pathname + window.location.search)
    }
    window.scrollTo(0, 0)
  }, [returnScreen])

  const startForm = async () => {
    // Validate motif selection
    const localErrs = {}
    if (!data.motif) {
      localErrs.motif = t('app.motif_required')
    }
    if (Object.keys(localErrs).length) {
      setErrors(localErrs)
      return
    }

    setIsSubmitting(true)
    setGlobalError('')
    try {
      const res = await createDossier({
        montant,
        duree_mois: duree,
        motif: data.motif,
        revenu_net: revenuEstime ? Number(revenuEstime) : undefined,
        charges_mensuelles: data.chargesMensuelles
          ? Number(data.chargesMensuelles)
          : undefined,
      })
      setDossierId(res.dossier.reference)
      setDossierToken(res.token)
      saveDossierSession({ reference: res.dossier.reference, token: res.token })
      if (revenuEstime && !data.revenuNet) {
        setData((d) => ({ ...d, revenuNet: revenuEstime }))
      }
      const sim = simulationFromDossier(res.dossier)
      if (sim.montant) setMontant(sim.montant)
      if (sim.duree) setDuree(sim.duree)
      setUploadedDocs(new Set())
      setStep(0)
      setScreen('form')
      window.scrollTo(0, 0)
    } catch (err) {
      handleApiError(err)
    } finally {
      setIsSubmitting(false)
    }
  }

  const submitForm = async (code) => {
    setIsSubmitting(true)
    setGlobalError('')
    try {
      const res = await verifyOtpAndSubmit(dossierId, dossierToken, code)
      setSubmittedDossier(res.dossier)
      setDossierId(res.dossier.reference)
      setScreen('loading')
      window.scrollTo(0, 0)
      setLoadStep(0)
    } catch (err) {
      handleApiError(err)
      throw err
    } finally {
      setIsSubmitting(false)
    }
  }

  const nextStep = async () => {
    const errs = validateStep(step, data)
    setErrors(errs)
    if (Object.keys(errs).length > 0) return

    if (!dossierId || !dossierToken) {
      setGlobalError(t('app.error_session'))
      return
    }

    setIsSubmitting(true)
    setGlobalError('')
    try {
      const payload = formDataToStepPayload(step, data, { montant, duree })
      const res = await updateDossierStep(dossierId, dossierToken, getStepId(step), payload)
      const sim = simulationFromDossier(res)
      if (sim.montant) setMontant(sim.montant)
      if (sim.duree) setDuree(sim.duree)

      if (step < FORM_STEPS.length - 1) {
        setStep((s) => s + 1)
        window.scrollTo(0, 0)
      } else {
        setSubmittedDossier(res)
        setScreen('success')
        window.scrollTo(0, 0)
      }
    } catch (err) {
      handleApiError(err)
    } finally {
      setIsSubmitting(false)
    }
  }

  const uploadDoc = async (type, file) => {
    if (!file) return
    if (!dossierId || !dossierToken) return
    setGlobalError('')
    try {
      await uploadDocument(dossierId, dossierToken, type, file)
      setUploadedDocs((prev) => {
        const next = new Set(prev)
        next.add(type)
        return next
      })
    } catch (err) {
      handleApiError(err)
      throw err
    }
  }

  const goHome = () => {
    setScreen('landing')
    if (window.location.hash === '#confidentialite') {
      window.history.pushState(null, '', window.location.pathname + window.location.search)
    }
    setStep(0)
    setErrors({})
    setGlobalError('')
    setDossierId('')
    setDossierToken('')
    setSubmittedDossier(null)
    setUploadedDocs(new Set())
    clearDossierSession()
    window.scrollTo(0, 0)
  }

  useEffect(() => {
    if (screen !== 'loading' || !dossierId || !dossierToken) return

    const intervals = [1200, 2400, 3800, 5200]
    const timers = intervals.map((t, i) =>
      setTimeout(async () => {
        try {
          await tickProcessing(dossierId, dossierToken)
          setLoadStep(i + 1)
        } catch {
          setLoadStep(i + 1)
        }
      }, t),
    )

    const done = setTimeout(() => setScreen('success'), 6500)

    return () => {
      timers.forEach(clearTimeout)
      clearTimeout(done)
      setLoadStep(0)
    }
  }, [screen, dossierId, dossierToken])


  const renderScreen = () => {
    if (screen === 'landing') {
      return (
        <>
          <SEO title="Simulez votre prêt personnel" />
          {globalError && (
            <div className="fixed top-4 right-4 left-4 z-50 mx-auto max-w-lg">
              <ApiErrorBanner error={globalError} onDismiss={() => setGlobalError('')} />
            </div>
          )}
          <LandingScreen
            montant={montant}
            setMontant={setMontant}
            duree={duree}
            setDuree={setDuree}
            mensualite={mensualite}
            coutTotal={coutTotal}
            totalRembourse={totalRembourse}
            motif={data.motif}
            setMotif={(v) => setField('motif', v)}
            revenuEstime={revenuEstime}
            setRevenuEstime={setRevenuEstime}
            errors={errors}
            onStart={startForm}
            onPrivacy={openPrivacy}
            onOpenAbout={() => openScreen('about', '#a-propos')}
            onOpenLegal={() => openScreen('legal', '#mentions-legales')}
            onOpenFaq={() => openScreen('faq', '#faq')}
            onOpenContact={() => openScreen('contact', '#contact')}
            onOpenBlog={() => openScreen('blog', '#conseils')}
            isLoading={isSubmitting}
          />
        </>
      )
    }

    if (screen === 'form') {
      return (
        <>
          <SEO title="Votre demande de crédit" />
          <FormScreen
            step={step}
            setStep={setStep}
            setScreen={setScreen}
            data={data}
            setField={setField}
            errors={errors}
            globalError={globalError}
            onDismissError={() => setGlobalError('')}
            montant={montant}
            duree={duree}
            mensualite={mensualite}
            totalRembourse={totalRembourse}
            coutTotal={coutTotal}
            onNext={nextStep}
            onUploadDocument={uploadDoc}
            uploadedDocs={uploadedDocs}
            onPrivacy={openPrivacy}
            isSubmitting={isSubmitting}
          />
        </>
      )
    }

    if (screen === 'otp') {
      return (
        <>
          <div className="fixed top-4 right-4 left-4 z-50 mx-auto max-w-lg">
            <ApiErrorBanner error={globalError} onDismiss={() => setGlobalError('')} />
          </div>
          <OtpScreen
            email={data.email}
            dossierReference={dossierId}
            dossierToken={dossierToken}
            onVerify={submitForm}
            isSubmitting={isSubmitting}
          />
        </>
      )
    }

    if (screen === 'loading') {
      return <LoadingScreen loadStep={loadStep} />
    }

    if (screen === 'success') {
      return (
        <SuccessScreen
          data={data}
          montant={montant}
          duree={duree}
          mensualite={mensualite}
          dossierId={submittedDossier?.reference ?? dossierId}
          onGoHome={goHome}
        />
      )
    }

    if (screen === 'privacy') {
      return (
        <>
          <SEO title="Politique de confidentialité" />
          <PrivacyPolicyScreen onBack={closePrivacy} />
        </>
      )
    }

    if (screen === 'about') return <AboutScreen onBack={closePrivacy} />
    if (screen === 'legal') return <LegalScreen onBack={closePrivacy} />
    if (screen === 'faq') return <FaqScreen onBack={closePrivacy} />
    if (screen === 'contact') return <ContactScreen onBack={closePrivacy} />
    if (screen === 'blog') return <BlogScreen onBack={closePrivacy} onReadArticle={openArticle} />
    if (screen === 'article') return (
      <ArticleScreen 
        articleId={activeArticleId} 
        onBack={() => openScreen('blog', '#conseils')} 
        onStartSimulator={startForm}
      />
    )

    return (
      <div className="flex min-h-svh items-center justify-center bg-lumina-background p-6">
        <div className="surface-card max-w-md p-6 text-center">
          <h1 className="font-[family-name:var(--font-headline)] text-lg font-semibold text-lumina-heading">
            {t('app.not_found_title')}
          </h1>
          <p className="mt-2 text-sm text-lumina-on-surface-variant">
            {t('app.not_found_body')}
          </p>
          <button type="button" onClick={goHome} className="btn-clenar mt-6">
            {t('app.home_button')}
          </button>
        </div>
      </div>
    )
  }

  return (
    <ErrorBoundary>
      <Suspense
        fallback={
          <div className="flex min-h-svh items-center justify-center bg-lumina-background p-6">
            <span className="text-sm text-lumina-on-surface-variant">{t('app.loading', 'Chargement...')}</span>
          </div>
        }
      >
        {renderScreen()}
      </Suspense>
    </ErrorBoundary>
  )
}


import { useEffect, useRef, useState } from 'react'
import { BrandLogo } from '@/components/lumina/BrandLogo'
import { Icon } from '@/components/lumina/Icon'
import { DotSpinner } from '@/components/lumina/DotSpinner'
import { ApiError, sendOtp } from '@/lib/api'
import { useTranslation } from 'react-i18next'

function maskEmail(email, t) {
  if (!email?.includes('@')) return t('otp.email_fallback')
  const [local, domain] = email.split('@')
  const visible = local.length <= 2 ? local[0] : local.slice(0, 2)
  return `${visible}•••@${domain}`
}

export function OtpScreen({
  onVerify,
  email,
  dossierReference,
  dossierToken,
  isSubmitting = false,
}) {
  const { t } = useTranslation()
  const [digits, setDigits] = useState(['', '', '', '', '', ''])
  const [otpError, setOtpError] = useState('')
  const [resendMessage, setResendMessage] = useState('')
  const [isSending, setIsSending] = useState(false)
  const inputsRef = useRef([])
  const sentOnMount = useRef(false)

  useEffect(() => {
    if (sentOnMount.current || !dossierReference || !dossierToken) return
    sentOnMount.current = true
    sendOtp(dossierReference, dossierToken)
      .catch((err) => {
        setOtpError(err instanceof ApiError ? err.message : t('otp.error_send'))
      })
  }, [dossierReference, dossierToken, t])

  const handleChange = (index, value) => {
    if (!/^\d?$/.test(value)) return
    const next = [...digits]
    next[index] = value
    setDigits(next)
    setOtpError('')
    if (value && index < 5) inputsRef.current[index + 1]?.focus()
  }

  const handleKeyDown = (index, e) => {
    if (e.key === 'Backspace' && !digits[index] && index > 0) {
      inputsRef.current[index - 1]?.focus()
    }
  }

  const handlePaste = (e) => {
    e.preventDefault()
    const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6)
    const next = [...digits]
    pasted.split('').forEach((d, i) => {
      next[i] = d
    })
    setDigits(next)
    const focusIdx = Math.min(pasted.length, 5)
    inputsRef.current[focusIdx]?.focus()
  }

  const handleResend = async () => {
    setResendMessage('')
    setOtpError('')
    setIsSending(true)
    try {
      await sendOtp(dossierReference, dossierToken)
      setResendMessage(t('otp.resend_success'))
    } catch (err) {
      setOtpError(err instanceof ApiError ? err.message : t('otp.error_resend'))
    } finally {
      setIsSending(false)
    }
  }

  const code = digits.join('')

  const handleVerify = async () => {
    setOtpError('')
    try {
      await onVerify(code)
    } catch (err) {
      if (err instanceof ApiError) {
        setOtpError(err.message)
      }
    }
  }

  return (
    <div className="flex min-h-svh flex-col bg-lumina-background p-4 font-[family-name:var(--font-body)]">
      <header className="mb-6 flex justify-center pt-4">
        <BrandLogo />
      </header>
      <div className="flex flex-1 items-center justify-center">
        <div className="surface-card w-full max-w-md p-4 sm:p-6 md:p-7">
          <div className="mb-5 flex justify-center">
            <div className="flex size-12 items-center justify-center rounded-md bg-lumina-surface-container">
              <Icon name="mail" filled size={24} className="text-lumina-secondary" />
            </div>
          </div>

          <h1 className="mb-2 text-center font-[family-name:var(--font-headline)] text-xl font-semibold text-lumina-heading">
            {t('otp.title')}
          </h1>
          <p className="mb-6 text-center text-xs leading-relaxed text-lumina-on-surface md:text-sm">
            {t('otp.subtitle1')}{' '}
            <strong className="text-lumina-heading">{maskEmail(email, t)}</strong>.
            {t('otp.subtitle2')}
          </p>

          {otpError && (
            <p className="mb-4 text-center text-xs text-lumina-error" role="alert">
              {otpError}
            </p>
          )}
          {resendMessage && (
            <p className="mb-4 text-center text-xs text-lumina-status-success">{resendMessage}</p>
          )}


          <div className="mb-8 flex justify-center gap-1.5 sm:gap-2 md:gap-3" id="otp-container">
            {digits.map((d, i) => (
              <input
                key={i}
                ref={(el) => {
                  inputsRef.current[i] = el
                }}
                type="text"
                inputMode="numeric"
                maxLength={1}
                value={d}
                onChange={(e) => handleChange(i, e.target.value)}
                onKeyDown={(e) => handleKeyDown(i, e)}
                onPaste={handlePaste}
                className="size-9 shrink-0 rounded-md border border-lumina-outline-variant bg-white text-center font-[family-name:var(--font-headline)] text-lg font-semibold text-lumina-on-surface outline-none focus:border-lumina-secondary focus:ring-2 focus:ring-lumina-secondary/25 sm:size-10"
              />
            ))}
          </div>

          <button
            type="button"
            disabled={code.length < 6 || isSubmitting}
            onClick={handleVerify}
            className="btn-clenar mb-4 flex w-full items-center justify-center gap-2 disabled:opacity-50"
          >
            {isSubmitting && <DotSpinner size={16} dots={8} />}
            {isSubmitting ? t('otp.validating') : t('otp.validate_button')}
            {!isSubmitting && <Icon name="arrow_forward" size={18} />}
          </button>

          <button
            type="button"
            disabled={isSending}
            onClick={handleResend}
            className="flex w-full items-center justify-center gap-2 text-sm font-medium text-lumina-on-surface transition-colors hover:text-lumina-heading disabled:opacity-50"
          >
            <Icon name="refresh" size={18} />
            {t('otp.resend_button')}
          </button>
        </div>
      </div>
    </div>
  )
}

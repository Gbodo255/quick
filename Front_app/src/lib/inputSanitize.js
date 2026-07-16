export function sanitizeLetters(value) {
  return value.replace(/[^a-zA-ZÀ-ÿ\s'-]/g, '')
}

export function sanitizeName(value) {
  return sanitizeLetters(value)
}

export function sanitizePhone(value) {
  return value.replace(/[^\d\s]/g, '').replace(/\s+/g, ' ').slice(0, 14)
}

export function sanitizeEmail(value) {
  return value.replace(/\s/g, '').slice(0, 120)
}

export function sanitizePostalCode(value) {
  return value.replace(/\D/g, '').slice(0, 5)
}

export function sanitizePositiveNumber(value) {
  const digits = value.replace(/[^\d]/g, '')
  if (!digits) return ''
  return String(parseInt(digits, 10))
}

export function sanitizeDecimal(value) {
  let cleaned = value.replace(/[^\d.,]/g, '').replace(',', '.')
  const parts = cleaned.split('.')
  if (parts.length > 2) {
    cleaned = `${parts[0]}.${parts.slice(1).join('')}`
  }
  if (cleaned.startsWith('.')) cleaned = `0${cleaned}`
  return cleaned
}

const SANITIZERS = {
  text: (v) => v,
  name: sanitizeName,
  letters: sanitizeLetters,
  phone: sanitizePhone,
  email: sanitizeEmail,
  postal: sanitizePostalCode,
  number: sanitizePositiveNumber,
  decimal: sanitizeDecimal,
}

export function sanitizeByKind(kind, value) {
  const fn = SANITIZERS[kind] ?? SANITIZERS.text
  return fn(value)
}

export function blockInvalidKey(e, kind) {
  if (e.ctrlKey || e.metaKey || e.altKey) return

  const allowedNav = [
    'Backspace',
    'Delete',
    'Tab',
    'ArrowLeft',
    'ArrowRight',
    'ArrowUp',
    'ArrowDown',
    'Home',
    'End',
  ]
  if (allowedNav.includes(e.key)) return

  if (kind === 'number' || kind === 'decimal' || kind === 'postal') {
    if (e.key === '-' || e.key === '+' || e.key === 'e' || e.key === 'E') {
      e.preventDefault()
    }
    if (kind === 'number' || kind === 'postal') {
      if (e.key.length === 1 && !/\d/.test(e.key)) e.preventDefault()
    }
    if (kind === 'decimal' && e.key.length === 1 && !/[\d.,]/.test(e.key)) {
      e.preventDefault()
    }
    return
  }

  if (kind === 'phone') {
    if (e.key.length === 1 && !/[\d\s]/.test(e.key)) e.preventDefault()
    return
  }

  if (kind === 'name' || kind === 'letters') {
    if (e.key.length === 1 && !/^[a-zA-ZÀ-ÿ\s'-]$/.test(e.key)) e.preventDefault()
  }
}

export function inferInputKind(type, id, label) {
  if (type === 'email') return 'email'
  if (type === 'tel') return 'phone'
  if (type === 'number') return 'number'
  if (id === 'codePostal' || label?.toLowerCase().includes('code postal')) return 'postal'
  if (id === 'prenom' || id === 'nom' || id === 'ville' || id === 'lieuNaissance') return 'name'
  if (id === 'employeur') return 'letters'
  return 'text'
}

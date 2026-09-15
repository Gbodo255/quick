import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import {
  blockInvalidKey,
  inferInputKind,
  sanitizeByKind,
} from '@/lib/inputSanitize'
import { cn } from '@/lib/utils'

const LUMINA_SELECT_TRIGGER =
  'h-9 w-full rounded-none border-lumina-outline-variant bg-lumina-surface-lowest px-3 text-sm font-normal shadow-none focus-visible:border-lumina-secondary focus-visible:ring-2 focus-visible:ring-lumina-secondary/25 data-placeholder:text-lumina-on-surface-variant'

export function LuminaLabel({ children, required, htmlFor }) {
  return (
    <label
      htmlFor={htmlFor}
      className="text-sm font-medium tracking-wide text-lumina-heading"
    >
      {children}
      {required && <span className="text-lumina-accent"> *</span>}
    </label>
  )
}

export function LuminaInput({
  id,
  label,
  type = 'text',
  inputKind,
  value,
  onChange,
  placeholder,
  error,
  required,
  icon,
  prefix,
  className,
  min,
  max,
  maxLength,
}) {
  const kind = inputKind ?? inferInputKind(type, id, label)

  const handleChange = (e) => {
    const raw = e.target.value
    onChange(sanitizeByKind(kind, raw))
  }

  const inputMode =
    kind === 'number' || kind === 'postal'
      ? 'numeric'
      : kind === 'phone'
        ? 'tel'
        : kind === 'email'
          ? 'email'
          : undefined

  const htmlType =
    type === 'email' || type === 'tel' || type === 'number' ? type : 'text'

  return (
    <div className={cn('flex flex-col gap-2', className)}>
      {label && (
        <LuminaLabel htmlFor={id} required={required}>
          {label}
        </LuminaLabel>
      )}
      <div className="relative">
        {icon && (
          <span className="pointer-events-none absolute top-1/2 left-3 -translate-y-1/2 text-lumina-on-surface-variant">
            {icon}
          </span>
        )}
        {prefix && (
          <span className="pointer-events-none absolute top-1/2 left-3 -translate-y-1/2 border-r border-lumina-outline-variant pr-2 text-sm text-lumina-on-surface">
            {prefix}
          </span>
        )}
        <input
          id={id}
          type={htmlType}
          inputMode={inputMode}
          value={value}
          onChange={handleChange}
          onKeyDown={(e) => blockInvalidKey(e, kind)}
          placeholder={placeholder}
          min={kind === 'number' ? (min ?? 0) : min}
          max={max}
          maxLength={maxLength ?? (kind === 'postal' ? 5 : undefined)}
          autoComplete={kind === 'email' ? 'email' : kind === 'phone' ? 'tel' : undefined}
          className={cn(
            'field-compact w-full text-lumina-on-surface transition-colors outline-none focus:border-lumina-secondary focus:ring-2 focus:ring-lumina-secondary/25',
            icon && 'pl-10',
            prefix && 'pl-14',
            error && 'border-lumina-error',
          )}
        />
      </div>
      {error && <p className="text-xs text-lumina-error">⚠ {error}</p>}
    </div>
  )
}

export function LuminaSelect({
  id,
  label,
  value,
  onChange,
  options,
  placeholder = 'Sélectionnez une option',
  error,
  required,
  className,
}) {
  return (
    <div className={cn('flex flex-col gap-2', className)}>
      {label && (
        <LuminaLabel htmlFor={id} required={required}>
          {label}
        </LuminaLabel>
      )}
      <Select value={value || ""} onValueChange={onChange}>
        <SelectTrigger
          id={id}
          className={cn(LUMINA_SELECT_TRIGGER, error && 'border-lumina-error')}
        >
          <SelectValue placeholder={placeholder} />
        </SelectTrigger>
        <SelectContent position="popper" className="w-(--radix-select-trigger-width)">
          {options.map(([val, text]) => (
            <SelectItem key={val} value={val}>
              {text}
            </SelectItem>
          ))}
        </SelectContent>
      </Select>
      {error && <p className="text-xs text-lumina-error">⚠ {error}</p>}
    </div>
  )
}

export function GlassBanner({ icon, title, children, variant = 'info' }) {
  const variants = {
    info: 'border-lumina-outline-variant/30 bg-white/70',
    success: 'border-lumina-status-success/20 bg-lumina-status-success/5',
    security: 'border-lumina-secondary/25 bg-lumina-surface-container-low',
  }
  return (
    <div
      className={cn(
        'flex items-start gap-3 rounded-none border p-3',
        variants[variant],
      )}
    >
      <span
        className="material-symbols-outlined shrink-0 text-lumina-secondary"
        style={{ fontVariationSettings: "'FILL' 1" }}
      >
        {icon}
      </span>
      <div>
        {title && (
          <p className="mb-1 text-sm font-semibold text-lumina-heading">{title}</p>
        )}
        <div className="text-sm leading-relaxed text-lumina-on-surface">{children}</div>
      </div>
    </div>
  )
}

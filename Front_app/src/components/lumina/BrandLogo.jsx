import { BRAND_WORDMARK } from '@/lib/credit'
import { Icon } from '@/components/lumina/Icon'
import { cn } from '@/lib/utils'

const SIZES = {
  default: {
    text: 'text-base',
    box: 'size-7',
    icon: 16,
  },
  lg: {
    text: 'text-xl md:text-2xl',
    box: 'size-10 md:size-11',
    icon: 24,
  },
}

export function BrandLogo({ className, variant = 'default', size = 'default' }) {
  const s = SIZES[size] ?? SIZES.default
  const isInverse = variant === 'inverse'

  return (
    <div
      className={cn(
        'flex items-center gap-2 font-[family-name:var(--font-headline)] font-semibold tracking-tight',
        s.text,
        variant === 'footer' ? 'text-lumina-on-surface' : isInverse ? 'text-white' : 'text-lumina-heading',
        className,
      )}
    >
      <span
        className={cn(
          'flex items-center justify-center rounded-md',
          isInverse ? 'bg-white/15 text-white' : 'bg-lumina-surface-container text-lumina-secondary',
          s.box,
        )}
      >
        <Icon name="account_balance" filled size={s.icon} />
      </span>
      <span>
        <span>{BRAND_WORDMARK.prefix}</span>
        <span className={isInverse ? 'text-white/85' : 'text-lumina-secondary'}>{BRAND_WORDMARK.accent}</span>
      </span>
    </div>
  )
}

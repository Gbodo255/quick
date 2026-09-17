import logoFullDark from '@/assets/brand/logo-full-dark.svg'
import logoFullWhite from '@/assets/brand/logo-full-white.svg'
import { cn } from '@/lib/utils'

const HEIGHTS = {
  default: 'h-6 md:h-7',
  lg: 'h-8 md:h-10',
}

export function BrandLogo({ className, variant = 'default', size = 'default' }) {
  const isInverse = variant === 'inverse' || variant === 'footer'
  const heightClass = HEIGHTS[size] ?? HEIGHTS.default

  return (
    <img
      src={isInverse ? logoFullWhite : logoFullDark}
      alt="StudCredit"
      draggable={false}
      className={cn('w-auto select-none', heightClass, className)}
    />
  )
}

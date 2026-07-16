import { BRAND_WORDMARK } from '@/lib/credit'
import { cn } from '@/lib/utils'

export function BrandLogo({ className, light = false }) {
  return (
    <div
      className={cn(
        'font-[family-name:var(--font-sora)] text-xl font-extrabold tracking-tight',
        light ? 'text-white' : 'text-[#0A0F1E]',
        className,
      )}
    >
      <span>{BRAND_WORDMARK.prefix}</span>
      <span className={light ? 'text-[#F5C842]' : 'text-[#5c46c2]'}>
        {BRAND_WORDMARK.accent}
      </span>
    </div>
  )
}

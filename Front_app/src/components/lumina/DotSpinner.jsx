import { cn } from '@/lib/utils'

export function DotSpinner({ size = 40, dots = 8, className }) {
  const items = Array.from({ length: dots })
  const radius = 42

  return (
    <div
      className={cn('dot-spinner', className)}
      style={{ width: size, height: size }}
      role="status"
      aria-label="Chargement"
    >
      {items.map((_, i) => {
        const angle = (i / dots) * 2 * Math.PI - Math.PI / 2
        const x = 50 + radius * Math.cos(angle)
        const y = 50 + radius * Math.sin(angle)
        const delay = -1 + (i / dots)
        return (
          <span
            key={i}
            style={{
              left: `${x}%`,
              top: `${y}%`,
              transform: 'translate(-50%, -50%)',
              animationDelay: `${delay}s`,
            }}
          />
        )
      })}
    </div>
  )
}

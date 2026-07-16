import { cn } from '@/lib/utils'

export function RadioCards({
  name,
  value,
  onChange,
  options,
  columns = 2,
  error,
}) {
  const gridClass =
    columns === 3
      ? 'grid-cols-2 sm:grid-cols-3'
      : 'grid-cols-2'

  return (
    <div>
      <div className={cn('mb-5 grid gap-3', gridClass)}>
        {options.map(([v, ico, txt, sub]) => (
          <label key={v} className="relative cursor-pointer">
            <input
              type="radio"
              name={name}
              value={v}
              checked={value === v}
              onChange={() => onChange(v)}
              className="absolute size-0 opacity-0"
            />
            <div
              className={cn(
                'flex flex-col items-center justify-center gap-1.5 rounded-[14px] border-[1.5px] bg-white px-3 py-4 text-center transition-all',
                value === v
                  ? 'border-[#0A0F1E] bg-[#F0F4FF]'
                  : 'border-gray-200 hover:border-gray-300',
              )}
            >
              <span className="text-2xl">{ico}</span>
              <span className="text-[13px] font-semibold text-[#0A0F1E]">{txt}</span>
              {sub && <span className="text-[11px] text-gray-400">{sub}</span>}
            </div>
          </label>
        ))}
      </div>
      {error && <p className="-mt-3 mb-4 text-xs text-red-500">⚠ {error}</p>}
    </div>
  )
}

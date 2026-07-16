import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { cn } from '@/lib/utils'

export function Field({
  label,
  name,
  type = 'text',
  placeholder,
  value,
  onChange,
  error,
  required,
  children,
}) {
  return (
    <div className="mb-5">
      <Label className="mb-2 block text-[13px] font-semibold text-[#0A0F1E]">
        {label}
        {required && <span className="ml-0.5 text-[#E6B830]">*</span>}
      </Label>
      {children || (
        <Input
          className={cn(
            'h-auto rounded-xl border-[1.5px] px-4 py-3.5 text-[15px]',
            error && 'border-red-500',
          )}
          type={type}
          name={name}
          placeholder={placeholder}
          value={value}
          onChange={(e) => onChange(name, e.target.value)}
          autoComplete="off"
        />
      )}
      {error && <p className="mt-1 text-xs text-red-500">⚠ {error}</p>}
    </div>
  )
}

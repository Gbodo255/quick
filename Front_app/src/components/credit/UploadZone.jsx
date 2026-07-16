import { useRef, useState } from 'react'
import { Label } from '@/components/ui/label'
import { cn } from '@/lib/utils'

export function UploadZone({
  label,
  hint,
  accept,
  value,
  onChange,
  required,
  error,
}) {
  const [drag, setDrag] = useState(false)
  const inputRef = useRef(null)

  const handleFile = (file) => {
    if (file) onChange(file)
  }

  return (
    <div className="mb-5">
      <Label className="mb-2 block text-[13px] font-semibold text-[#0A0F1E]">
        {label}
        {required && <span className="ml-0.5 text-[#E6B830]">*</span>}
      </Label>
      <div
        role="button"
        tabIndex={0}
        className={cn(
          'relative cursor-pointer rounded-2xl border-2 border-dashed px-5 py-8 text-center transition-all',
          drag && 'border-[#0A0F1E] bg-[#F8F9FF]',
          value
            ? 'border-solid border-emerald-500 bg-emerald-50'
            : 'border-gray-200 bg-white hover:border-[#0A0F1E] hover:bg-[#F8F9FF]',
        )}
        onDragOver={(e) => {
          e.preventDefault()
          setDrag(true)
        }}
        onDragLeave={() => setDrag(false)}
        onDrop={(e) => {
          e.preventDefault()
          setDrag(false)
          handleFile(e.dataTransfer.files[0])
        }}
        onClick={() => inputRef.current?.click()}
        onKeyDown={(e) => e.key === 'Enter' && inputRef.current?.click()}
      >
        <input
          ref={inputRef}
          type="file"
          accept={accept}
          className="absolute inset-0 cursor-pointer opacity-0"
          onChange={(e) => handleFile(e.target.files[0])}
        />
        {value ? (
          <div className="flex items-center justify-center gap-2.5">
            <span className="text-xl">✅</span>
            <span className="text-sm font-semibold text-emerald-600">{value.name}</span>
          </div>
        ) : (
          <>
            <div className="mb-3 text-4xl">📎</div>
            <p className="text-[15px] font-semibold text-[#0A0F1E]">
              Cliquer pour sélectionner
            </p>
            <p className="mt-1 text-[13px] text-gray-400">
              ou glisser-déposer votre fichier ici
            </p>
            <p className="mt-2 text-[11px] text-gray-400">JPG, PNG, PDF · max 10 Mo</p>
          </>
        )}
      </div>
      {hint && (
        <div className="mt-3 flex gap-2.5 rounded-xl border border-[#F5C842]/30 bg-[#FFF8E7] px-4 py-3.5">
          <span className="text-base">💡</span>
          <p className="text-xs leading-relaxed text-amber-900">{hint}</p>
        </div>
      )}
      {error && <p className="mt-1 text-xs text-red-500">⚠ {error}</p>}
    </div>
  )
}

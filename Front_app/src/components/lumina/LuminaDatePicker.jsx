/* eslint-disable react-hooks/set-state-in-effect */
import { useMemo, useState, useEffect } from 'react'
import { format, parseISO, isValid, getDaysInMonth, getDay } from 'date-fns'
import { fr } from 'date-fns/locale'
import { CalendarIcon } from 'lucide-react'
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover'
import { LuminaLabel } from '@/components/lumina/LuminaField'
import { cn } from '@/lib/utils'

function parseValue(value) {
  if (!value) return undefined
  const d = parseISO(value)
  return isValid(d) ? d : undefined
}

function formatDisplay(value) {
  const d = parseValue(value)
  if (!d) return ''
  return format(d, 'dd/MM/yyyy', { locale: fr })
}

export function LuminaDatePicker({
  id,
  label,
  value,
  onChange,
  error,
  required,
  className,
  minDate,
  maxDate,
  placeholder = 'Sélectionnez une date',
}) {
  const [open, setOpen] = useState(false)
  const [stage, setStage] = useState('year')
  const [draftYear, setDraftYear] = useState('')
  const [draftMonth, setDraftMonth] = useState(null)

  const selected = useMemo(() => parseValue(value), [value])

  const defaultMax = useMemo(() => {
    const d = new Date()
    d.setHours(23, 59, 59, 999)
    return d
  }, [])

  const defaultMin = useMemo(() => {
    const d = new Date()
    d.setFullYear(d.getFullYear() - 100)
    return d
  }, [])

  const min = minDate ?? defaultMin
  const max = maxDate ?? defaultMax

  useEffect(() => {
    if (selected) {
      setDraftYear(selected.getFullYear())
      setDraftMonth(selected.getMonth())
    } else {
      setDraftYear('')
      setDraftMonth(null)
    }
  }, [selected])

  useEffect(() => {
    if (!open) {
      setStage('year')
    }
  }, [open])

  const years = useMemo(() => {
    const startYear = min.getFullYear()
    const endYear = max.getFullYear()
    return Array.from({ length: endYear - startYear + 1 }, (_, index) => endYear - index)
  }, [min, max])

  const monthNames = useMemo(
    () => Array.from({ length: 12 }, (_, index) => format(new Date(2000, index, 1), 'MMMM', { locale: fr })),
    [],
  )

  const handleYearSelect = (year) => {
    setDraftYear(year)
    setDraftMonth(null)
    setStage('month')
  }

  const handleMonthSelect = (month) => {
    setDraftMonth(month)
    setStage('day')
  }

  const handleDaySelect = (day) => {
    if (draftYear === '' || draftMonth === null) return
    const date = new Date(draftYear, draftMonth, day)
    if (date < min || date > max) return
    onChange(format(date, 'yyyy-MM-dd'))
    setOpen(false)
  }

  const selectedYear = selected?.getFullYear() ?? ''
  const selectedMonth = selected?.getMonth()
  const selectedDay = selected?.getDate()

  const daysInMonth = draftYear !== '' && draftMonth !== null ? getDaysInMonth(new Date(draftYear, draftMonth, 1)) : 0
  const firstDayOfMonth = draftYear !== '' && draftMonth !== null ? new Date(draftYear, draftMonth, 1) : null
  const blankDays =
    firstDayOfMonth !== null ? ((getDay(firstDayOfMonth) + 6) % 7) : 0

  return (
    <div className={cn('flex flex-col gap-2', className)}>
      {label && (
        <LuminaLabel htmlFor={id} required={required}>
          {label}
        </LuminaLabel>
      )}
      <Popover open={open} onOpenChange={setOpen}>
        <PopoverTrigger asChild>
          <button
            id={id}
            type="button"
            className={cn(
              'field-compact flex w-full items-center justify-between gap-2 text-left transition-colors',
              !value && 'text-lumina-on-surface-variant',
              error && 'border-lumina-error',
            )}
          >
            <span>{value ? formatDisplay(value) : placeholder}</span>
            <CalendarIcon className="size-4 shrink-0 text-lumina-secondary" />
          </button>
        </PopoverTrigger>
        <PopoverContent className="w-[320px] p-4" align="start">
          <div className="flex flex-col gap-4">
            {stage !== 'year' && (
              <button
                type="button"
                onClick={() => setStage(stage === 'month' ? 'year' : 'month')}
                className="text-sm text-lumina-primary transition hover:text-lumina-primary/80"
              >
                ← Retour
              </button>
            )}

            {stage === 'year' && (
              <div className="grid max-h-72 grid-cols-4 gap-2 overflow-y-auto pr-1">
                {years.map((year) => (
                  <button
                    key={year}
                    type="button"
                    onClick={() => handleYearSelect(year)}
                    className={cn(
                      'rounded-none border px-3 py-2 text-sm transition text-left',
                      draftYear === year
                        ? 'border-lumina-primary bg-lumina-surface-container text-lumina-on-surface'
                        : 'border-lumina-outline hover:border-lumina-primary hover:bg-lumina-surface-container',
                    )}
                  >
                    {year}
                  </button>
                ))}
              </div>
            )}

            {stage === 'month' && (
              <div className="grid grid-cols-3 gap-2">
                {monthNames.map((monthName, index) => {
                  const monthDate = new Date(draftYear, index, 1)
                  const monthStart = monthDate
                  const monthEnd = new Date(draftYear, index, getDaysInMonth(monthDate), 23, 59, 59, 999)
                  const disabled = monthEnd < min || monthStart > max
                  return (
                    <button
                      key={monthName}
                      type="button"
                      onClick={() => handleMonthSelect(index)}
                      disabled={disabled}
                      className={cn(
                        'rounded-none border px-3 py-2 text-sm transition',
                        disabled
                          ? 'cursor-not-allowed border-lumina-outline text-lumina-on-surface-variant/70'
                          : 'border-lumina-outline hover:border-lumina-primary hover:bg-lumina-surface-container',
                      )}
                    >
                      {monthName}
                    </button>
                  )
                })}
              </div>
            )}

            {stage === 'day' && (
              <div className="space-y-3">
                <div className="grid grid-cols-7 gap-2 text-[0.65rem] font-semibold uppercase tracking-[0.16em] text-lumina-on-surface-variant">
                  {['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'].map((label) => (
                    <div key={label} className="text-center">
                      {label}
                    </div>
                  ))}
                </div>
                <div className="grid grid-cols-7 gap-2">
                  {Array.from({ length: blankDays }).map((_, index) => (
                    <div key={`blank-${index}`} className="h-10 rounded-none" />
                  ))}
                  {Array.from({ length: daysInMonth }, (_, index) => {
                    const day = index + 1
                    const date = new Date(draftYear, draftMonth, day)
                    const isSelected =
                      selectedYear === draftYear && selectedMonth === draftMonth && selectedDay === day
                    const disabled = date < min || date > max
                    return (
                      <button
                        key={day}
                        type="button"
                        onClick={() => handleDaySelect(day)}
                        disabled={disabled}
                        className={cn(
                          'h-10 rounded-none text-sm transition',
                          disabled
                            ? 'cursor-not-allowed bg-lumina-surface text-lumina-on-surface-variant'
                            : isSelected
                            ? 'bg-lumina-accent text-white'
                            : 'bg-lumina-surface-container text-lumina-on-surface hover:bg-lumina-surface hover:text-lumina-heading',
                        )}
                      >
                        {day}
                      </button>
                    )
                  })}
                </div>
              </div>
            )}
          </div>
        </PopoverContent>
      </Popover>
      {error && <p className="text-xs text-lumina-error">⚠ {error}</p>}
    </div>
  )
}

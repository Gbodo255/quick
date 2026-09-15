import { useState } from 'react'
import { Pencil } from 'lucide-react'
import { Button } from '@/components/ui/button'
import {
  Card,
  CardContent,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { BrandLogo } from '@/components/lumina/BrandLogo'
import { DotSpinner } from '@/components/lumina/DotSpinner'
import { Label } from '@/components/ui/label'
import {
  Select,
  SelectContent,
  SelectItem,
  SelectTrigger,
  SelectValue,
} from '@/components/ui/select'
import { Separator } from '@/components/ui/separator'
import { Slider } from '@/components/ui/slider'
import { fmt } from '@/lib/credit'
import { cn } from '@/lib/utils'
import { useTranslation } from 'react-i18next'

const SOBER = 'rounded-none'
const SLIDER_SQUARE = '[&_[data-slot=slider-range]]:bg-lumina-secondary [&_[data-slot=slider-thumb]]:rounded-none [&_[data-slot=slider-thumb]]:size-3.5 [&_[data-slot=slider-thumb]]:border-lumina-secondary [&_[data-slot=slider-track]]:rounded-none [&_[data-slot=slider-track]]:h-1.5 [&_[data-slot=slider-track]]:bg-lumina-surface-container'

const AMOUNT_OPTIONS = [15000, 25000, 35000, 50000, 10000]

export function SimulatorPanel({
  montant,
  setMontant,
  duree,
  setDuree,
  motif,
  setMotif,
  onStart,
  isLoading = false,
}) {
  const { t } = useTranslation()
  const [isEditingDuree, setIsEditingDuree] = useState(false)

  const commitDuree = (raw) => {
    const n = Math.round(Number(raw))
    if (!Number.isFinite(n)) return
    setDuree(Math.min(84, Math.max(12, n)))
  }

  const PROJET_OPTIONS = [
    { value: 'travaux', label: t('simulator.motifs.travaux') },
    { value: 'auto', label: t('simulator.motifs.auto') },
    { value: 'tresorerie', label: t('simulator.motifs.tresorerie') },
    { value: 'vacances', label: t('simulator.motifs.vacances') },
    { value: 'autre', label: t('simulator.motifs.autre') },
  ]

  return (
    <Card
      className={cn(
        SOBER,
        'gap-0 overflow-hidden border-lumina-outline bg-lumina-surface-lowest py-0 text-lumina-on-surface shadow-xl',
      )}
    >
      <CardHeader className="flex shrink-0 items-center justify-center gap-0 bg-transparent px-0 py-[3%]">
        <div className="flex w-[95%] flex-col items-start gap-2 rounded-lg bg-lumina-primary/80 px-4 py-4 md:px-5">
          <BrandLogo variant="inverse" />
          <CardTitle className="text-left font-[family-name:var(--font-headline)] text-base font-semibold tracking-tight text-white">
            {t('simulator.title')}
          </CardTitle>
        </div>
      </CardHeader>

      <CardContent className="space-y-4 px-4 py-4 md:px-5">
        <div className="space-y-1.5">
          <Label htmlFor="type-projet" className="text-sm font-medium text-lumina-heading">
            {t('simulator.project_type')}
          </Label>
          <Select value={motif || ""} onValueChange={setMotif}>
            <SelectTrigger
              id="type-projet"
              className={cn(SOBER, 'h-9 w-full border-lumina-outline-variant/60')}
            >
              <SelectValue placeholder={t('simulator.project_placeholder')} />
            </SelectTrigger>
            <SelectContent position="popper" className={cn(SOBER, 'w-(--radix-select-trigger-width)')}>
              {PROJET_OPTIONS.map((o) => (
                <SelectItem key={o.value} value={o.value} className={SOBER}>
                  {o.label}
                </SelectItem>
              ))}
            </SelectContent>
          </Select>
        </div>

        <Separator className="bg-lumina-outline-variant/30" />

        <div className="space-y-2.5">
          <div className="flex items-baseline justify-between">
            <Label className="text-sm font-medium text-lumina-heading">{t('simulator.amount')}</Label>
            <span className="text-sm font-semibold tabular-nums text-lumina-secondary">
              {fmt(montant)}
            </span>
          </div>
          <Slider
            value={[montant]}
            onValueChange={([v]) => setMontant(v)}
            min={1000}
            max={50000}
            step={500}
            className={SLIDER_SQUARE}
          />
          <div className="flex justify-between text-[11px] text-lumina-on-surface">
            <span>1 000 €</span>
            <span>50 000 €</span>
          </div>
          <div className="flex flex-wrap gap-1.5">
            {AMOUNT_OPTIONS.map((m) => (
              <Button
                key={m}
                type="button"
                variant={montant === m ? 'default' : 'outline'}
                size="sm"
                className={cn(
                  SOBER,
                  'h-7 text-xs',
                  montant === m
                    ? 'bg-lumina-accent text-white hover:bg-lumina-brand'
                    : 'border-lumina-outline-variant/60',
                )}
                onClick={() => setMontant(m)}
              >
                {fmt(m)}
              </Button>
            ))}
          </div>
        </div>

        <div className="space-y-2.5">
          <div className="flex items-baseline justify-between">
            <Label className="text-sm font-medium text-lumina-heading">{t('simulator.duration')}</Label>
            {isEditingDuree ? (
              <div className="flex items-center gap-1">
                <input
                  type="number"
                  min={12}
                  max={84}
                  step={1}
                  autoFocus
                  defaultValue={duree}
                  onChange={(e) => commitDuree(e.target.value)}
                  onBlur={() => setIsEditingDuree(false)}
                  onKeyDown={(e) => {
                    if (e.key === 'Enter') setIsEditingDuree(false)
                  }}
                  className="h-7 w-16 rounded-none border border-lumina-secondary bg-white px-1.5 text-right text-sm font-semibold text-lumina-heading outline-none"
                />
                <span className="text-xs text-lumina-on-surface">mois</span>
              </div>
            ) : (
              <button
                type="button"
                onClick={() => setIsEditingDuree(true)}
                className="flex items-center gap-1.5 text-sm font-semibold tabular-nums text-lumina-secondary"
              >
                {t('simulator.duration_months', { n: duree })}{duree >= 24 ? ` (${t('simulator.duration_years', { n: duree / 12 })})` : ''}
                <Pencil className="h-3.5 w-3.5" />
              </button>
            )}
          </div>
          <Slider
            value={[duree]}
            onValueChange={([v]) => setDuree(v)}
            min={12}
            max={84}
            step={12}
            className={SLIDER_SQUARE}
          />
        </div>

        <Button
          type="button"
          onClick={onStart}
          disabled={!motif || isLoading}
          className={cn(
            SOBER,
            'mt-2 flex h-10 w-full items-center justify-center gap-2 text-sm font-semibold bg-lumina-accent text-white hover:bg-lumina-brand disabled:opacity-60',
          )}
        >
          {isLoading && <DotSpinner size={16} dots={8} />}
          {isLoading ? t('simulator.cta_loading') : t('simulator.cta_continue')}
        </Button>
      </CardContent>
    </Card>
  )
}

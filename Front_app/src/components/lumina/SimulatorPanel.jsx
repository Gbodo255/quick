import { Button } from '@/components/ui/button'
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from '@/components/ui/card'
import { LuminaInput } from '@/components/lumina/LuminaField'
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
import {
  DUREES,
  MONTANTS_RAPIDES,
  TAUX_ANNUEL,
  fmt,
  fmtDec,
} from '@/lib/credit'
import { cn } from '@/lib/utils'
import { useTranslation } from 'react-i18next'

const SOBER = 'rounded-md'

export function SimulatorPanel({
  montant,
  setMontant,
  duree,
  setDuree,
  mensualite,
  coutTotal,
  totalRembourse,
  motif,
  setMotif,
  revenuEstime,
  setRevenuEstime,
  onStart,
  compact = false,
  isLoading = false,
}) {
  const { t } = useTranslation()

  const PROJET_OPTIONS = [
    { value: 'travaux', label: t('simulator.motifs.travaux') },
    { value: 'auto', label: t('simulator.motifs.auto') },
    { value: 'tresorerie', label: t('simulator.motifs.tresorerie') },
    { value: 'vacances', label: t('simulator.motifs.vacances') },
    { value: 'autre', label: t('simulator.motifs.autre') },
  ]

  const endettement =
    revenuEstime && +revenuEstime > 0
      ? Math.round((mensualite / +revenuEstime) * 100)
      : null

  return (
    <Card
      className={cn(
        SOBER,
        'gap-0 overflow-hidden border-lumina-outline bg-lumina-surface-lowest py-0 text-lumina-on-surface shadow-[var(--shadow-lumina-card)]',
        compact && 'flex h-full min-h-0 flex-col',
      )}
    >
      <CardHeader
        className={cn(
          'shrink-0 border-b border-lumina-outline-variant/15 px-4 py-3 md:px-5',
          compact && 'py-2.5',
        )}
      >
        <CardTitle className="text-center font-[family-name:var(--font-headline)] text-base font-semibold tracking-tight text-lumina-heading">
          {t('simulator.title')}
        </CardTitle>
        <CardDescription className="text-center text-sm text-lumina-on-surface">
          {t('simulator.subtitle')}
        </CardDescription>
      </CardHeader>

      <div className={cn('grid min-h-0 lg:grid-cols-2', compact && 'flex-1')}>
        <CardContent
          className={cn(
            'space-y-4 px-4 py-4 md:px-5',
            compact && 'space-y-3 overflow-y-auto py-3',
          )}
        >
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
                  <SelectItem key={o.value} value={o.value}>
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
              className="[&_[data-slot=slider-range]]:bg-lumina-secondary [&_[data-slot=slider-thumb]]:size-3.5 [&_[data-slot=slider-thumb]]:border-lumina-secondary [&_[data-slot=slider-track]]:h-1.5 [&_[data-slot=slider-track]]:bg-lumina-surface-container"
            />
            <div className="flex justify-between text-[11px] text-lumina-on-surface">
              <span>1 000 €</span>
              <span>50 000 €</span>
            </div>
            <div className="flex flex-wrap gap-1.5">
              {MONTANTS_RAPIDES.map((m) => (
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
              <span className="text-sm font-semibold tabular-nums text-lumina-secondary">
                {t('simulator.duration_months', { n: duree })}{duree >= 24 ? ` (${t('simulator.duration_years', { n: duree / 12 })})` : ''}
              </span>
            </div>
            <Slider
              value={[duree]}
              onValueChange={([v]) => setDuree(v)}
              min={12}
              max={84}
              step={12}
              className="[&_[data-slot=slider-range]]:bg-lumina-secondary [&_[data-slot=slider-thumb]]:size-3.5 [&_[data-slot=slider-thumb]]:border-lumina-secondary [&_[data-slot=slider-track]]:h-1.5 [&_[data-slot=slider-track]]:bg-lumina-surface-container"
            />
            <div className="flex flex-wrap gap-1.5">
              {DUREES.map((d) => (
                <Button
                  key={d}
                  type="button"
                  variant={duree === d ? 'default' : 'outline'}
                  size="sm"
                  className={cn(
                    SOBER,
                    'h-7 min-w-[52px] text-xs',
                    duree === d
                      ? 'bg-lumina-accent text-white hover:bg-lumina-brand'
                      : 'border-lumina-outline-variant/60',
                  )}
                  onClick={() => setDuree(d)}
                >
                  {d < 24 ? `${d}m` : `${d / 12}a`}
                </Button>
              ))}
            </div>
          </div>

          <div className="space-y-1.5">
            <Label htmlFor="revenu-estime" className="text-sm font-medium text-lumina-heading">
              {t('simulator.income')}{' '}
              <span className="font-normal text-lumina-on-surface">{t('simulator.income_optional')}</span>
            </Label>
            <LuminaInput
              id="revenu-estime"
              inputKind="number"
              placeholder="Ex. 2500"
              value={revenuEstime}
              onChange={setRevenuEstime}
              className="gap-1.5"
            />
            <p className="text-[11px] text-lumina-on-surface">
              {t('simulator.income_hint')}
            </p>
          </div>
        </CardContent>

        <div
          className={cn(
            'flex min-h-0 flex-col border-t border-lumina-outline-variant/15 bg-lumina-surface-container-low lg:border-t-0 lg:border-l',
            compact && 'overflow-y-auto',
          )}
        >
          <CardContent
            className={cn(
              'flex flex-1 flex-col justify-between px-4 py-4 md:px-5',
              compact && 'py-3',
            )}
          >
            <div className={cn('space-y-3', compact && 'space-y-2.5')}>
              <p className="text-xs font-medium tracking-widest text-lumina-heading uppercase">
                {t('simulator.summary_title')}
              </p>

              <div className="flex items-end justify-between border-b border-lumina-outline-variant/25 pb-3">
                <span className="text-sm font-medium text-lumina-on-surface">{t('simulator.monthly')}</span>
                <div className="text-right">
                  <p
                    className={cn(
                      'font-[family-name:var(--font-headline)] font-semibold tabular-nums text-lumina-heading',
                      compact ? 'text-xl md:text-2xl' : 'text-2xl md:text-3xl',
                    )}
                  >
                    {fmtDec(mensualite)}
                  </p>
                  <p className="text-xs text-lumina-on-surface">{t('simulator.per_month')}</p>
                </div>
              </div>

              <dl className="space-y-2 text-sm">
                <div className="flex justify-between">
                  <dt className="text-lumina-on-surface">{t('simulator.fixed_rate')}</dt>
                  <dd className="font-semibold tabular-nums text-lumina-heading">
                    {TAUX_ANNUEL} %
                  </dd>
                </div>
                <div className="flex justify-between">
                  <dt className="text-lumina-on-surface">Assurance emprunteur</dt>
                  <dd className="font-semibold tabular-nums text-lumina-heading text-lumina-primary">
                    Incluse
                  </dd>
                </div>
                <div className="flex justify-between">
                  <dt className="text-lumina-on-surface">{t('simulator.credit_cost')}</dt>
                  <dd className="font-semibold tabular-nums text-lumina-heading">
                    {fmtDec(coutTotal)}
                  </dd>
                </div>
                <div className="flex justify-between">
                  <dt className="text-lumina-on-surface">{t('simulator.total')}</dt>
                  <dd className="font-semibold tabular-nums text-lumina-heading">
                    {fmtDec(totalRembourse)}
                  </dd>
                </div>
                <div className="flex justify-between">
                  <dt className="text-lumina-on-surface">{t('simulator.capital')}</dt>
                  <dd className="font-semibold tabular-nums text-lumina-secondary">
                    {fmt(montant)}
                  </dd>
                </div>
              </dl>

              {endettement !== null && (
                <div
                  className={cn(
                    SOBER,
                    'border px-3 py-2.5 text-xs',
                    endettement < 33
                      ? 'border-lumina-accent/30 bg-lumina-status-success-bg text-lumina-accent'
                      : endettement < 45
                        ? 'border-lumina-warning/40 bg-lumina-warning-bg text-lumina-warning-foreground'
                        : 'border-red-200 bg-red-50 text-red-900',
                  )}
                >
                  {t('simulator.debt_rate')} : <strong>{endettement} %</strong>
                  {endettement < 33 && ` ${t('simulator.debt_favorable')}`}
                </div>
              )}
            </div>

            <Button
              type="button"
              onClick={onStart}
              disabled={!motif || isLoading}
              className={cn(
                SOBER,
                compact ? 'mt-3' : 'mt-5',
                'h-9 w-full rounded-md bg-lumina-accent text-xs font-semibold text-white hover:bg-lumina-brand disabled:opacity-60',
              )}
            >
              {isLoading ? t('simulator.cta_loading') : t('simulator.cta_continue')}
            </Button>
            {!motif && (
              <p className="mt-2 text-center text-[11px] text-lumina-on-surface">
                {t('simulator.select_project_hint')}
              </p>
            )}
          </CardContent>
        </div>
      </div>

      <CardFooter
        className={cn(
          'shrink-0 border-t border-lumina-outline-variant/15 bg-lumina-surface/50 px-4 py-2 md:px-5',
          compact && 'py-1.5',
        )}
      >
        <p className="w-full text-center text-[10px] leading-relaxed text-lumina-on-surface">
          {t('simulator.legal_notice')}
          <span className="mt-0.5 block text-lumina-on-surface">
            {t('simulator.legal_example', { amount: fmt(montant), duration: duree, rate: TAUX_ANNUEL })}
          </span>
        </p>
      </CardFooter>
    </Card>
  )
}

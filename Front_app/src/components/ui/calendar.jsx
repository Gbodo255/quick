import { DayPicker, getDefaultClassNames } from 'react-day-picker'
import { fr } from 'date-fns/locale'
import { ChevronLeftIcon, ChevronRightIcon } from 'lucide-react'

import { cn } from '@/lib/utils'
import { buttonVariants } from '@/components/ui/button'

function Calendar({ className, classNames, showOutsideDays = true, ...props }) {
  const defaultClassNames = getDefaultClassNames()

  return (
    <DayPicker
      showOutsideDays={showOutsideDays}
      locale={fr}
      className={cn('p-3', className)}
      classNames={{
        root: cn('w-fit', defaultClassNames.root),
        months: cn('relative flex flex-col gap-3', defaultClassNames.months),
        month: cn('flex w-full flex-col gap-3', defaultClassNames.month),
        nav: cn(
          'absolute inset-x-0 top-0 flex w-full items-center justify-between',
          defaultClassNames.nav,
        ),
        button_previous: cn(
          buttonVariants({ variant: 'ghost' }),
          'size-8 p-0 text-lumina-on-surface hover:bg-lumina-surface-container hover:text-lumina-heading',
          defaultClassNames.button_previous,
        ),
        button_next: cn(
          buttonVariants({ variant: 'ghost' }),
          'size-8 p-0 text-lumina-on-surface hover:bg-lumina-surface-container hover:text-lumina-heading',
          defaultClassNames.button_next,
        ),
        month_caption: cn(
          'flex h-8 w-full items-center justify-center',
          defaultClassNames.month_caption,
        ),
        caption_label: cn(
          'text-sm font-semibold text-lumina-heading select-none',
          defaultClassNames.caption_label,
        ),
        weekdays: cn('flex', defaultClassNames.weekdays),
        weekday: cn(
          'flex-1 text-[0.75rem] font-medium text-lumina-on-surface-variant select-none',
          defaultClassNames.weekday,
        ),
        week: cn('mt-1 flex w-full', defaultClassNames.week),
        day: cn(
          'relative p-0 text-center select-none [&_button]:size-8 [&_button]:rounded-md [&_button]:text-sm [&_button]:font-normal [&_button]:text-lumina-on-surface [&_button]:hover:bg-lumina-surface-container',
          defaultClassNames.day,
        ),
        day_button: cn(
          'size-8 rounded-md font-normal transition-colors',
          defaultClassNames.day_button,
        ),
        today: cn(
          'rounded-md bg-lumina-surface-container font-semibold text-lumina-heading',
          defaultClassNames.today,
        ),
        outside: cn('text-lumina-on-surface-variant/50', defaultClassNames.outside),
        disabled: cn('text-lumina-on-surface-variant opacity-40', defaultClassNames.disabled),
        selected: cn(
          'rounded-md bg-lumina-accent text-white hover:bg-lumina-accent hover:text-white focus:bg-lumina-accent focus:text-white',
          defaultClassNames.selected,
        ),
        ...classNames,
      }}
      components={{
        Chevron: ({ orientation, className: chevronClass, ...chevronProps }) => {
          const Icon = orientation === 'left' ? ChevronLeftIcon : ChevronRightIcon
          return <Icon className={cn('size-4', chevronClass)} {...chevronProps} />
        },
      }}
      {...props}
    />
  )
}

export { Calendar }

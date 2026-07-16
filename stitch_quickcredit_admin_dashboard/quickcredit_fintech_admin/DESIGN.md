---
name: QuickCredit Fintech Admin
colors:
  surface: '#fcf8fa'
  surface-dim: '#dcd9db'
  surface-bright: '#fcf8fa'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#f6f3f5'
  surface-container: '#f0edef'
  surface-container-high: '#eae7e9'
  surface-container-highest: '#e4e2e4'
  on-surface: '#1b1b1d'
  on-surface-variant: '#45464d'
  inverse-surface: '#303032'
  inverse-on-surface: '#f3f0f2'
  outline: '#76777d'
  outline-variant: '#c6c6cd'
  surface-tint: '#565e74'
  primary: '#000000'
  on-primary: '#ffffff'
  primary-container: '#131b2e'
  on-primary-container: '#7c839b'
  inverse-primary: '#bec6e0'
  secondary: '#006c49'
  on-secondary: '#ffffff'
  secondary-container: '#6cf8bb'
  on-secondary-container: '#00714d'
  tertiary: '#000000'
  on-tertiary: '#ffffff'
  tertiary-container: '#2a1700'
  on-tertiary-container: '#b87500'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#dae2fd'
  primary-fixed-dim: '#bec6e0'
  on-primary-fixed: '#131b2e'
  on-primary-fixed-variant: '#3f465c'
  secondary-fixed: '#6ffbbe'
  secondary-fixed-dim: '#4edea3'
  on-secondary-fixed: '#002113'
  on-secondary-fixed-variant: '#005236'
  tertiary-fixed: '#ffddb8'
  tertiary-fixed-dim: '#ffb95f'
  on-tertiary-fixed: '#2a1700'
  on-tertiary-fixed-variant: '#653e00'
  background: '#fcf8fa'
  on-background: '#1b1b1d'
  surface-variant: '#e4e2e4'
typography:
  display-lg:
    fontFamily: Geist
    fontSize: 36px
    fontWeight: '600'
    lineHeight: 44px
    letterSpacing: -0.02em
  display-lg-mobile:
    fontFamily: Geist
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
    letterSpacing: -0.02em
  headline-md:
    fontFamily: Geist
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
    letterSpacing: -0.01em
  headline-sm:
    fontFamily: Geist
    fontSize: 20px
    fontWeight: '600'
    lineHeight: 28px
  body-lg:
    fontFamily: Geist
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  body-md:
    fontFamily: Geist
    fontSize: 14px
    fontWeight: '400'
    lineHeight: 20px
  label-md:
    fontFamily: Geist
    fontSize: 12px
    fontWeight: '500'
    lineHeight: 16px
    letterSpacing: 0.01em
  label-sm:
    fontFamily: Geist
    fontSize: 11px
    fontWeight: '600'
    lineHeight: 14px
rounded:
  sm: 0.125rem
  DEFAULT: 0.25rem
  md: 0.375rem
  lg: 0.5rem
  xl: 0.75rem
  full: 9999px
spacing:
  unit: 4px
  container-padding: 32px
  gutter: 24px
  sidebar-width: 260px
  section-gap: 40px
  element-gap: 12px
---

## Brand & Style
The design system is engineered for high-stakes financial operations, prioritizing clarity, speed, and institutional trust. The aesthetic is **Corporate Modern Minimalism**, characterized by a rigorous commitment to whitespace, precise alignment, and a sophisticated "Stripe-like" clarity. 

The UI should evoke a sense of calm authority. By stripping away unnecessary ornamentation and relying on a disciplined grid, the system allows complex financial data to remain readable and actionable. Every element serves a functional purpose, ensuring that credit analysts and administrators can make high-impact decisions without cognitive fatigue.

## Colors
The color palette is anchored by **Deep Blue (#0F172A)**, used for primary actions, navigation, and core branding to establish a foundation of stability. 

Semantic colors are utilized with high intentionality:
- **Emerald Green (#10B981)** signals "Approved" status and positive growth trends.
- **Amber (#F59E0B)** indicates "Pending" workflows or warnings requiring attention.
- **Rose (#E11D48)** is reserved for "Rejected" applications and critical error states.

Neutral grays follow a cool-toned scale, providing a crisp structure for borders, backgrounds, and secondary text, ensuring the interface feels airy rather than heavy.

## Typography
This design system utilizes **Geist** for its technical precision and exceptional legibility at small sizes, which is critical for data-heavy financial dashboards. 

Headlines use a semi-bold weight with slight negative letter-spacing to create a compact, professional appearance. Body text is optimized for long-form reading in tables and detail drawers. Label styles are employed for status badges and table headers, often utilizing uppercase transformations to distinguish metadata from primary content.

## Layout & Spacing
The system employs a **Fixed Grid** philosophy for the main dashboard content to ensure consistency across large displays, while the sidebar remains fixed to the viewport.

- **Desktop (1440px+):** 12-column grid, 24px gutters, 32px outer margins.
- **Tablet (768px - 1024px):** Sidebar collapses into an icon-only rail or drawer; margins reduce to 24px.
- **Mobile (<768px):** Single-column stack, 16px margins, fluid containers.

Spacing follows a strict 4px base unit. Generous whitespace is used between statistical cards and table rows to prevent the "data-clutter" common in fintech apps.

## Elevation & Depth
The design system uses **Tonal Layers** and **Subtle Shadows** to create a shallow, organized hierarchy. 

1. **Base Layer:** The background uses a very light gray (#F8FAFC) to create a canvas.
2. **Surface Layer:** Cards, tables, and containers are white (#FFFFFF) with a thin 1px border (#E2E8F0) and a soft, low-opacity shadow (4px blur, 2% opacity) to provide a "lifted" effect.
3. **Overlay Layer:** Detail drawers and modals use a more pronounced shadow (12px blur, 8% opacity) and a backdrop blur (8px) on the content below to maintain focus on the task at hand.

Avoid heavy dark shadows; the depth should be felt through borders and subtle shifts in surface color rather than dramatic lighting.

## Shapes
The shape language is **Soft and Precise**. A 0.25rem (4px) base radius is applied to most UI components (inputs, buttons, cards) to maintain a professional, slightly architectural feel. 

Larger containers like detail drawers or dashboard cards may use a 0.5rem (8px) radius to soften the overall appearance of the page. This balance ensures the UI feels modern and approachable without losing the "financial-grade" seriousness that sharper corners provide.

## Components
- **Data Tables:** Use a zebra-stripe pattern or subtle hover states. Column headers should be `label-sm` with sort icons.
- **Status Badges:** Subtle background tints matching the semantic colors (e.g., light green background with dark green text for "Approved").
- **Statistical Cards:** Feature a large `headline-md` value, a secondary label, and a small, simplified sparkline to show 7-day trends.
- **Buttons:** Primary buttons are solid Deep Blue. Secondary buttons are outlined with a 1px gray border.
- **Side Navigation:** High-contrast background (Deep Blue) with active states indicated by a subtle left-aligned accent bar in Emerald Green or a white background-opacity shift.
- **Detail Drawers:** Slide out from the right, occupying 400px–600px of screen real estate, using a white surface and clear "close" affordance.
- **Multi-step Indicators:** Horizontal progress bars using thin lines and numeric circles, shifting from Gray to Deep Blue as steps are completed.
export function GraduationIllustration({ className }) {
  return (
    <svg viewBox="0 0 400 400" className={className} fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
      <circle cx="66" cy="84" r="26" fill="white" fillOpacity="0.12" />
      <circle cx="338" cy="322" r="42" fill="white" fillOpacity="0.1" />
      <circle cx="330" cy="66" r="12" fill="white" fillOpacity="0.2" />
      <circle cx="60" cy="330" r="10" fill="white" fillOpacity="0.2" />

      {/* books stack */}
      <rect x="105" y="262" width="210" height="28" rx="7" fill="white" fillOpacity="0.85" transform="rotate(-2 210 276)" />
      <rect x="118" y="233" width="184" height="28" rx="7" fill="white" fillOpacity="0.65" transform="rotate(2 210 247)" />
      <rect x="112" y="204" width="196" height="28" rx="7" fill="white" fillOpacity="0.95" transform="rotate(-1 210 218)" />

      {/* graduation cap */}
      <g transform="translate(210 148)">
        <polygon points="0,-42 92,0 0,42 -92,0" fill="white" />
        <rect x="-24" y="0" width="48" height="32" rx="5" fill="white" fillOpacity="0.85" />
        <line x1="72" y1="-10" x2="72" y2="58" stroke="white" strokeWidth="4" strokeLinecap="round" />
        <circle cx="72" cy="64" r="7" fill="white" />
      </g>

      {/* diploma */}
      <g transform="translate(302 226) rotate(18)">
        <rect x="-10" y="-46" width="20" height="92" rx="10" fill="white" fillOpacity="0.9" />
        <rect x="-17" y="-52" width="34" height="11" rx="5.5" fill="white" />
        <rect x="-17" y="41" width="34" height="11" rx="5.5" fill="white" />
      </g>
    </svg>
  )
}

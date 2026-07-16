const modules = import.meta.glob('../assets/backgrounds/*.{jpg,jpeg,png,webp,JPG,JPEG,PNG,WEBP}', {
  eager: true,
  import: 'default',
})

export const HERO_BACKGROUNDS = Object.entries(modules)
  .sort(([a], [b]) => a.localeCompare(b))
  .map(([, url]) => url)

export const HAS_HERO_BACKGROUNDS = HERO_BACKGROUNDS.length > 0

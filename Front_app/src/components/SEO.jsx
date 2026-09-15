import { Helmet } from 'react-helmet-async';

export function SEO({ title, description, url = 'https://studcredit.com', image = '/og-image.png', schema = null }) {
  const siteTitle = 'CreditEco - Obtenez votre crédit rapidement';
  const fullTitle = title ? `${title} | CreditEco` : siteTitle;
  const defaultDescription = "CreditEco est la solution la plus rapide pour simuler et obtenir votre prêt personnel en ligne en toute sécurité.";

  return (
    <Helmet>
      <title>{fullTitle}</title>
      <meta name="description" content={description || defaultDescription} />
      
      {/* Open Graph / Facebook */}
      <meta property="og:type" content="website" />
      <meta property="og:url" content={url} />
      <meta property="og:title" content={fullTitle} />
      <meta property="og:description" content={description || defaultDescription} />
      <meta property="og:image" content={image} />

      {/* Twitter */}
      <meta property="twitter:card" content="summary_large_image" />
      <meta property="twitter:url" content={url} />
      <meta property="twitter:title" content={fullTitle} />
      <meta property="twitter:description" content={description || defaultDescription} />
      <meta property="twitter:image" content={image} />

      {/* Structured Data (Schema.org) */}
      <script type="application/ld+json">
        {JSON.stringify({
          "@context": "https://schema.org",
          "@graph": [
            {
              "@type": "Organization",
              "@id": "https://studcredit.com/#organization",
              "name": "CreditEco",
              "alternateName": "StudCredit",
              "url": "https://studcredit.com",
              "logo": "https://studcredit.com/logo.png"
            },
            {
              "@type": "WebSite",
              "@id": "https://studcredit.com/#website",
              "url": "https://studcredit.com",
              "name": "CreditEco",
              "publisher": {
                "@id": "https://studcredit.com/#organization"
              }
            },
            ...(schema ? [schema] : [])
          ]
        })}
      </script>
    </Helmet>
  );
}

# Configuration des Emails

## Mode Production (Actuel - ✅ APPLIQUÉ)

### Configuration appliquée (.env)

```
MAIL_MAILER=smtp
MAIL_SCHEME=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=banceg18@gmail.com
MAIL_PASSWORD="udry hurb kufd eeyz"
MAIL_FROM_ADDRESS=banceg18@gmail.com
MAIL_FROM_NAME="Quickcredit"
```

✅ **Statut**: Les emails OTP sont envoyés en temps réel via Gmail SMTP
✅ **Codes OTP testés**: 
  - 446209 pour jean@test.local
  - 350351 pour chrisvianneymaoule@gmail.com

### Vérifier les logs d'envoi

Les confirmations d'envoi sont enregistrées dans :

```
Back_app/storage/logs/laravel.log
```

Exemple :
```
[2026-05-25 08:18:44] local.INFO: OTP envoyé pour le dossier CR-E52DD2 
{"email":"jean@test.local","code":"446209"}
```

---

## Mode Développement Alternatif (non utilisé actuellement)

En mode développement, vous pouvez enregistrer les emails dans les logs au lieu de les envoyer réellement.

### Configuration pour développement

```
MAIL_MAILER=log
MAIL_FROM_ADDRESS="noreply@quickcredit.local"
MAIL_FROM_NAME="Quickcredit"
```

Les emails sont alors enregistrés dans `Back_app/storage/logs/laravel.log`.

## Mode Production - Options alternatives

### Option 1: Gmail SMTP (✅ Actualmente configurado)

**Cette option est actuellement configurée et active.**

```env
MAIL_MAILER=smtp
MAIL_SCHEME=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=banceg18@gmail.com
MAIL_PASSWORD="udry hurb kufd eeyz"
MAIL_FROM_ADDRESS=banceg18@gmail.com
MAIL_FROM_NAME="Quickcredit"
```

**Important:** Utilisez une "clé d'application" Google, pas votre mot de passe Gmail.
- Activez l'authentification à deux facteurs sur votre compte Gmail
- Allez sur https://myaccount.google.com/apppasswords
- Générez une clé d'application

### Option 2: Mailtrap (Recommandé pour les tests)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_SCHEME=tls
MAIL_USERNAME=your-mailtrap-username
MAIL_PASSWORD=your-mailtrap-password
MAIL_FROM_ADDRESS=noreply@quickcredit.local
MAIL_FROM_NAME="Quickcredit"
```

Inscrivez-vous gratuitement sur https://mailtrap.io

### Option 3: Mailgun

```env
MAIL_MAILER=mailgun
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Quickcredit"
MAILGUN_SECRET=your-mailgun-secret
MAILGUN_DOMAIN=your-mailgun-domain
```

### Option 4: SendGrid

```env
MAIL_MAILER=sendgrid
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Quickcredit"
SENDGRID_API_KEY=your-sendgrid-api-key
```

## Voir les Logs en Temps Réel

Pour suivre les emails envoyés en temps réel :

```bash
cd Back_app
php artisan pail --timeout=0
```

## Tester l'Envoi d'Email en Production

Pour tester que les emails sont bien envoyés via Gmail :

```bash
cd Back_app
php artisan serve --host=127.0.0.1 --port=8000
```

Puis dans une autre fenêtre terminal :

```bash
cd Back_app
php scripts/test-api-flow.php
```

Résultat attendu : `OTP SEND 200` (l'OTP a été envoyé avec succès)

Vérifiez ensuite que l'email est arrivé dans votre boîte Gmail à l'adresse spécifiée dans le test.

**Note:** Les logs d'envoi seront dans `storage/logs/laravel.log` avec le message "OTP envoyé".

## Dépannage

### Les emails ne sont pas reçus en mode SMTP

1. Vérifiez les credentials dans `.env`
2. Vérifiez les logs pour les erreurs : `php artisan pail`
3. Assurez-vous que le port SMTP (587 ou 465) est ouvert
4. Vérifiez les filtres anti-spam de votre boîte mail

### En mode Log (Développement)

Les emails ne sont PAS envoyés réellement, mais enregistrés dans `storage/logs/laravel.log`.

C'est normal et voulu pour le développement.

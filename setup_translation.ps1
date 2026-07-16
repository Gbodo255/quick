#!/bin/bash

# ========================================
# Script de configuration du système de traduction (Windows)
# Exécuter: .\setup_translation.ps1
# ========================================

Write-Host "🚀 Configuration du système de traduction..." -ForegroundColor Green
Write-Host ""

# Vérifier Node.js
if (-not (Get-Command node -ErrorAction SilentlyContinue)) {
    Write-Host "❌ Node.js n'est pas installé" -ForegroundColor Red
    exit 1
}

# Vérifier npm
if (-not (Get-Command npm -ErrorAction SilentlyContinue)) {
    Write-Host "❌ npm n'est pas installé" -ForegroundColor Red
    exit 1
}

# Vérifier Composer
if (-not (Get-Command composer -ErrorAction SilentlyContinue)) {
    Write-Host "❌ Composer n'est pas installé" -ForegroundColor Red
    exit 1
}

Write-Host "✅ Outils requis détectés" -ForegroundColor Green
Write-Host ""

# ========== FRONTEND ==========
Write-Host "📦 Configuration Frontend..." -ForegroundColor Cyan

Set-Location Front_app

# Vérifier package.json
if (-not (Test-Path "package.json")) {
    Write-Host "❌ package.json non trouvé" -ForegroundColor Red
    exit 1
}

# Installer les dépendances
Write-Host "   → Installation des dépendances npm..." -ForegroundColor Yellow
npm install

# Vérifier i18next
if (npm list i18next 2>$null | Select-String "i18next") {
    Write-Host "   ✅ i18next et react-i18next installés" -ForegroundColor Green
}

# Vérifier la structure
Write-Host "   → Vérification de la structure..." -ForegroundColor Yellow
if (-not (Test-Path "src\i18n\locales")) {
    New-Item -ItemType Directory -Path "src\i18n\locales" -Force | Out-Null
}

# Vérifier les fichiers de traduction
foreach ($lang in @("en", "de", "es")) {
    $filepath = "src\i18n\locales\$lang.json"
    if (Test-Path $filepath) {
        Write-Host "   ✅ $lang.json présent" -ForegroundColor Green
    } else {
        Write-Host "   ⚠️  $lang.json manquant" -ForegroundColor Yellow
    }
}

# Créer .env.local s'il n'existe pas
if (-not (Test-Path ".env.local")) {
    Write-Host "   → Création de .env.local..." -ForegroundColor Yellow
    @'
VITE_DEEPL_API_KEY=your_deepl_api_key_here
VITE_DEEPL_API_URL=https://api-free.deepl.com/v1
VITE_API_URL=http://localhost:8000
VITE_GEOIP_URL=https://ipapi.co/json/
'@ | Out-File -Encoding UTF8 ".env.local"
    Write-Host "   ⚠️  .env.local créé - Ajoutez votre clé API DeepL" -ForegroundColor Yellow
} else {
    Write-Host "   ✅ .env.local existe" -ForegroundColor Green
}

Set-Location ..
Write-Host "✅ Frontend configuré" -ForegroundColor Green
Write-Host ""

# ========== BACKEND ==========
Write-Host "🐘 Configuration Backend..." -ForegroundColor Cyan

Set-Location Back_app

# Vérifier composer.json
if (-not (Test-Path "composer.json")) {
    Write-Host "❌ composer.json non trouvé" -ForegroundColor Red
    exit 1
}

# Installer les dépendances
Write-Host "   → Installation des dépendances composer..." -ForegroundColor Yellow
composer install

# Vérifier la clé API dans .env
if (Select-String -Path ".env" -Pattern "DEEPL_API_KEY" -Quiet) {
    Write-Host "   ✅ DEEPL_API_KEY trouvée dans .env" -ForegroundColor Green
} else {
    Write-Host "   ⚠️  DEEPL_API_KEY non trouvée - Vérifier .env" -ForegroundColor Yellow
}

# Vérifier que les fichiers PHP existent
foreach ($file in @("app\Services\DeepLTranslationService.php", "app\Http\Controllers\Api\TranslationController.php")) {
    if (Test-Path $file) {
        Write-Host "   ✅ $file présent" -ForegroundColor Green
    } else {
        Write-Host "   ❌ $file manquant" -ForegroundColor Red
    }
}

Set-Location ..
Write-Host "✅ Backend configuré" -ForegroundColor Green
Write-Host ""

# ========== VÉRIFICATIONS FINALES ==========
Write-Host "🔍 Vérifications finales..." -ForegroundColor Cyan
Write-Host ""

Write-Host "✅ Configuration terminée!" -ForegroundColor Green
Write-Host ""
Write-Host "📋 Prochaines étapes:" -ForegroundColor Yellow
Write-Host "  1. Frontend:  cd Front_app && npm run dev" -ForegroundColor White
Write-Host "  2. Backend:   cd Back_app && php artisan serve" -ForegroundColor White
Write-Host "  3. Tester:    Visiter http://localhost:5173" -ForegroundColor White
Write-Host ""
Write-Host "📖 Documentation:" -ForegroundColor Yellow
Write-Host "  - SETUP_CHECKLIST.md" -ForegroundColor White
Write-Host "  - TRANSLATION_SETUP_GUIDE.md" -ForegroundColor White
Write-Host "  - INTEGRATION_EXAMPLES.js" -ForegroundColor White
Write-Host ""

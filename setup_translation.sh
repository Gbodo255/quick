#!/bin/bash

# ========================================
# Script de configuration du système de traduction
# Exécuter: bash setup_translation.sh
# ========================================

set -e  # Exit on error

echo "🚀 Configuration du système de traduction..."
echo ""

# Vérifier Node.js
if ! command -v node &> /dev/null; then
    echo "❌ Node.js n'est pas installé"
    exit 1
fi

# Vérifier Composer
if ! command -v composer &> /dev/null; then
    echo "❌ Composer n'est pas installé"
    exit 1
fi

echo "✅ Outils requis détectés"
echo ""

# ========== FRONTEND ==========
echo "📦 Configuration Frontend..."

cd Front_app

# Vérifier package.json
if [ ! -f "package.json" ]; then
    echo "❌ package.json non trouvé"
    exit 1
fi

# Installer les dépendances
echo "   → Installation des dépendances npm..."
npm install --silent

# Vérifier que i18next est présent
if npm list i18next react-i18next 2>/dev/null | grep -q "i18next"; then
    echo "   ✅ i18next et react-i18next installés"
else
    echo "   → Installation de i18next et react-i18next..."
    npm install i18next react-i18next --silent
fi

# Vérifier la structure des dossiers
echo "   → Vérification de la structure..."
mkdir -p src/i18n/locales

# Vérifier que les fichiers de traduction existent
for lang in en de es; do
    if [ ! -f "src/i18n/locales/${lang}.json" ]; then
        echo "   ⚠️  src/i18n/locales/${lang}.json manquant"
    else
        echo "   ✅ ${lang}.json présent"
    fi
done

# Créer .env.local s'il n'existe pas
if [ ! -f ".env.local" ]; then
    echo "   → Création de .env.local..."
    cat > .env.local << 'EOF'
VITE_DEEPL_API_KEY=your_deepl_api_key_here
VITE_DEEPL_API_URL=https://api-free.deepl.com/v1
VITE_API_URL=http://localhost:8000
VITE_GEOIP_URL=https://ipapi.co/json/
EOF
    echo "   ⚠️  .env.local créé - Veuillez ajouter votre clé API DeepL"
else
    echo "   ✅ .env.local existe"
fi

cd ..
echo "✅ Frontend configuré"
echo ""

# ========== BACKEND ==========
echo "🐘 Configuration Backend..."

cd Back_app

# Vérifier composer.json
if [ ! -f "composer.json" ]; then
    echo "❌ composer.json non trouvé"
    exit 1
fi

# Installer les dépendances
echo "   → Installation des dépendances composer..."
composer install --quiet

# Vérifier la clé API dans .env
if grep -q "DEEPL_API_KEY" .env; then
    echo "   ✅ DEEPL_API_KEY trouvée dans .env"
else
    echo "   ⚠️  DEEPL_API_KEY non trouvée - Vérifier .env"
fi

# Vérifier que les fichiers PHP existent
for file in "app/Services/DeepLTranslationService.php" "app/Http/Controllers/Api/TranslationController.php"; do
    if [ ! -f "$file" ]; then
        echo "   ❌ $file manquant"
    else
        echo "   ✅ $file présent"
    fi
done

cd ..
echo "✅ Backend configuré"
echo ""

# ========== VÉRIFICATIONS FINALES ==========
echo "🔍 Vérifications finales..."
echo ""

echo "✅ Configuration terminée!"
echo ""
echo "📋 Prochaines étapes:"
echo "  1. Frontend:  cd Front_app && npm run dev"
echo "  2. Backend:   cd Back_app && php artisan serve"
echo "  3. Tester:    Visiter http://localhost:5173"
echo ""
echo "📖 Documentation:"
echo "  - SETUP_CHECKLIST.md"
echo "  - TRANSLATION_SETUP_GUIDE.md"
echo "  - INTEGRATION_EXAMPLES.js"
echo ""
echo "🎯 Vérifier TRANSLATION_SETUP_GUIDE.md pour plus de détails"
echo ""

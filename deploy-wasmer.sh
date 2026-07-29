#!/bin/bash
# 🚀 One-Click Deploy GymFit ke Wasmer Edge
# CARA PAKAI: bash deploy-wasmer.sh
# ==========================================

set -e

# Tambahkan current directory ke PATH
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
export PATH="$SCRIPT_DIR:$PATH"

echo "╔══════════════════════════════════════╗"
echo "║   🚀 DEPLOY GYMFIT TO WASHER EDGE   ║"
echo "╚══════════════════════════════════════╝"
echo ""

# Step 1: Install Wasmer CLI (kalau belum ada)
if ! command -v wasmer &> /dev/null; then
    echo "📦 Downloading Wasmer CLI..."
    if [ -f "wasmer.exe" ]; then
        echo "✅ wasmer.exe already downloaded"
    else
        curl -L "https://github.com/wasmerio/wasmer/releases/download/v7.2.1/wasmer-windows.exe" -o wasmer.exe
        chmod +x wasmer.exe
        echo "✅ Wasmer CLI downloaded!"
    fi
    WASMER="$SCRIPT_DIR/wasmer.exe"
else
    WASMER="wasmer"
    echo "✅ Wasmer CLI sudah terinstall"
fi

echo ""
echo "🔑 Step 1: Login ke Wasmer"
echo "   > $WASMER login"
echo "   (akan buka browser untuk login pake GitHub)"
echo ""
echo "📤 Step 2: Deploy aplikasi"
echo "   > $WASMER deploy"
echo "   (pilih nama dan namespace, tunggu build selesai)"
echo ""

echo "╔══════════════════════════════════════╗"
echo "║   📋 SETELAH DEPLOY                   ║"
echo "╚══════════════════════════════════════╝"
echo ""
echo "1️⃣  Buka Wasmer Dashboard > Settings > Secrets"
echo "   Copy dari file .env.wasmer"
echo ""
echo "2️⃣  Settings > Databases > Create MySQL"
echo "   Catat credentials-nya"
echo ""
echo "3️⃣  Generate APP_KEY baru:"
echo "   > php artisan key:generate --show"
echo "   Lalu update di Wasmer Secrets"
echo ""
echo "4️⃣  Akses URL Migration:"
echo "   https://APP-NAME.wasmer.app/wasmer/migrate/TOKEN"
echo "   (TOKEN: gymfit-secret + MD5 APP_KEY yang baru)"
echo ""
echo "5️⃣  Daftar cron-job.org, set job tiap jam:"
echo "   https://APP-NAME.wasmer.app/wasmer/scheduler/TOKEN"
echo ""
echo "🎉 SELESAI! GymFit SUDAH ONLINE!"
echo "========================================"

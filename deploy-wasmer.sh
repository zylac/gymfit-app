#!/bin/bash
# 🚀 One-Click Deploy GymFit ke Wasmer Edge
# CARA PAKAI: bash deploy-wasmer.sh
# ==========================================

echo "╔══════════════════════════════════════╗"
echo "║   🚀 DEPLOY GYMFIT TO WASHER EDGE   ║"
echo "╚══════════════════════════════════════╝"
echo ""

# Step 1: Install Wasmer CLI (kalau belum ada)
if ! command -v wasmer &> /dev/null; then
    echo "📦 Installing Wasmer CLI..."
    curl -L "https://github.com/wasmerio/wasmer/releases/download/v7.2.1/wasmer-windows.exe" -o wasmer.exe
    echo "✅ Wasmer CLI downloaded! Add to PATH or run from current directory."
    echo ""
    echo "🔑 Run: wasmer login"
    echo "   (akan buka browser untuk login pake GitHub)"
    echo ""
    echo "📤 Run: wasmer deploy"
    echo "   (pilih nama app, tunggu build selesai)"
    echo ""
else
    echo "✅ Wasmer CLI sudah terinstall"
    echo ""
    echo "🔑 Step 1: Login ke Wasmer"
    echo "   > wasmer login"
    echo ""
    echo "📤 Step 2: Deploy aplikasi"
    echo "   > wasmer deploy"
    echo ""
fi

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
echo "3️⃣  Akses URL Migration:"
echo "   https://APP-NAME.wasmer.app/wasmer/migrate/TOKEN"
echo "   (TOKEN = gymfit-secret-MD5_APP_KEY)"
echo ""
echo "4️⃣  Daftar cron-job.org, set job tiap jam:"
echo "   https://APP-NAME.wasmer.app/wasmer/scheduler/TOKEN"
echo ""
echo "🎉 SELESAI! GymFit SUDAH ONLINE!"
echo "========================================"

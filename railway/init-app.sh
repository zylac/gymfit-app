#!/bin/bash
set -e

echo "🚀 GymFit - Railway Startup Script"

echo "🔧 Caching config..."
php artisan config:cache

echo "🗺️ Caching routes..."
php artisan route:cache

echo "🎨 Caching views..."
php artisan view:cache

echo "📢 Caching events..."
php artisan event:cache

echo "📦 Running migrations..."
php artisan migrate --force

echo "✅ GymFit deployment complete!"

exec "$@"

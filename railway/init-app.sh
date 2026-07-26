#!/bin/bash

echo "🚀 GymFit - Railway Startup Script"

echo "📦 Running migrations..."
php artisan migrate --force

echo "🔧 Caching config..."
php artisan config:cache

echo "🗺️ Caching routes..."
php artisan route:cache

echo "🎨 Caching views..."
php artisan view:cache

echo "🔗 Creating storage link..."
php artisan storage:link

echo "✅ GymFit deployment complete!"

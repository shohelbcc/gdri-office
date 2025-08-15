#!/bin/bash

# GDRI Laravel Application Deployment Script
# Run this script on your server after git pull

echo "🚀 Starting GDRI Application Deployment..."

# Update application from Git
echo "📥 Pulling latest changes from Git..."
git pull origin master

# Install/Update Composer dependencies (production optimized)
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Clear and cache configuration for better performance
echo "🔧 Optimizing Laravel configuration..."
php artisan config:clear
php artisan config:cache
php artisan route:clear
php artisan route:cache
php artisan view:clear
php artisan view:cache

# Run database migrations
echo "🗃️ Running database migrations..."
php artisan migrate --force

# Clear and rebuild application cache
echo "🚀 Rebuilding application cache..."
php artisan cache:clear
php artisan storage:link

# Set proper permissions
echo "🔐 Setting file permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/

# Build frontend assets (if using Vite)
echo "🎨 Building frontend assets..."
npm install --production
npm run build

echo "✅ Deployment completed successfully!"
echo "🌐 Your GDRI application is now live!"

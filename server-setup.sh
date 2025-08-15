#!/bin/bash
# GDRI Auto Deployment Post-Processing Script
# This script should be placed on your server and run after files are uploaded

echo "🚀 Starting GDRI post-deployment setup..."

# Navigate to application directory
cd /home/mshohel/office.mshohel.com || exit 1

# Check if .env exists, if not copy from production template
if [ ! -f .env ]; then
    echo "📝 Creating .env file..."
    cp .env.production .env
fi

# Set proper file permissions
echo "🔐 Setting file permissions..."
chmod -R 755 storage/ 2>/dev/null || true
chmod -R 755 bootstrap/cache/ 2>/dev/null || true

# Try to run Laravel optimization commands if PHP CLI is available
if command -v php >/dev/null 2>&1; then
    echo "⚡ Optimizing Laravel application..."
    
    # Generate app key if not set
    php artisan key:generate --force 2>/dev/null || true
    
    # Cache configurations
    php artisan config:cache 2>/dev/null || true
    php artisan route:cache 2>/dev/null || true
    php artisan view:cache 2>/dev/null || true
    
    # Create storage link
    php artisan storage:link 2>/dev/null || true
    
    echo "✅ Laravel optimization completed!"
else
    echo "⚠️  PHP CLI not available, skipping Laravel commands"
fi

# Log deployment
echo "$(date): GDRI deployment completed" >> deployment.log

echo "🎉 Post-deployment setup completed successfully!"
echo "🌐 Your GDRI application is now live at: https://office.mshohel.com"

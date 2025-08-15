# GDRI Laravel Application - Server Deployment Guide

## 🚀 Complete Deployment Instructions

### Prerequisites
- Linux server with PHP 8.1+ এবং MySQL
- Nginx অথবা Apache web server
- Composer installed
- Node.js এবং npm installed
- Git installed

### Step 1: Server Setup

```bash
# Update server packages
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install nginx mysql-server php8.1-fpm php8.1-mysql php8.1-xml php8.1-gd php8.1-curl php8.1-mbstring php8.1-zip unzip git curl -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### Step 2: Clone Repository

```bash
# Navigate to web directory
cd /var/www

# Clone your repository
sudo git clone https://github.com/shohelbcc/gdri-office.git gdri
cd gdri

# Set ownership
sudo chown -R www-data:www-data /var/www/gdri
```

### Step 3: Environment Configuration

```bash
# Copy production environment file
cp .env.production .env

# Edit .env with your production settings
sudo nano .env
```

**Update these values in .env:**
- `APP_URL=https://yourdomain.com`
- `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- Email settings if different

### Step 4: Install Dependencies

```bash
# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install Node dependencies and build assets
npm install --production
npm run build

# Generate application key (if not set)
php artisan key:generate
```

### Step 5: Database Setup

```bash
# Create database
mysql -u root -p
CREATE DATABASE gdri_production;
CREATE USER 'gdri_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON gdri_production.* TO 'gdri_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Run migrations
php artisan migrate --force
```

### Step 6: Configure Web Server

#### For Nginx:

Create `/etc/nginx/sites-available/gdri`:

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/gdri/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/gdri /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

### Step 7: Set Permissions

```bash
# Set proper permissions
sudo chmod -R 755 /var/www/gdri/storage
sudo chmod -R 755 /var/www/gdri/bootstrap/cache
sudo chown -R www-data:www-data /var/www/gdri/storage
sudo chown -R www-data:www-data /var/www/gdri/bootstrap/cache
```

### Step 8: Optimize Application

```bash
# Cache configurations for better performance
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 9: SSL Certificate (Optional but Recommended)

```bash
# Install Certbot for Let's Encrypt
sudo apt install certbot python3-certbot-nginx

# Get SSL certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

## 🔄 Future Deployments

After initial setup, use the provided `deploy.sh` script:

```bash
# Make deploy script executable
chmod +x deploy.sh

# Run deployment
./deploy.sh
```

## 🛡️ Security Checklist

- [ ] Set `APP_DEBUG=false` in production
- [ ] Use strong database passwords
- [ ] Configure firewall (ufw)
- [ ] Regular backups
- [ ] Monitor error logs
- [ ] Keep system updated

## 📊 Monitoring Commands

```bash
# Check application logs
tail -f storage/logs/laravel.log

# Check web server status
sudo systemctl status nginx

# Check PHP-FPM status
sudo systemctl status php8.1-fpm

# Monitor system resources
htop
```

## 🆘 Troubleshooting

### Common Issues:

1. **Permission errors**: Check storage and cache folder permissions
2. **500 errors**: Check Laravel logs and web server error logs
3. **Database connection**: Verify database credentials in .env
4. **Assets not loading**: Run `npm run build` and check public folder

### Logs locations:
- Laravel: `/var/www/gdri/storage/logs/laravel.log`
- Nginx: `/var/log/nginx/error.log`
- PHP: `/var/log/php8.1-fpm.log`

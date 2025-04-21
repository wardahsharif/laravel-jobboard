#!/usr/bin/env bash

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Set Laravel permissions
chmod -R 775 storage bootstrap/cache

# Generate app key if needed
php artisan key:generate

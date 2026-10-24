# Gunakan image resmi PHP 8.2 yang sudah lengkap dengan Nginx khusus Laravel
FROM serversideup/php:8.2-fpm-nginx

# Set direktori kerja
WORKDIR /var/www/html

# Salin seluruh source code Laravel
COPY --chown=www-data:www-data . .

# Berikan izin ke storage dan bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Install dependency Laravel via Composer
RUN composer install --no-dev --optimize-autoloader

# Expose port yang digunakan oleh Render
ENV PORT=8080
EXPOSE 8080

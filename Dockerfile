FROM php:8.2-apache

# Copy all files into Apache root
COPY . /var/www/html/

# Enable mod_rewrite (if using routing)
RUN a2enmod rewrite

# Set correct permissions (optional but safe)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

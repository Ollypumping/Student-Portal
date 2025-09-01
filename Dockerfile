# Use official PHP image with Apache
FROM php:8.2-apache

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Enable Apache mod_rewrite for clean URLs
RUN a2enmod rewrite

# Set working directory inside container
WORKDIR /var/www/html

# Copy all project files into container
COPY . /var/www/html/

# Set proper permissions for uploads folder
RUN chown -R www-data:www-data /var/www/html/uploads \
    && chmod -R 755 /var/www/html/uploads

# Configure Apache to allow .htaccess overrides (for MVC routing if needed)
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]

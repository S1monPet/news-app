# Dockerfile za news-app
# Osnova: php:8.2-apache
FROM php:8.2-apache

LABEL maintainer="29913"
LABEL description="News App - PHP MVC aplikacija"

# Namestimo samo mysqli razširitev (potrebna za connection.php)
RUN docker-php-ext-install mysqli

# Vklopimo mod_rewrite za .htaccess
RUN a2enmod rewrite

# Dovolimo .htaccess override
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Kopiramo aplikacijo
WORKDIR /var/www/html
COPY . /var/www/html/

# Nastavimo pravice
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80
CMD ["apache2-foreground"]
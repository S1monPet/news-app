# ============================================================
# Dockerfile za news-app
# Osnova: php:8.2-apache (uraden PHP obraz z Apache strežnikom)
# Aplikacija: PHP MVC news-app z MySQL bazo
# Avtor: 29913
# ============================================================

# Uporabimo uraden PHP 8.2 obraz z vgrajenim Apache strežnikom
FROM php:8.2-apache

# Metapodatki slike
LABEL maintainer="29913"
LABEL description="News App - PHP MVC aplikacija za upravljanje novic"
LABEL version="1.0"

# Namestimo potrebne sistemske odvisnosti in PHP razširitve
# mysqli: potrebna za povezavo z MySQL bazo (razred Db v connection.php)
# pdo_mysql: alternativna PDO razširitev
# mbstring: za delo z UTF-8 nizi
RUN apt-get update && apt-get install -y \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        zip \
        unzip \
    && docker-php-ext-install mysqli pdo_mysql mbstring \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Vklopimo Apache mod_rewrite (potreben za .htaccess preusmeritve v news-app)
RUN a2enmod rewrite

# Nastavimo Apache, da upošteva .htaccess datoteke v DocumentRoot
# Brez tega direktiva AllowOverride None bi preprečila delovanje .htaccess
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Nastavimo delovni imenik na Apache DocumentRoot
WORKDIR /var/www/html

# Kopiramo celotno aplikacijo v vsebnik
# Izjeme (npr. node_modules, .git) definiramo v .dockerignore
COPY . /var/www/html/

# Nastavimo ustrezne lastništvo datotek za Apache (www-data uporabnik)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Izpostavimo vrata 80 (standardna HTTP vrata Apache strežnika)
EXPOSE 80

# Privzeti ukaz: zaženemo Apache v ospredju (foreground)
# Opcija -D FOREGROUND prepreči, da bi se Apache zagnal v ozadju in zabojnik takoj zaprl
CMD ["apache2-foreground"]

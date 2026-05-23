FROM php:8.2-apache

# Installer les extensions PHP nécessaires pour Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Activer le module de réécriture d'Apache (indispensable pour les routes Laravel)
RUN a2enmod rewrite

# Changer la racine d'Apache vers le dossier /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Installer Composer
COPY --from=getcomposer/composer:latest /usr/bin/composer /usr/bin/composer

# Copier le projet dans le conteneur
WORKDIR /var/www/html
COPY . .

# Installer les dépendances Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Donner les bonnes permissions aux dossiers de stockage
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
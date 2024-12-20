FROM php:8.1-apache

# Instalar extensões necessárias
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Habilitar o mod_rewrite do Apache
RUN a2enmod rewrite

# Configurar Apache para permitir uso de .htaccess
RUN echo '<Directory /var/www/html>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/laravel.conf && \
    a2enconf laravel

# Copiar arquivos do Laravel
COPY . /var/www/html

# Definir o diretório de trabalho
WORKDIR /var/www/html

# Permissões de diretórios
RUN chmod -R 775 storage bootstrap/cache

# Expor a porta padrão do Apache
EXPOSE 80

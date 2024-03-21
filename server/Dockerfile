# Use a imagem oficial do PHP 8.2 FPM
FROM php:8.2-fpm

# Instale as dependências necessárias para o PDO e MySQL
RUN apt-get update \
    && apt-get install -y \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libzip-dev \
        libonig-dev \
        zlib1g-dev \
        libicu-dev \
        libxml2-dev \
        libxslt-dev \
        mariadb-client \
    && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        mysqli \
        intl \
        gd \
        zip \
        opcache \
        bcmath \
        xsl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Configure a extensão PDO MySQL
RUN docker-php-ext-enable pdo_mysql

# Configure o PHP para expor erros para debug
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
RUN sed -i 's/display_errors = Off/display_errors = On/' "$PHP_INI_DIR/php.ini"

# Defina o timezone para evitar avisos de data / hora
RUN echo "date.timezone = America/Sao_Paulo" >> "$PHP_INI_DIR/php.ini"

# Defina o diretório de trabalho padrão
WORKDIR /var/www/html

# Exponha a porta 9000 para conexões PHP-FPM
EXPOSE 9000
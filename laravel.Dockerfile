# Use a imagem oficial do PHP com FPM baseado no Alpine
FROM php:8.3-fpm-alpine3.20

# Instalar dependências necessárias
RUN apk --no-cache add \
    curl \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libwebp-dev \
    libxpm-dev \
    libxml2-dev \
    libmcrypt-dev \
    oniguruma-dev \
    libxslt-dev \
    libzip \
    libpng \
    libjpeg-turbo \
    freetype \
    libwebp \
    libxpm \
    libmcrypt \
    libxslt \
    icu-dev \
    imagemagick \
    imagemagick-dev \
    bash \
    nodejs \
    npm \
    git \
    openssh-client \
    supervisor \
    autoconf \
    g++ \
    make \
    pkgconf \
    oniguruma-dev \
    poppler-utils \
    tesseract-ocr \
    tesseract-ocr-data-por \
    ghostscript \
    $PHPIZE_DEPS

# Instalar extensões do PHP
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install \
    pdo pdo_mysql zip opcache mysqli mbstring exif pcntl bcmath soap intl xsl gd

# Instalar Redis
RUN pecl install redis && docker-php-ext-enable redis

# Instalar PCOV
RUN pecl install pcov && docker-php-ext-enable pcov

# Instalar Imagick
RUN pecl install imagick && docker-php-ext-enable imagick

# Habilitar PCOV no php.ini
RUN echo "pcov.enabled=1" >> /usr/local/etc/php/conf.d/pcov.ini && \
    echo "pcov.directory=/" >> /usr/local/etc/php/conf.d/pcov.ini

# Definir configurações recomendadas do PHP
RUN { \
    echo 'upload_max_filesize=100M'; \
    echo 'post_max_size=100M'; \
} > /usr/local/etc/php/conf.d/uploads.ini

# Aumentar o limite de memória para 512MB
RUN echo "memory_limit=512M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Adicionar usuário www-data
RUN addgroup -g 1000 -S www-data || true && \
    adduser -u 1000 -S www-data -G www-data || true

# Instalar Composer globalmente
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Limpar pacotes desnecessários para reduzir o tamanho da imagem
RUN apk del libzip-dev libpng-dev libjpeg-turbo-dev freetype-dev libwebp-dev libxpm-dev libxml2-dev libmcrypt-dev libxslt-dev autoconf g++ make

# Definir diretório de trabalho
WORKDIR /var/www/html

# Ajustar permissões
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Atualizar configuração do PHP-FPM para escutar na porta 9000
RUN sed -i 's/listen = 127.0.0.1:9000/listen = 9000/' /usr/local/etc/php-fpm.d/www.conf

# Expor a porta do PHP-FPM
EXPOSE 9000

# Iniciar o PHP-FPM
CMD ["php-fpm"]

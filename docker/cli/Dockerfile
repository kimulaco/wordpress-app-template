FROM php:8.4-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    mariadb-client \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required by WordPress
RUN docker-php-ext-install \
    mysqli \
    pdo_mysql \
    gd \
    zip \
    mbstring \
    xml \
    exif

# Install WP-CLI
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && chmod +x wp-cli.phar \
    && mv wp-cli.phar /usr/local/bin/wp

# Install Composer
COPY --from=composer/composer:2.8.12 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /workspace

# Verify WP-CLI installation
RUN wp --info || true

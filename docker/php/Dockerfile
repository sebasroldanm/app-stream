FROM php:8.4-cli-alpine

# Install system dependencies
RUN apk add --no-cache \
    $PHPIZE_DEPS \
    git \
    mysql-client \
    curl \
    libxml2-dev \
    oniguruma-dev \
    icu-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    postgresql-dev \
    linux-headers \
    && rm -rf /var/cache/apk/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    mbstring \
    pdo \
    pdo_mysql \
    pdo_pgsql \
    xml \
    zip \
    intl \
    gd \
    exif \
    pcntl \
    bcmath \
    opcache \
    sockets

# Install Composer 2.x
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Redis and Swoole extensions
RUN pecl install redis swoole \
    && docker-php-ext-enable redis swoole

# Configure PHP settings optimized for PHP 8.4 and Octane
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/octane.ini \
    && echo "opcache.enable_cli=1" >> /usr/local/etc/php/conf.d/octane.ini \
    && echo "opcache.memory_consumption=256" >> /usr/local/etc/php/conf.d/octane.ini \
    && echo "opcache.interned_strings_buffer=16" >> /usr/local/etc/php/conf.d/octane.ini \
    && echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/octane.ini \
    && echo "opcache.revalidate_freq=60" >> /usr/local/etc/php/conf.d/octane.ini \
    && echo "opcache.fast_shutdown=1" >> /usr/local/etc/php/conf.d/octane.ini \
    && echo "opcache.jit_buffer_size=100M" >> /usr/local/etc/php/conf.d/octane.ini \
    && echo "opcache.jit=tracing" >> /usr/local/etc/php/conf.d/octane.ini \
    && echo "memory_limit=512M" >> /usr/local/etc/php/conf.d/octane.ini \
    && echo "max_execution_time=300" >> /usr/local/etc/php/conf.d/octane.ini

# Create user for running the application
RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S www -G www

# Set working directory
WORKDIR /var/www/html

# Change ownership of the working directory
RUN chown -R www:www /var/www/html

# Switch to non-root user
USER www

# Expose port 8000 for Octane
EXPOSE 8000

# Default command for Octane
CMD ["php", "artisan", "octane:start", "--host=0.0.0.0", "--port=8000"]
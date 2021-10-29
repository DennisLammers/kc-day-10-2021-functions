FROM alpine:latest

WORKDIR /var/www/

# Essentials
RUN echo "UTC" > /etc/timezone
RUN apk add --no-cache zip unzip curl nginx openrc

# Installing bash
RUN apk add bash
RUN sed -i 's/bin\/ash/bin\/bash/g' /etc/passwd

# Installing PHP
RUN apk add --no-cache php8 \
    php8-cli \
    php8-common \
    php8-curl \
    php8-dom \
    php8-iconv \
    php8-fpm \
    php8-fileinfo \
    php8-json \
    php8-mbstring \
    php8-openssl \
    php8-pdo \
    php8-pdo_mysql \
    php8-phar \
    php8-session \
    php8-simplexml \
    php8-tokenizer \
    php8-xml \
    php8-xmlwriter \
    php8-zip

# ---
# These extensions are optional, enable when required
#
#RUN apk add --no-cache php8-pecl-redis
#RUN apk add --no-cache php8-gd
#
# Production env only!
#RUN apk add --no-cache php8-opcache
#
# ---

RUN ln -s /usr/bin/php8 /usr/bin/php

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# Configure PHP
RUN mkdir -p /run/php/
RUN touch /run/php/php8.0-fpm.pid
COPY .docker/alpine/php-fpm8/www.conf /etc/php8/php-fpm.d/www.conf

# Configure nginx
COPY .docker/alpine/nginx/nginx.conf /etc/nginx/
COPY .docker/alpine/nginx/nginx-laravel.conf /etc/nginx/modules

RUN mkdir -p /run/nginx/
RUN touch /run/nginx/nginx.pid

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

# Copy source
COPY . .

# Add user
RUN addgroup -S king && adduser -S king -G king -u 1000
RUN chown king:king /var/www/storage /var/www/bootstrap && chmod -R 755 /var/www/storage
RUN echo 'alias pa="php artisan"' >> ~/.bashrc
RUN echo 'alias phpunit="./vendor/bin/phpunit"' >> ~/.bashrc
RUN echo 'alias refresh="pa migrate:fresh"' >> ~/.bashrc

COPY .docker/local/entrypoint.sh /home/king/entrypoint.sh
RUN chmod +x /home/king/entrypoint.sh

EXPOSE $PORT
ENTRYPOINT ["/home/king/entrypoint.sh"]

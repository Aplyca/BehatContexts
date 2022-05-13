# Building Production image
FROM php:8.1.5-cli-alpine as base

# Installing PHP Composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin --version=2.3.4 --filename=composer   

WORKDIR /app

ENV COMPOSER_ALLOW_SUPERUSER=1
ENV COMPOSER_CACHE_DIR=/dev/null
ENV COMPOSER_MEMORY_LIMIT=-1
ENV COMPOSER_PROCESS_TIMEOUT=3600

COPY src ./src
COPY composer.json ./

RUN composer validate --no-check-all --strict && \
    composer install --prefer-dist --no-autoloader --no-interaction --no-dev --no-progress && \
    composer dump-autoload --optimize --no-interaction --classmap-authoritative

LABEL maintainer="Aplyca" description="Aplyca Behat Contexts"

#ENTRYPOINT ["/bin/ash"]
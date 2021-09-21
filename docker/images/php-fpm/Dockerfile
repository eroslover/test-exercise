FROM php:8-fpm

ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

# Configure non-root user.
RUN userdel -f www-data &&\
    if getent group www-data ; then groupdel www-data; fi &&\
    groupadd -g ${PGID} www-data &&\
    useradd -l -u ${PUID} -g www-data www-data &&\
    install -d -m 0755 -o www-data -g www-data /home/www-data &&\
    chown --changes --silent --no-dereference --recursive \
          --from=33:33 ${PUID}:${PGID} \
        /home/www-data

# Install base extensions
RUN apt-get update && apt-get install -yqq \
        apt-utils \
        cron \
        libbz2-dev \
        libfreetype6-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libpspell-dev \
        libxml2-dev \
        libzip-dev \
        zip \
        unzip \
    && pecl install mcrypt-1.0.4 xdebug-3.0.0 \
    && docker-php-ext-enable mcrypt xdebug \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) bcmath bz2 calendar dba exif gd gettext intl mysqli pcntl pspell pdo_mysql \
        shmop soap sockets sysvmsg sysvsem sysvshm zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy xdebug configuration for remote debugging
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Install Supervisor:
RUN apt-get update && apt-get install -y supervisor
COPY ./supervisor/ /etc/supervisor/conf.d/

# Crontab
COPY ./crontab /etc/cron.d
RUN chmod -R 644 /etc/cron.d

COPY ./crontab/cron.sh /usr/bin/cron.sh
RUN chmod +x /usr/bin/cron.sh

COPY ./laravel.pool.conf /usr/local/etc/php-fpm.d/

USER www-data

COPY ./entry_point.sh /entry_point.sh
ENTRYPOINT ["/entry_point.sh"]

USER root

# Clean up
RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
    rm /var/log/lastlog /var/log/faillog

WORKDIR /var/www/project

CMD ["php-fpm"]

EXPOSE 9000
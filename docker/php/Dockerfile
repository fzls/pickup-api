FROM php:7-fpm
MAINTAINER Chen Ji <fzls.zju@gmail.com>

# use NetEase's debian:jessie mirror
#COPY ./sources.list.jessie /etc/apt/sources.list

# install tools
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
        apt-utils \
        curl \
        libmemcached-dev \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng12-dev \
        libfreetype6-dev \
        libssl-dev \
        libmcrypt-dev \
        git

# install extentions
RUN docker-php-ext-install mcrypt
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-configure gd \
        --enable-gd-native-ttf \
        --with-jpeg-dir=/usr/lib \
        --with-freetype-dir=/usr/include/freetype2 && \
    docker-php-ext-install gd
RUN    docker-php-ext-install zip # useful for composer

# install composer
##RUN curl --tlsv1 --http1.0 -o /usr/local/bin/composer \
##            https://getcomposer.org/download/1.2.2/composer.phar
# due to network , use downloaded local version
COPY ./composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer

####!!!!!!!--------DELETE phpredis after test connecting with redis
# install phpredis extension
COPY ./phpredis-3.0.0.tar.gz /tmp/redis.tar.gz
RUN tar xfz /tmp/redis.tar.gz \
    && rm -r /tmp/redis.tar.gz \
    && mkdir -p /usr/src/php/ext/ \
    && mv phpredis-3.0.0/ /usr/src/php/ext/redis \
    && docker-php-ext-install redis

# copy from https://github.com/laradock/laradock/blob/master/php-fpm/Dockerfile-70
#####################################
# xDebug:
#####################################

ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    # Install the xdebug extension
    pecl install xdebug && \
    docker-php-ext-enable xdebug \
;fi

# Copy xdebug configration for remote debugging
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

#####################################
# PHP Memcached:
#####################################

ARG INSTALL_MEMCACHED=false
RUN if [ ${INSTALL_MEMCACHED} = true ]; then \
    # Install the php memcached extension
    curl -L -o /tmp/memcached.tar.gz "https://github.com/php-memcached-dev/php-memcached/archive/php7.tar.gz" \
    && mkdir -p memcached \
    && tar -C memcached -zxvf /tmp/memcached.tar.gz --strip 1 \
    && ( \
        cd memcached \
        && phpize \
        && ./configure \
        && make -j$(nproc) \
        && make install \
    ) \
    && rm -r memcached \
    && rm /tmp/memcached.tar.gz \
    && docker-php-ext-enable memcached \
;fi

#####################################
# Opcache:
#####################################
ARG INSTALL_OPCACHE=false
RUN if [ ${INSTALL_OPCACHE} = true ]; then \
    docker-php-ext-install opcache && \
    docker-php-ext-enable opcache \
;fi

# Copy opcache configration
COPY ./opcache.ini /usr/local/etc/php/conf.d/opcache.ini
#
#--------------------------------------------------------------------------
# Final Touch
#--------------------------------------------------------------------------
#

ADD ./laravel.ini /usr/local/etc/php/conf.d
ADD ./laravel.pool.conf /usr/local/etc/php-fpm.d/

RUN rm -r /var/lib/apt/lists/*

RUN usermod -u 1000 www-data

WORKDIR /var/www

CMD ["php-fpm"]

EXPOSE 9000

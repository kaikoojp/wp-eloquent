FROM alpine:edge

ENV WP_CLI_VERSION 1.4.0
ENV COMPOSER_VERSION 1.8.4

ADD https://php.codecasts.rocks/php-alpine.rsa.pub /etc/apk/keys/php-alpine.rsa.pub

RUN echo "http://dl-4.alpinelinux.org/alpine/edge/community" >> /etc/apk/repositories && \
    echo "http://dl-4.alpinelinux.org/alpine/edge/main" >> /etc/apk/repositories && \
    apk add --update --no-cache \
    bash \
    curl \
    git \
    less \
    freetype-dev libjpeg-turbo-dev libpng-dev \
    mariadb-client \
    php7 \
    php7-ftp \
    php7-gd \
    php7-openssl \
    php7-phar \
    php7-iconv \
    php7-mbstring \
    php7-mongodb \
    php7-mysqli \
    php7-xml \
    php7-dom \
    php7-xmlreader \
    php7-xmlwriter \
    php7-tokenizer \
    php7-zlib && \
    curl https://getcomposer.org/download/$COMPOSER_VERSION/composer.phar -o /usr/bin/composer && \
    chmod +x /usr/bin/composer

RUN composer create-project wp-cli/wp-cli:$WP_CLI_VERSION /usr/share/wp-cli --no-dev && \
    composer clear-cache

RUN ln -s /usr/share/wp-cli/bin/wp /usr/bin/wp

RUN rm -rf /tmp/src && \
    rm -rf /var/cache/apk/* && \
    rm -rf /root/.composer

WORKDIR /mnt

ENTRYPOINT ["/bin/bash"]
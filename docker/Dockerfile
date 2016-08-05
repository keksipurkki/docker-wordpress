#
# An Apache server with Wordpress
#

FROM php:5.6-apache

EXPOSE 80
EXPOSE 443

ENV HOSTNAME wordpress
ENV WORDPRESS_VERSION latest
ENV WORDPRESS_CORE https://wordpress.org/wordpress-${WORDPRESS_VERSION}.tar.gz
ENV WORDPRESS_CLI https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar
ENV COMPOSER https://getcomposer.org/composer.phar

ENV PHP_EXTENSIONS gmp mcrypt \
                   mongo apcu memcached \
                   raphf propro stomp \
                   pecl-http intl xsl \
                   imagick mysql

ENV PHP_EXTENSIONS_EXTRA bcmath mbstring soap \
                         bz2 calendar dba \
                         exif ftp gettext \
                         sockets shmop sysvmsg \
                         sysvsem sysvshm zip \
                         pdo_mysql wddx

RUN export DEBIAN_FRONTEND=noninteractive \
 && apt-get update \
 && apt-get -y install \
     less \
     git \
     libcurl4-openssl-dev \
     sudo \
     libgmp-dev \
     libmemcached-dev \
     libevent-dev \
     libmcrypt-dev \
     libxslt-dev \
     mysql-client \
     msmtp \
     libbz2-dev \
     libzip-dev \
     php-pear \
     php5-dev \
     screen \
     re2c \
     autossh \
     memcached \
     ssl-cert

# Configure PHP
COPY php.ini $PHP_INI_DIR/

# Get most of the PHP extensions from Debian repos
# Benefit: dependency handling
RUN export DEBIAN_FRONTEND=noninteractive \
  && apt-get update \
  && extensionDir=$(php-config --extension-dir) \
  && for ext in $PHP_EXTENSIONS; do \
       apt-get install -y php5-${ext} \
  &&   cp $(dpkg -L php5-$ext | grep '\.so') $extensionDir \
  &&   cp /etc/php5/mods-available/${ext}.ini $PHP_INI_DIR/conf.d ; \
     done

# MySQL fix
RUN cp /etc/php5/mods-available/mysqli.ini $PHP_INI_DIR/conf.d

# PECL HTTP FIX: The modules have to be loaded in a specific order
RUN rm $PHP_INI_DIR/conf.d/propro.ini $PHP_INI_DIR/conf.d/raphf.ini \
    && printf "%s\n" extension=propro.so extension=raphf.so extension=http.so > $PHP_INI_DIR/conf.d/pecl-http.ini

# These have to be compiled-by hand...normally included in a PHP build
RUN docker-php-ext-install $PHP_EXTENSIONS_EXTRA

# Configure Apache
COPY wordpress.conf /etc/apache2/sites-available/
COPY envvars /etc/apache2/envvars
RUN a2ensite wordpress && a2dissite 000-default \
 && a2enmod rewrite ssl headers

# Create the Wordpress user with your UID (resolves permission issues)
RUN . /etc/apache2/envvars \
 && useradd --shell /bin/bash -u $WORDPRESS_UID -G $APACHE_RUN_GROUP --create-home wordpress

RUN  cd /home/wordpress \
  && curl "$WORDPRESS_CORE" | tar xzf - \
  && mv wordpress public_html \
  && chown -R wordpress:wordpress public_html

RUN curl "$WORDPRESS_CLI" > /usr/local/bin/wp \
  && chmod +x /usr/local/bin/wp

RUN curl "$COMPOSER" > /usr/local/bin/composer \
  && chmod +x /usr/local/bin/composer

COPY htaccess /home/wordpress/public_html/.htaccess

WORKDIR /home/wordpress/public_html
COPY wordpress_container /wordpress_container
ENTRYPOINT bash /wordpress_container 

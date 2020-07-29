FROM php:7.4.1-fpm

# INSTALL library
RUN apt-get update \
  && apt-get install -y \
    curl \
    unzip \
    vim \
    wget

# INSTALL docker-extension
RUN docker-php-ext-install \
  mysqli \
  pdo \
  pdo_mysql 

# INSTALL Node.js
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
  && apt-get install -y nodejs

# INSTALL composer
RUN cd /usr/bin \
  && curl -s http://getcomposer.org/installer | php \
  && ln -s /usr/bin/composer.phar /usr/bin/composer

WORKDIR /var/www/html
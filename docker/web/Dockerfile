FROM php:7.4.1-fpm

# INSTALL php-library
RUN apt-get update \
  && apt-get install -y \
    curl \
    python3 \
    python3-pip \
    unzip \
    vim \
    wget \
    git \
    unzip \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    imagemagick \
    libmagickwand-dev

# INSTALL python-library
RUN python3 -m pip install -U pip \
  && pip3 install \
  pixivpy \
  requests \
  requests_toolbelt \
  scikit-learn \
  opencv-python

# INSTALL docker-extension
RUN docker-php-ext-install \
  mysqli \
  pdo \
  pdo_mysql
RUN docker-php-ext-configure gd --with-freetype=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd

# INSTALL Imagemagick
RUN pecl install imagick \
  && docker-php-ext-enable imagick

# INSTALL Node.js
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
  && apt-get install -y nodejs

# INSTALL composer
RUN cd /usr/bin \
  && curl -s http://getcomposer.org/installer | php \
  && ln -s /usr/bin/composer.phar /usr/bin/composer

WORKDIR /var/www/html
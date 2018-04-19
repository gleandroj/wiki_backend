#!/bin/bash 
set -ex

export DEBIAN_FRONTEND=noninteractive 

############################################
## Instalar PHP 7.1
############################################

export LANG=C.UTF-8

echo "Instalando o PHP 7.1 ..."

apt-get install -y  \
  libpcre3 \
  php7.1-cli \
  php7.1-dev \
  php7.1-pgsql \
  php7.1-sqlite3 \
  php7.1-memcached \
  php7.1-gd \
  php7.1-curl \
  php7.1-imap \
  php7.1-mysql \
  php7.1-imagick \
  php7.1-mbstring \
  php7.1-xml \
  php7.1-json \
  php7.1-zip \
  php7.1-bcmath \
  php7.1-soap \
  php7.1-intl \
  php7.1-readline \
  php7.1-mcrypt \
  php7.1-dba \
  php7.1-opcache \
  postgresql-client

# Instala o Composer
echo "Instalando o Composer..."
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
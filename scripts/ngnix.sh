#!/bin/bash 
set -ex

export DEBIAN_FRONTEND=noninteractive 

############################################
## Instalar Nginx
############################################

export LANG=C.UTF-8

echo "Instalando o Nginx..."

apt-add-repository ppa:ondrej/php -y
apt-add-repository ppa:nginx/stable -y
apt-add-repository ppa:ondrej/apache2 -y

apt-get update
apt-get install -y nginx php7.1-fpm

service nginx reload
service nginx restart

systemctl enable nginx.service

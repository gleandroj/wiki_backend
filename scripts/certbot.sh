#!/bin/bash 
set -ex

export DEBIAN_FRONTEND=noninteractive 


############################################
## Instalar Certbot para gerar certificados SSL gratuitos
############################################

echo "Instalando o Certbot..."

add-apt-repository ppa:certbot/certbot -y
apt-get update
apt-get install -y python-certbot-nginx
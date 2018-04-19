#!/bin/bash 
set -ex

export DEBIAN_FRONTEND=noninteractive 

############################################
## Instalar o Image Magick
############################################

echo "Instalando o Image Magick..."
apt-get install -y imagemagick
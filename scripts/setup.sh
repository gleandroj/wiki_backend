#!/bin/bash 
set -ex

export DEBIAN_FRONTEND=noninteractive 

############################################
## Configura o PHP-FPM
############################################

source /etc/environment

echo "Configurando o PHP..."

# Altera configuracoes do PHP-CLI
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.1/cli/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.1/cli/php.ini
sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.1/cli/php.ini
sed -i "s/upload_max_filesize = .*/upload_max_filesize = 100M/" /etc/php/7.1/cli/php.ini
sed -i "s/post_max_size = .*/post_max_size = 100M/" /etc/php/7.1/cli/php.ini
sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.1/cli/php.ini
sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.1/cli/php.ini

# Altera as configuracoes do PHP-FPM
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php/7.1/fpm/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php/7.1/fpm/php.ini
sed -i "s/;cgi.fix_pathinfo=1/cgi.fix_pathinfo=0/" /etc/php/7.1/fpm/php.ini
sed -i "s/memory_limit = .*/memory_limit = 512M/" /etc/php/7.1/fpm/php.ini
sed -i "s/upload_max_filesize = .*/upload_max_filesize = 100M/" /etc/php/7.1/fpm/php.ini
sed -i "s/post_max_size = .*/post_max_size = 100M/" /etc/php/7.1/fpm/php.ini
sed -i "s/;date.timezone.*/date.timezone = UTC/" /etc/php/7.1/fpm/php.ini
sed -i "s/short_open_tag = Off/short_open_tag = On/" /etc/php/7.1/fpm/php.ini

# Configuracoes da fila do FPM
sed -i "s/^user = www-data/user = ${DEPLOY_USER}/" /etc/php/7.1/fpm/pool.d/www.conf
sed -i "s/^group = www-data/group = ${DEPLOY_USER}/" /etc/php/7.1/fpm/pool.d/www.conf
sed -i "s/;listen\.owner.*/listen.owner = ${DEPLOY_USER}/" /etc/php/7.1/fpm/pool.d/www.conf
sed -i "s/;listen\.group.*/listen.group = ${DEPLOY_USER}/" /etc/php/7.1/fpm/pool.d/www.conf
sed -i "s/;listen\.mode.*/listen.mode = 0666/" /etc/php/7.1/fpm/pool.d/www.conf
sed -i "s/;request_terminate_timeout.*/request_terminate_timeout = 60/" /etc/php/7.1/fpm/pool.d/www.conf

# Ajusta as permicoes do diretorio de sessoes
chmod 733 /var/lib/php/sessions
chmod +t /var/lib/php/sessions

service php7.1-fpm reload
service php7.1-fpm restart

systemctl enable php7.1-fpm.service

# Reinicia o Nginx
service nginx reload
service nginx restart

############################################
## Configura o NGINX
############################################

source /etc/environment

echo "Configurando o NGINX..."

# Altera configuracoes do NGINX
sed -i "s/user www-data;/user ${DEPLOY_USER};/" /etc/nginx/nginx.conf
sed -i "s/worker_processes.*/worker_processes auto;/" /etc/nginx/nginx.conf
sed -i "s/# multi_accept.*/multi_accept on;/" /etc/nginx/nginx.conf
sed -i "s/# server_names_hash_bucket_size.*/server_names_hash_bucket_size 128;/" /etc/nginx/nginx.conf

# Configura o Gzip
cat > /etc/nginx/conf.d/gzip.conf << EOF
gzip_comp_level 5;
gzip_min_length 256;
gzip_proxied any;
gzip_vary on;
gzip_types
application/atom+xml
application/javascript
application/json
application/rss+xml
application/vnd.ms-fontobject
application/x-font-ttf
application/x-web-app-manifest+json
application/xhtml+xml
application/xml
font/opentype
image/svg+xml
image/x-icon
text/css
text/plain
text/x-component;
EOF

echo "Remove o site padrao"
rm /etc/nginx/sites-enabled/default
rm /etc/nginx/sites-available/default

echo "Configura o 404 no nginx quando nao encontrado"
cat > /etc/nginx/sites-available/catch-all << EOF
server {
    return 404;
}
EOF
ln -s /etc/nginx/sites-available/catch-all /etc/nginx/sites-enabled/catch-all


echo "Adiciona novo usuario ao grupo www-data"
usermod -a -G www-data ${DEPLOY_USER}
id ${DEPLOY_USER}
groups ${DEPLOY_USER}

service nginx restart

############################################
## Prepara o Nginx para SSL
############################################

echo "Prepara o Nginx para SSL..."

## Gera configuracoes padrao do ssl
touch /etc/nginx/snippets/ssl.conf
cat > /etc/nginx/snippets/ssl.conf << EOF
ssl_session_cache shared:le_nginx_SSL:1m;
ssl_session_timeout 1440m;
ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
ssl_prefer_server_ciphers on;
ssl_ciphers "ECDHE-ECDSA-CHACHA20-POLY1305:ECDHE-RSA-CHACHA20-POLY1305:ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES128-GCM-SHA256:DHE-RSA-AES256-GCM-SHA384:ECDHE-ECDSA-AES128-SHA256:ECDHE-RSA-AES128-SHA256:ECDHE-ECDSA-AES128-SHA:ECDHE-RSA-AES256-SHA384:ECDHE-RSA-AES128-SHA:ECDHE-ECDSA-AES256-SHA384:ECDHE-ECDSA-AES256-SHA:ECDHE-RSA-AES256-SHA:DHE-RSA-AES128-SHA256:DHE-RSA-AES128-SHA:DHE-RSA-AES256-SHA256:DHE-RSA-AES256-SHA:ECDHE-ECDSA-DES-CBC3-SHA:ECDHE-RSA-DES-CBC3-SHA:EDH-RSA-DES-CBC3-SHA:AES128-GCM-SHA256:AES256-GCM-SHA384:AES128-SHA256:AES256-SHA256:AES128-SHA:AES256-SHA:DES-CBC3-SHA:!DSS";
# add_header Strict-Transport-Security "max-age=15768000; includeSubdomains; preload";
add_header Strict-Transport-Security "max-age=15768000;";
add_header X-Frame-Options DENY;
add_header X-Content-Type-Options nosniff;
EOF

# Testa o Nginx
nginx -t

############################################
## Prepara o Nginx para SSL
############################################

source /etc/environment

echo "Prepara o Nginx para o Lets Encrypt..."

## Cria novo diretorio
mkdir -p /home/${DEPLOY_USER}/.letsencrypt/.well-known
chown -R deploy:deploy /home/${DEPLOY_USER}/.letsencrypt

## Gera configuracoes padrao do ssl
touch /etc/nginx/snippets/letsencrypt.conf
cat > /etc/nginx/snippets/letsencrypt.conf << EOF
location ^~ /.well-known/acme-challenge/ {
  default_type "text/plain";
  root /home/${DEPLOY_USER}/.letsencrypt;
}
EOF

# Testa o Nginx
nginx -t

source /etc/environment

export DOLLAR='$'
export APP_DOMAIN=${APP_DOMAIN}
export APP_DIR="app"

############################################
## Exemplos do Nginx com Laravel
############################################

echo "Gerando template para Nginx com Laravel"

touch /etc/nginx/sites-available/site-laravel-exemplo
cat > /etc/nginx/sites-available/site-laravel-exemplo << EOF
# Exemplo de Nginx com Laravel
# @author Julio Lustosa
server {
    listen 80;
    # listen [::]:80;
    server_name www.${APP_DOMAIN};
    return 301 ${DOLLAR}scheme://${APP_DOMAIN}${DOLLAR}request_uri;
}
server {
    listen 80 default_server;
    # listen [::]:80;
    # Dominio do servidor
    # server_name ${APP_DOMAIN};
    server_name _;
    # Pasta dos arquivos estaticos
    root /home/${DEPLOY_USER}/${APP_DIR}/public;
    # Configuracoes de seguranca
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";
    index index.html index.htm index.php;
    charset utf-8;
    # Tamanho maximo para upload
    client_max_body_size 100m;
    location / {
        try_files ${DOLLAR}uri ${DOLLAR}uri/ /index.php?${DOLLAR}query_string;
    }
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    access_log off;
    error_log  /var/log/nginx/${APP_DOMAIN}-error.log error;
    error_page 404 /index.php;
    location ~ \.php${DOLLAR} {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
    }
    location ~ /\.ht {
        deny all;
    }
    location ~ /\.(?!well-known).* {
        deny all;
    }
    
}
EOF

############################################
## Exemplos do Nginx com Passenger HTTPS
############################################

echo "Gerando template para Nginx HTTPS com SSL"

touch /etc/nginx/sites-available/ssl-site-laravel-exemplo
cat > /etc/nginx/sites-available/ssl-site-laravel-exemplo << EOF
# Exemplo de Nginx com Laravel usando SSL
# @author Julio Lustosa
#
# Para gerar os certificados use o comando abaixo
# $ certbot --nginx certonly --domains ${APP_DOMAIN}
server {
    # Redireciona da porta 80 para 443
    listen 80 default_server;
    # listen [::]:80;
    # server_name ${APP_DOMAIN} www.${APP_DOMAIN};
    server_name _;
    include /etc/nginx/snippets/letsencrypt.conf;
    location / {
        return 301 https://${DOLLAR}host${DOLLAR}request_uri;
    }
}
server {
    listen 443 ssl http2 default_server;
    # listen [::]:443 ssl http2;
    # Dominio do servidor
    # server_name ${APP_DOMAIN};
    server_name _;
    # Arquivos publicos do projeto
    root /home/${DEPLOY_USER}/${APP_DIR}/public;
    # Configuracoes de seguranca
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";
    index index.html index.htm index.php;
    charset utf-8;
    # Tamanho maximo para upload
    client_max_body_size 100m;
    location / {
        try_files ${DOLLAR}uri ${DOLLAR}uri/ /index.php?${DOLLAR}query_string;
    }
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    access_log off;
    error_log  /var/log/nginx/${APP_DOMAIN}-error.log error;
    error_page 404 /index.php;
    location ~ \.php${DOLLAR} {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
    }
    location ~ /\.ht {
        deny all;
    }
    location ~ /\.(?!well-known).* {
        deny all;
    }
    # Certificados SSL
    ssl_certificate /etc/letsencrypt/live/${APP_DOMAIN}/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/${APP_DOMAIN}/privkey.pem;
    ssl_trusted_certificate /etc/letsencrypt/live/${APP_DOMAIN}/fullchain.pem;
    # Configuracoes do SSL
    include /etc/nginx/snippets/ssl.conf;
    
}
EOF

## Habilita Site Local
cp /etc/nginx/sites-available/site-laravel-exemplo /etc/nginx/sites-enabled/site-app-localhost

# Testa o Nginx
nginx -t

service nginx restart

############################################
## Configura o Monit com Redis
############################################

echo "Configurando o Monit com Redis..."

##touch /etc/monit/conf-available/redis
##cat > /etc/monit/conf-available/redis << EOF
##check process redis with pidfile /var/run/redis/redis-server.pid
##  start program = "/etc/init.d/redis-server start"
##  stop program = "/etc/init.d/redis-server stop"
##  if failed host 127.0.0.1 port 6379 then restart
##  if 5 restart within 5 cycles then timeout
##EOF

## ln -s /etc/monit/conf-available/redis /etc/monit/conf-enabled/redis

## Testa as configuracoes do monit
monit -t

## Carrega e ativa as configuracoes
service monit reload

############################################
## Configura o Monit com Nginx
############################################

echo "Configurando o Monit com Nginx..."

ln -s /etc/monit/conf-available/nginx /etc/monit/conf-enabled/nginx

## Testa as configuracoes do monit
monit -t

## Carrega e ativa as configuracoes
service monit reload

############################################
## Configura o Monit com PHP 7 FPM
############################################

echo "Configurando o Monit com PHP 7 FPM..."

touch /etc/monit/conf-available/php7-fpm
cat > /etc/monit/conf-available/php7-fpm << EOF
check process php7-fpm with pidfile /run/php/php7.1-fpm.pid
    start program = "/etc/init.d/php7.1-fpm start" with timeout 60 seconds
    stop program  = "/etc/init.d/php7.1-fpm stop"
    if failed unixsocket /var/run/php/php7.1-fpm.sock then restart
EOF

ln -s /etc/monit/conf-available/php7-fpm /etc/monit/conf-enabled/php7-fpm

## Testa as configuracoes do monit
monit -t

## Carrega e ativa as configuracoes
service monit reload

############################################
## Limpa o sistema
############################################

echo "Limpando o sistema..."

apt-get -qq autoclean
apt-get -qq autoremove

rm -rf /tmp/* /var/tmp/*
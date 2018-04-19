#!/bin/bash
set -e

echo "Teste de Inicialização"

## Monitora e inicia servicos
echo -e "\nIniciando os servicos..."

## service supervisor start
service cron start
service php7.1-fpm start
# service memcached restart

## Verifica se inicia servidor redis localmente
## if [ "${ENABLE_REDIS_SERVER_LOCAL}" == "true" ]; then
##    ## Inicia Servidor Redis Local
##    service redis-server start
## fi

## Verifica se esta rodando no modo de teste
if [ "${TEST_MODE}" == "true" ]; then
    ## Nginx
    service nginx start
else
    monit stop nginx
    service nginx stop
fi

echo -e "\nIniciando o monit..."
service monit start

# ## Supervisor
# monit start supervisor
# monit monitor supervisor

# ## Crond
# monit start crond
# monit monitor crond

# ## PHP 7 FPM
# monit start php7-fpm
# monit monitor php7-fpm

# ## Redis
# monit start redis
# monit monitor redis

# ## Memcached
# monit start memcache
# monit monitor memcache

## Inicia o nginx
echo -e "\nRodando o Nginx..."
/usr/sbin/nginx -g "daemon off;"
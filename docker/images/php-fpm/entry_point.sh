#!/usr/bin/env bash

su -c 'composer install' www-data;

php artisan cache:clear
php artisan config:cache

composer dump-autoload --optimize

supervisord --nodaemon --configuration /etc/supervisor/conf.d/laravel-worker.conf
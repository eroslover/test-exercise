#!/usr/bin/env bash

while [ true ]
do
php /var/www/laravel/artisan schedule:run >> /dev/null 2>&1
sleep 60
done

#!/bin/sh

cd code
cp .env.example .env
composer install
php artisan migrate
php artisan clear-compiled

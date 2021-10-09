<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Our App

Projemiz haber sitesi uygulamasıdır. Haber oluşturulur. Yorum yapılır. Aktivite takibi yapılır. Takibe aldığınız kategorilere göre haber akışınız oluşur. Özel akışınızın oluşması için kategorileri takip etmeniz gerekmektedir.


## Open api(swagger)

 [Open api doc (Swagger) ](https://app.swaggerhub.com/apis/fuloskop/patika-dev_bootcamp_news_api/1.0). 

## Installation : 

git clone https://github.com/fuloskop/news.git

docker-compose up -d --build

docker exec -it "here-docker-php-container" bash

composer install

php artisan key:generate

php artisan migrate:fresh --seed

php artisan cache:clear

# Pub-Sub Messaging with Laravel and Apache Kafka Example (Publisher)

## Description
https://engineering.carsguide.com.au/laravel-pub-sub-messaging-with-apache-kafka-3b27ed1ee5e8

## Docker image

```
anamhossain/php-kafka:latest
```

## Setup

https://engineering.carsguide.com.au/laravel-pub-sub-messaging-with-apache-kafka-3b27ed1ee5e8

## Connect to database

To connect to MySQL database from your main machine via Navicat or Sequel Pro, you should connect to `127.0.0.1` and port `3407`. The username and password for databases is `laravel / laravel`.

```yml
host: 127.0.0.1
port: 3407
database: laravel
username: laravel
password: laravel
```

## Kafka settings

ENV settings:
```
KAFKA_BROKERS=kafka:9092
KAFKA_DEBUG=false

DB_CONNECTION=mysql
DB_HOST=kafka_producer_mysql_db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel
```



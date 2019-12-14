# Pub-Sub Messaging with Laravel and Apache Kafka Example (Publisher)

## Description
Blog post link

## Docker image

```
anamhossain/php-kafka:latest
```

## Setup

- Install Docker and Docker-compose in your machine
- Create a custom docker network (pub_sub_network) for this tutorial. This will enable external communication between two microservices.
`docker network create pub_sub_network`
- Clone repo from https://github.com/anam-hossain/laravel-kafka-pub-example
- Copy the `.env.local` to `.env`
- Ensure that `KAFKA_BROKERS=kafka:9092` added to `.env` file
- Run `docker-compose up -d` from repo directory.
- Browse http://localhost:8787 to verify that the microservice 1 is up and running.

Once confirmed that service is up and running, go back to the microservice 1terminal and run the following commands to perform database migrations:

```sh
# 1. Log in to the microservice 1 container

docker-compose exec kafka_producer_php sh

# 2. Run the migration

php artisan migrate
```

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
```



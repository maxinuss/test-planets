# test-planets

#### Test Assignments

[Download here](test_assignments.pdf)

## Important notes

* One period is considered as 1 day.
* One year has 360 days
* I will use Ferengi to represent system forecast

## Project

#### Folder structure
This project is built using Docker and PHP 7.2 with a DDD approach. 
This leads to three main folders: (https://en.wikipedia.org/wiki/Domain-driven_design)
* *Application*: services to interact with the domain of the application.
* *Domain*: entities, domain exceptions and interfaces to handle domain layer.
* *Infrastructure*: concrete implementations of the domain.

#### Requirements
In order to run this project you will need:

* Docker (https://www.docker.com/community-edition)
* Docker compose (https://docs.docker.com/compose/install/)

#### Local environment

* Nginx
* PHP 7.2 (FPM)
* MySQL

If you use Linux a *Makefile* is included, so you can run these commands to start and stop all containers at once.
Go to project root and run:

To start docker
```
make up
```

To stop docker
```
make down
```

#### First time instructions:

###### Linux
1) Install Docker and Docker compose
2) Create .env file using .env.example info (Modify paths if needed)
3) In project root execute ``` make up ``` 
4) In project root execute ``` make php ``` and go inside php docker.
5) Execute ``` composer install```
6) Apply database dump ``` php bin/console orm:schema-tool:update --force ```

###### Windows 10
1) Install Docker
2) Create .env file using .env.example info (Modify paths if needed)
3) In project root execute ``` docker-compose up -d ``` 
4) In project root execute ``` docker exec -it php-planets-maxinuss-container bash ``` and go inside php docker.
5) Execute ``` composer install```
6) Apply database dump ``` php bin/console orm:schema-tool:update --force ```

#### Get Forecast
* Inside PHP docker (see First time instructions step 4) RUN ``` php bin/console predictions:ferengi ```

#### Generate Forecast with JOB
* Inside PHP docker (see First time instructions step 4) RUN ``` php bin/console predictions:generate ```

#### API Endpoint

Base url: ``` http://localhost:8040 ```

###### Get Forecast
Get forecast for specific day

[GET] ``` /clima?dia=566 ```

Response:
```json
{ 
  "dia":566,
  "clima":"lluvia"
}
```

#### Running test
This project is tested under PHPUnit and includes a unit test suite:
```
php vendor/bin/phpunit
```

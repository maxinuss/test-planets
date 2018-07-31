.PHONY: up down

MAKEPATH := $(abspath $(lastword $(MAKEFILE_LIST)))
PWD := $(dir $(MAKEPATH))

up:
	docker-compose up -d

down:
	docker-compose down

nginx: 
	docker exec -it nginx-planets-maxinuss-container bash

php: 
	docker exec -it php-planets-maxinuss-container bash
	
mysql: 
	docker exec -it mysql-planets-maxinuss-container bash
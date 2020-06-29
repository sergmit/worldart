PHP = docker-compose exec service-php

start:
	docker-compose up -d

build:
	docker-compose up -d --build

stop:
	docker-compose down --remove-orphans

bash:
	docker-compose exec service-php bash

restart: stop start

rebuild: stop build



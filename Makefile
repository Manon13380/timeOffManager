# Makefile
SHELL := /bin/bash

start : 
	symfony server:start -d --no-tls

mail :
	symfony open:local:webmail

workflow :
	symfony run -d --watch=config,src,templates,vendor symfony console messenger:consume async

connect_dbTest :
	docker-compose exec database psql -U app app_test

connect_db:
	docker-compose exec database psql -U app app

fixtures:
	APP_ENV=test symfony console doctrine:database:drop --force || true	
	APP_ENV=test symfony console doctrine:database:create
	APP_ENV=test symfony console doctrine:schema:update --force
	APP_ENV=test symfony console doctrine:fixtures:load -n
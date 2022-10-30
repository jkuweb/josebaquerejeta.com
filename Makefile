#!/bin/bash 

UID = $(shell id -u)
DOCKER_BE = web-josebaquerejeta

help: ## Show this help message 
	@echo 'usage: make [target]'
	@echo '¯¯¯°°°°°°°°°°°°°°°°°¯¯¯'
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

start: ## Start the containers
	cp docker-compose.yml.dist docker-compose.yml || true 
	U_ID={UID} docker-compose up -d

stop: ## Stop the containers
	U_ID=${UID} docker-compose stop

restart: ## Restart the containers
	$(MAKE) stop && $(MAKE) start

build: ## Rebuilds all the containers
	cp docker-compose.yml.dist docker-compose.yml || true 
	U_ID=${UID} docker-compose build

prepare: ## Runs backend commands
	$(MAKE) composer-install

run: ## Start the Synfony development server
	U_UID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} symfony serve -d

logs: ## Show Symfony logs in real time
	U_UID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} symfony serve:log

# Backend commands
composer-install: ## Install composer dependencies
	U_UID=${UID} docker exec --user ${UID} ${DOCKER_BE} composer install --no-interaction

ssh-be: ## Bash into the container
	U_ID=${UID} docker exec -it --user ${UID} ${DOCKER_BE} bash

code-style: ## Run php-cs to fix code styling following Symfony rules
	U_ID=${UID} docker exec --user ${UID} ${DOCKER_BE} php-cs-fixer fix src --rules=@Symfony

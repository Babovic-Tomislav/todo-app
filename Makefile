.PHONY: dev composer_install clean_db up down start stop status help
.DEFAULT_GOAL := help

ROOT_DIR := $(shell pwd)
DOCKER_COMPOSE := $(shell which docker-compose)
DOCKER := $(shell which docker)

help:
	@echo "--> You are running default target. Look at the Makefile to see other available targets."

# setups dev environment
dev: up composer_install clean_db run_fixtures

dev_checks: csfix stan validate_doctrine_scheme

# runs composer install and installs project dependencies
composer_install:
	@echo "--> Installing php dependencies"
	@${DOCKER_COMPOSE} exec backend composer install

clean_db: sync_doctrine_storage
	@echo "--> refreshing database"
	# Migrate down all
	@${DOCKER_COMPOSE} exec backend bin/console doctrine:schema:drop --full-database --force
	# Migrate up all
	@${DOCKER_COMPOSE} exec backend bin/console d:m:m --no-interaction --quiet

migration_rollback:
	@echo "--> Rolling back latest migration"
	@${DOCKER_COMPOSE} exec backend bin/console d:m:m prev

sync_doctrine_storage:
	# Sync meta data database
	@${DOCKER_COMPOSE} exec backend bin/console doctrine:migrations:sync-metadata-storage --quiet

up:
	@echo "--> starting project containers"
	@${DOCKER_COMPOSE} up -d

start:
	@echo "--> starting existing project containers"
	@${DOCKER_COMPOSE} start

stop:
	@echo "--> stoping project containers"
	@${DOCKER_COMPOSE} stop

down:
	@echo "--> removing project containers"
	@${DOCKER_COMPOSE} down

setup_hooks:
	# Setup commit msg hook
	@cp ${ROOT_DIR}/__hooks/commit-msg ${ROOT_DIR}/.git/hooks/commit-msg
	# Setup pre commit hook
	@cp ${ROOT_DIR}/__hooks/pre-commit ${ROOT_DIR}/.git/hooks/pre-commit
	# Setup pre push hook
	@cp ${ROOT_DIR}/__hooks/pre-push ${ROOT_DIR}/.git/hooks/pre-push

clear_hooks:
	# Clear commit msg hook
	@rm ${ROOT_DIR}/.git/hooks/commit-msg
	# Clear pre commit hook
	@rm ${ROOT_DIR}/.git/hooks/pre-commit
	# Clear pre push hook
	@rm ${ROOT_DIR}/.git/hooks/pre-push

status:
	@$(DOCKER) ps

stan:
	@${DOCKER_COMPOSE} exec backend vendor/bin/phpstan analyze -l 8 src

csfix:
	@${DOCKER_COMPOSE} exec backend vendor/bin/php-cs-fixer fix --ansi -v --config=.php-cs-fixer.dist.php --path-mode=intersection src migrations

tests:
	@${DOCKER_COMPOSE} exec backend vendor/bin/phpunit src

clear_cache:
	@${DOCKER_COMPOSE} exec backend bin/console cache:clear

traefik_build:
	@$(DOCKER) run -d -p 9999:9999 -p 80:80 -p 443:443 -v /var/run/docker.sock:/var/run/docker.sock:ro --name traefik_loc --restart unless-stopped --network web asynclabsco/traefik-loc:latest

traefik_start:
	@$(DOCKER) start traefik_loc

run_fixtures:
	@${DOCKER_COMPOSE} exec backend bin/console doctrine:fixtures:load

validate_doctrine_scheme:
	@${DOCKER_COMPOSE} exec backend bin/console doctrine:schema:validate

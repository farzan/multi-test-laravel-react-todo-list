APP_NAME := quick_laravel_test_1
APP_NETWORK := quick_laravel_test_1_network

COMPOSE := docker compose \
	-f docker/compose.yaml \
	--env-file .env
BUILD := $(COMPOSE) run --rm php-build
CLI := $(COMPOSE) exec -it php-cli

.PHONY: setup teardown build up down ps logs shell

# Setup/Teardown:
setup:
	@docker network inspect $(APP_NETWORK) >/dev/null 2>&1 || \
		docker network create $(APP_NETWORK)
	-mkdir ./vendor
	-mkdir ./npm_modules
	chmod 775 vendor
	chmod 775 npm_modules
	make build
	make up
	make composer-install
	make npm-install

teardown:
	$(COMPOSE) down --volumes
	@docker network rm $(APP_NETWORK) >/dev/null 2>&1 || true
	-rm -rf ./vendor
	-rm -rf ./node_modules

build:
	$(COMPOSE) build

composer-install:
	$(BUILD) composer install

npm-install:
	$(BUILD) npm install

# Run:
up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

ps:
	$(COMPOSE) ps

logs:
	$(COMPOSE) logs -f



# Shells:
shell-cli:
	$(CLI) bash

shell-build:
	$(BUILD) bash

shell-mysql:
	$(COMPOSE) exec mysql bash

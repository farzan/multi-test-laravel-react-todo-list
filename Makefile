APP_NAME := quick_laravel_test_1
APP_NETWORK := quick_laravel_test_1_network

COMPOSE := docker compose \
	-f docker/compose.yaml \
	--env-file .env
BUILD := $(COMPOSE) run --rm php-build
CLI := $(COMPOSE) exec -it php-cli

.PHONY: setup teardown build up down ps logs shell

setup:
	@docker network inspect $(APP_NETWORK) >/dev/null 2>&1 || \
		docker network create $(APP_NETWORK)
	make build
	make up

teardown:
	$(COMPOSE) down -v
	@docker network rm $(APP_NETWORK) >/dev/null 2>&1 || true

build:
	$(COMPOSE) build

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

ps:
	$(COMPOSE) ps

logs:
	$(COMPOSE) logs -f

shell-cli:
	$(CLI) bash

shell-build:
	$(BUILD) bash

shell-mysql:
	$(COMPOSE) exec mysql bash

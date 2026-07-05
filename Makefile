APP_NAME := quick_laravel_test_1
APP_NETWORK := quick_laravel_test_1_network

COMPOSE := docker compose \
	-f docker/compose.yaml \
	--env-file .env
BUILD := $(COMPOSE) run --rm php-build
CLI := $(COMPOSE) exec -it php-cli

.PHONY: setup teardown build up down ps logs shell

# Build:
setup:
	@docker network inspect $(APP_NETWORK) >/dev/null 2>&1 || \
		docker network create $(APP_NETWORK)

	-mkdir -p ./vendor
	-mkdir -p ./npm_modules

	chmod 775 vendor
	chmod 775 npm_modules

	make build
	make up

	# backend deps
	make composer-install

	# frontend deps + build
	make npm-install
	make npm-build
	make npm-deploy

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
	cd frontend && npm install

npm-build:
	cd frontend && npm run build

npm-deploy:
	rm -rf backend/public/assets backend/public/index.html
	cp -r frontend/dist/* backend/public/

# Run:
up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

ps:
	$(COMPOSE) ps

logs:
	$(COMPOSE) logs -f

test:
	$(CLI) php artisan test

run-front:
	cd ./frontend && npm run dev

# Shells:
shell-cli:
	$(CLI) bash

shell-build:
	$(BUILD) bash

shell-mysql:
	$(COMPOSE) exec mysql bash

APP_NAME := quick_laravel_test_1
APP_NETWORK := quick_laravel_test_1_network

COMPOSE := docker compose \
	-f docker/compose.yaml \
	--env-file .env
BUILD := $(COMPOSE) --profile utility run --rm php-build
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
	make php-migrate

	# frontend deps + build
	make npm-install
	make npm-build

teardown:
	$(COMPOSE) down --volumes --remove-orphans

	# explicitly stop/remove any leftover php-build container
	-$(COMPOSE) rm -sf php-build >/dev/null 2>&1 || true

	@docker network rm $(APP_NETWORK) >/dev/null 2>&1 || true

	# backend dependencies
	-rm -rf vendor

	# frontend dependencies + build artifacts
	-rm -rf frontend/node_modules
	-rm -rf frontend/dist

	# optional: if you want full reset of deployed assets
	-rm -rf public/frontend

	# legacy cleanup (safe if still present)
	-rm -rf node_modules
	-rm -rf npm_modules

build:
	$(COMPOSE) build

composer-install:
	$(BUILD) composer install

npm-install:
	cd frontend && npm install

npm-build:
	cd frontend && npm run build

php-migrate:
	$(CLI) php artisan migrate

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

shell-nginx:
	$(COMPOSE) exec nginx sh

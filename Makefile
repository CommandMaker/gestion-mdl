USER_ID = $(shell id -u)
GROUP_ID = $(shell id -g)
DOCKER_FLAGS = USER_ID=$(USER_ID) GROUP_ID=$(GROUP_ID) COMPOSE_BAKE=true
DC = $(DOCKER_FLAGS) docker-compose
DE = $(DOCKER_FLAGS) docker-compose exec

.PHONY: all
all: dev-helper

.PHONY: dev
dev: build
	@$(DC) up

.PHONY: prepare-dev
prepare-dev:
	@$(DE) php ./artisan migrate -n
	@$(MAKE) dev-helper

.PHONY: build
build:
	@$(DC) build

.PHONY: dev-helper
dev-helper:
	@$(DE) php ./artisan ide-helper:generate
	@$(DE) php ./artisan ide-helper:models -RN

.PHONY: tt
tt:
	@$(DE) php ./vendor/bin/phpunit-watcher watch

.PHONY: test
test:
	@$(DE) php ./artisan test

.PHONY: format
format:
	@$(DE) php ./vendor/bin/pint

.PHONY: lint
lint:
	@$(DE) php ./vendor/bin/phpstan --memory-limit=2G

.PHONY: prepare-commit
prepare-commit: test format lint

.PHONY: docker-assets
docker-assets:
	PATH=$$PATH:/home/node/.npm-global/bin NPM_CONFIG_PREFIX=/home/node/.npm-global npm i -g pnpm
	PATH=$$PATH:/home/node/.npm-global/bin pnpm i
	PATH=$$PATH:/home/node/.npm-global/bin pnpm dev

# vim: set noexpandtab:

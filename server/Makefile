USER_ID=$(shell id -u)
GROUP_ID=$(shell id -g)
dc=USER_ID=$(USER_ID) GROUP_ID=$(GROUP_ID) docker-compose
de=USER_ID=$(USER_ID) GROUP_ID=$(GROUP_ID) docker-compose exec
RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

.PHONY: lint
lint:
	./vendor/bin/phpstan analyse --memory-limit=2G

.PHONY: format
format:
	./vendor/bin/pint

.PHONY: prepare-commit
prepare-commit: lint format

.PHONY: dev
dev:
	@$(dc) build
	@$(dc) up

.PHONY: de
de:
	@$(de) $(RUN_ARGS)

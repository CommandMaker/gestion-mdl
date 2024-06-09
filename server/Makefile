.PHONY: lint
lint:
	./vendor/bin/phpstan analyse --memory-limit=2G

.PHONY: format
format:
	./vendor/bin/pint

.PHONY: prepare-commit
prepare-commit: lint format

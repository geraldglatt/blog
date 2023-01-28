# Variables
PHP = $(EXEC) php 
COMPOSER = $(EXEC) composer 
NPM = $(EXEC) npm 
SYMFONY_CONSOLE = $(PHP) bin/console

# Colors
GREEN = /bin/echo -e "\x1b[32m\#\# $1\x1b[0m"
RED = /bin/echo -e "\x1b[31m\#\# $1\x1b[0m"

## ----------- App ------------- ##
init: ## Init the project
	$(MAKE) composer-install

cache-clear: ## clear cache
	$(SYMFONY_CONSOLE) cache:clear

## ----------- composer --------- ##
composer-install: ## Install dependencies
	$(COMPOSER) install

composer-update: ## update dependencies
	$(COMPOSER) update

## ----------- Database ----------- ##

rebuild: ## rebuild
	symfony console d:d:d -f
	symfony console d:d:c
	symfony console d:s:u -f
	symfony console d:f:l -n

## ----------- others ------------- ##

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

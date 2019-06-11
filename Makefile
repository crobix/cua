sf=php bin/console
dcconf=--file docker/docker-compose.yml
tool=docker-compose $(dcconf) run --rm toolcua

THIS_FILE := $(lastword $(MAKEFILE_LIST))

start:
	@docker-compose $(dcconf) start

stop:
	@docker-compose $(dcconf) stop

up:
	@docker-compose $(dcconf) up -d

clean: stop
	@docker-compose $(dcconf) rm -f

doctrine-diff:
	#@$(tool) bash -ci '/fixright && sudo -E -u phpuser $(sf) doctrine:generate:entities AppCommon:'
	#@$(tool) bash -ci '/fixright && sudo -E -u phpuser $(sf) doctrine:generate:entities AppVideo:'
	@$(tool) bash -ci '/fixright && sudo -E -u phpuser $(sf) doctrine:migration:diff'

doctrine-mig:
	@$(tool) bash -ci '/fixright && sudo -E -u phpuser $(sf) doctrine:migration:migrate --no-interaction $(v)'

command:
	$(tool) bash -ci '/fixright && sudo -E -u phpuser $(sf) $(c)'

console:
	$(tool) bash

run-unit:
	$(tool) bin/atoum

atoum:
	$(tool) bin/atoum

composer.lock: composer.json
	composer self-update
	$(tool) bash -ci 'phpdismod -v ALL -s ALL xdebug && composer update --no-scripts --optimize-autoloader $(bundle)'
	#$(tool) bash -ci '/fixright && sudo -E -u phpuser php vendor/sensio/distribution-bundle/Resources/bin/build_bootstrap.php'
	$(tool) bash -ci 'chown -R $(stat -c "%u" /sources):$(stat -c "%g" /sources) /sources'

vendor: composer.lock
	composer self-update
	$(tool) bash -ci 'phpdismod -v ALL -s ALL xdebug && composer install --no-scripts --optimize-autoloader'
	#$(tool) bash -ci '/fixright && sudo -E -u phpuser php vendor/sensio/distribution-bundle/Resources/bin/build_bootstrap.php'
	$(tool) bash -ci 'chown -R $(stat -c "%u" /sources):$(stat -c "%g" /sources) /sources'

assets: assets-install assets-dump

assets-install: vendor
	$(tool) bash -c 'bin/console assets:install web'

assets-dump: node_modules
	@docker-compose $(dcconf) run --rm npmcua bash -c 'cd /sources && ./node_modules/.bin/encore dev'
	$(tool) bash -ci 'chown -R $(stat -c "%u" /sources):$(stat -c "%g" /sources) /sources'

node_modules: package-lock.json
	@docker-compose $(dcconf) run --rm npmcua bash -c 'cd /sources && npm install --no-save'
	$(tool) bash -ci 'chown -R $(stat -c "%u" /sources):$(stat -c "%g" /sources) /sources'

package-lock.json: package.json
	@docker-compose $(dcconf) run --rm npmcua bash -c 'cd /sources && npm install'
	$(tool) bash -ci 'chown -R $(stat -c "%u" /sources):$(stat -c "%g" /sources) /sources'

node-console:
	@docker-compose $(dcconf) run --rm -w /sources npmcua bash

snapshot: assets
	@$(tool) bash -ci 'GIT_VERSION=${GIT_VERSION} nexus_user=${nexus_user} nexus_password=${nexus_password} ./build.sh'

package:
	composer self-update
	$(tool) bash -ci 'phpdismod -v ALL -s ALL xdebug && composer install --no-scripts --optimize-autoloader --no-ansi --no-progress --no-dev --no-interaction --prefer-dist'
	@$(MAKE) -f $(THIS_FILE) assets
	@$(tool) bash -ci 'GIT_VERSION=${GIT_VERSION} nexus_user=${nexus_user} nexus_password=${nexus_password} ./build.sh'



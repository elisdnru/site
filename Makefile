init: docker-down-clear site-clear docker-pull docker-build docker-build docker-up site-init site-ready
up: docker-up
down: docker-down
restart: docker-down docker-up
check: validate lint test
validate: site-composer-validate
lint: site-lint site-assets-lint site-analyze
test: site-test site-fixtures

update-deps: site-composer-update site-assets-update restart

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans -t 3

docker-down-clear:
	docker-compose down -v --remove-orphans -t 1

docker-pull:
	- docker-compose pull

docker-build:
	DOCKER_BUILDKIT=1 COMPOSE_DOCKER_CLI_BUILD=1 docker-compose build --build-arg BUILDKIT_INLINE_CACHE=1 --pull

site-init: site-permissions site-composer-install site-assets-install site-wait-db site-migrations site-fixtures site-test-generate site-assets-build

site-clear:
	docker run --rm -v ${PWD}:/app -w /app alpine sh -c 'rm -rf .ready var/* public/assets/* tests/_output/*'

site-permissions:
	docker run --rm -v ${PWD}:/app -w /app alpine chmod 777 var public/assets public/upload

site-composer-install:
	docker-compose run --rm php-cli composer install

site-composer-update:
	docker-compose run --rm php-cli composer update

site-composer-validate:
	docker-compose run --rm php-cli composer validate

site-assets-install:
	docker-compose run --rm node-cli yarn install

site-assets-update:
	docker-compose run --rm node-cli yarn upgrade

site-wait-db:
	docker-compose run --rm php-cli wait-for-it mysql:3306 -t 30

site-migrations:
	docker-compose run --rm php-cli composer app migrate -- --interactive=0

site-fixtures:
	docker-compose run --rm php-cli composer app fixture/load '*' -- --interactive=0

site-ready:
	docker run --rm -v ${PWD}:/app --workdir=/app alpine touch .ready

site-assets-build:
	docker-compose run --rm node-cli yarn build

site-lint:
	docker-compose run --rm php-cli composer lint
	docker-compose run --rm php-cli composer phpcs

site-assets-lint:
	docker-compose run --rm node-cli yarn eslint
	docker-compose run --rm node-cli yarn stylelint

site-assets-eslint-fix:
	docker-compose run --rm node-cli yarn eslint-fix

site-assets-pretty:
	docker-compose run --rm node-cli yarn prettier

site-analyze:
	docker-compose run --rm php-cli composer psalm -- --no-diff

site-analyze-diff:
	docker-compose run --rm php-cli composer psalm

site-test-generate:
	docker-compose run --rm php-cli composer test build

site-test:
	docker-compose run --rm php-cli composer test run unit,integration,acceptance

push-dev-cache:
	docker-compose push

deploy:
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd ${DIR} && git fetch --force origin "master:remotes/origin/master"'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd ${DIR} && git reset --hard "${REVISION}"'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd ${DIR} && composer install --no-dev --optimize-autoloader'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd ${DIR} && php bin/app.php migrate --interactive=0'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd ${DIR} && rm -rf var/fpm-fcgi/cache/*'

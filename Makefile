up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear site-clear docker-pull docker-build docker-up site-init
check: lint test
lint: site-lint
test: site-test

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

site-init: site-composer-install site-assets-install site-wait-db site-migrations site-wait-db-test site-migrations-test

site-clear:
	docker run --rm -v ${PWD}:/app --workdir=/app alpine sh -c 'rm -rf var/*'

site-composer-install:
	docker-compose run --rm php-cli composer install

site-assets-install:
	docker-compose run --rm node-cli yarn install

site-wait-db:
	until docker-compose exec -T mysql mysqladmin ping --silent; do sleep 1 ; done
	sleep 1

site-migrations:
	docker-compose run --rm php-cli composer app migrate -- --interactive=0

site-wait-db-test:
	until docker-compose exec -T mysql-test mysqladmin ping --silent; do sleep 1 ; done
	sleep 1

site-migrations-test:
	docker-compose run --rm php-cli composer app-test migrate -- --interactive=0

site-lint:
	docker-compose run --rm php-cli composer lint

site-test:
	docker-compose run --rm php-cli vendor/bin/phpunit

assets-build:
	docker-compose run --rm node-cli npm run build

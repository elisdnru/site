up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear site-clear docker-pull docker-build docker-up site-init site-ready
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
	docker-compose build --parallel

site-init: site-permissions site-composer-install site-assets-install site-wait-db site-migrations site-wait-db-test site-migrations-test

site-clear:
	docker run --rm -v ${PWD}:/app -w /app alpine sh -c 'rm -rf .ready var/* public/assets/*'

site-permissions:
	docker run --rm -v ${PWD}:/app -w /app alpine chmod 777 var public/assets public/upload

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

site-ready:
	docker run --rm -v ${PWD}:/app --workdir=/app alpine touch .ready

site-lint:
	docker-compose run --rm php-cli composer lint
	docker-compose run --rm php-cli composer cs-check

site-test:
	docker-compose run --rm php-cli vendor/bin/codecept run unit,integration,acceptance

assets-build:
	docker-compose run --rm node-cli npm run build

deploy:
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd ${DIR} && git fetch --force origin "master:remotes/origin/master"'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd ${DIR} && git reset --hard "${REVISION}"'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd ${DIR} && composer install --no-dev -o'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd ${DIR} && php bin/app.php migrate --interactive=0'
	ssh -o StrictHostKeyChecking=no ${HOST} -p ${PORT} 'cd ${DIR} && rm -rf var/fpm-fcgi/cache/*'

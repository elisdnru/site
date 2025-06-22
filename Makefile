init: \
	docker-down-clear \
	app-clear \
	docker-pull docker-build docker-up \
	app-init \
	app-ready

up: docker-up
down: docker-down
restart: docker-down docker-up

check: app-check

update-deps: app-composer-update app-assets-update restart

docker-up:
	docker compose up -d

docker-down:
	docker compose down --remove-orphans

docker-down-clear:
	docker compose down --volumes --remove-orphans

docker-pull:
	docker compose pull --ignore-pull-failures

docker-build:
	docker compose build --pull

push-dev-cache:
	docker compose push

app-clear:
	docker run --rm -v ${PWD}:/app -w /app alpine:3.21 sh -c 'rm -rf .ready var/* public/assets/* public/build/* public/upload/* tests/_output/* tests/_support/_generated/*'

app-init: \
	app-permissions \
	app-composer-install \
	app-assets-install \
	app-wait-db \
	app-wait-redis \
	app-migrations \
	app-fixtures \
	app-test-generate \
	app-assets-build

app-permissions:
	docker run --rm -v ${PWD}:/app -w /app alpine:3.21 sh -c 'mkdir -p public/build && chmod 777 var public/assets public/build public/upload tests/_output tests/_support/_generated'

app-composer-install:
	docker compose run --rm site-php-cli composer install

app-composer-update:
	docker compose run --rm site-php-cli composer update

app-assets-install:
	docker compose run --rm site-node-cli yarn install

app-assets-update:
	docker compose run --rm site-node-cli yarn upgrade

app-wait-db:
	docker compose run --rm site-php-cli wait-for-it site-mysql:3306 -t 30

app-wait-redis:
	docker compose run --rm site-php-cli wait-for-it site-redis:6379 -t 30

app-migrations:
	docker compose run --rm site-php-cli composer app migrate -- --interactive=0

app-fixtures:
	docker compose run --rm site-php-cli composer app fixture/load '*' -- --interactive=0
	docker compose run --rm site-php-cli composer app cache/flush cache -- --interactive=0
	docker run --rm -v ${PWD}:/app -w /app alpine:3.21 sh -c 'rm -rf public/upload/* && cp -rf demo/upload/* public/upload'
	docker run --rm -v ${PWD}:/app -w /app alpine:3.21 sh -c 'find public/upload -type d -exec chmod 777 {} \;'
	docker run --rm -v ${PWD}:/app -w /app alpine:3.21 sh -c 'find public/upload -type f -exec chmod 666 {} \;'

app-assets-build:
	docker compose run --rm site-node-cli yarn build

app-ready:
	docker run --rm -v ${PWD}:/app --workdir=/app alpine:3.21 touch .ready

app-check: \
	app-composer-validate \
	app-lint \
	app-assets-lint \
	app-analyze \
	app-test \
	app-fixtures \
	app-backup-mysql \
	app-backup-upload

app-fix: \
	app-lint-fix \
	app-assets-lint-fix \
	app-assets-pretty

app-composer-validate:
	docker compose run --rm site-php-cli composer validate

app-lint:
	docker compose run --rm site-php-cli composer lint
	docker compose run --rm site-php-cli composer php-cs-fixer fix -- --dry-run --diff

app-lint-fix:
	docker compose run --rm site-php-cli composer php-cs-fixer fix

app-assets-lint:
	docker compose run --rm site-node-cli yarn eslint
	docker compose run --rm site-node-cli yarn stylelint

app-assets-lint-fix:
	docker compose run --rm site-node-cli yarn eslint-fix
	docker compose run --rm site-node-cli yarn stylelint-fix

app-assets-pretty:
	docker compose run --rm site-node-cli yarn prettier

app-analyze:
	docker compose run --rm site-php-cli composer psalm -- --no-diff

app-analyze-update-baseline:
	docker compose run --rm site-php-cli composer psalm -- --no-diff --update-baseline

app-analyze-diff:
	docker compose run --rm site-php-cli composer psalm

app-test-generate:
	docker compose run --rm site-php-cli composer test build

app-test:
	docker compose run --rm site-php-cli composer test run unit,integration,acceptance

app-test-unit-integration:
	docker compose run --rm site-php-cli composer test run unit,integration

app-backup-mysql:
	docker compose run --rm site-mysql-backup

app-backup-upload:
	docker compose run --rm site-upload-backup

build:
	docker buildx build --pull \
	--target builder \
	--cache-to type=inline \
	--cache-from ${REGISTRY}/site:cache-builder \
	--tag ${REGISTRY}/site:cache-builder \
	--file docker/production/nginx/Dockerfile .

	docker buildx build --pull \
	--cache-to type=inline \
	--cache-from ${REGISTRY}/site:cache-builder \
	--cache-from ${REGISTRY}/site:cache \
	--tag ${REGISTRY}/site:cache \
	--tag ${REGISTRY}/site:${IMAGE_TAG} \
	--file docker/production/nginx/Dockerfile .

	docker buildx build --pull \
	--target builder \
	--cache-to type=inline \
	--cache-from ${REGISTRY}/site-php-fpm:cache-builder \
	--tag ${REGISTRY}/site-php-fpm:cache-builder \
	--file docker/production/php-fpm/Dockerfile .

	docker buildx build --pull \
	--cache-to type=inline \
	--cache-from ${REGISTRY}/site-php-fpm:cache-builder \
	--cache-from ${REGISTRY}/site-php-fpm:cache \
	--tag ${REGISTRY}/site-php-fpm:cache \
	--tag ${REGISTRY}/site-php-fpm:${IMAGE_TAG} \
	--file docker/production/php-fpm/Dockerfile .

	docker buildx build --pull \
	--cache-to type=inline \
	--cache-from ${REGISTRY}/site-php-cli:cache \
	--tag ${REGISTRY}/site-php-cli:cache \
	--tag ${REGISTRY}/site-php-cli:${IMAGE_TAG} \
	--file docker/production/php-cli/Dockerfile .

	docker buildx build --pull \
	--cache-to type=inline \
	--cache-from ${REGISTRY}/site-mysql-backup:cache \
	--tag ${REGISTRY}/site-mysql-backup:cache \
	--tag ${REGISTRY}/site-mysql-backup:${IMAGE_TAG} \
	--file docker/common/mysql-backup/Dockerfile docker/common

	docker buildx build --pull \
	--cache-to type=inline \
	--cache-from ${REGISTRY}/site-files-backup:cache \
	--tag ${REGISTRY}/site-files-backup:cache \
	--tag ${REGISTRY}/site-files-backup:${IMAGE_TAG} \
	--file docker/common/files-backup/Dockerfile docker/common/files-backup

	docker buildx build --pull \
	--cache-to type=inline \
	--cache-from ${REGISTRY}/site-redis:cache \
	--tag ${REGISTRY}/site-redis:cache \
	--tag ${REGISTRY}/site-redis:7.0 \
	--file docker/common/redis/Dockerfile docker/common/redis

try-build:
	REGISTRY=localhost IMAGE_TAG=0 make build

push-build-cache:
	docker push ${REGISTRY}/site:cache-builder
	docker push ${REGISTRY}/site:cache
	docker push ${REGISTRY}/site-php-fpm:cache-builder
	docker push ${REGISTRY}/site-php-fpm:cache
	docker push ${REGISTRY}/site-php-cli:cache
	docker push ${REGISTRY}/site-mysql-backup:cache
	docker push ${REGISTRY}/site-files-backup:cache
	docker push ${REGISTRY}/site-redis:cache

push:
	docker push ${REGISTRY}/site:${IMAGE_TAG}
	docker push ${REGISTRY}/site-php-fpm:${IMAGE_TAG}
	docker push ${REGISTRY}/site-php-cli:${IMAGE_TAG}
	docker push ${REGISTRY}/site-mysql-backup:${IMAGE_TAG}
	docker push ${REGISTRY}/site-files-backup:${IMAGE_TAG}
	docker push ${REGISTRY}/site-redis:7.0

testing-build: testing-build-site-testing-php-cli

testing-build-site-testing-php-cli:
	docker buildx build --pull \
	--cache-to type=inline \
	--cache-from ${REGISTRY}/site-testing-php-cli:cache \
	--tag ${REGISTRY}/site-testing-php-cli:cache \
	--tag ${REGISTRY}/site-testing-php-cli:${IMAGE_TAG} \
	--file docker/testing/php-cli/Dockerfile .

testing-push-build-cache:
	docker push ${REGISTRY}/site-testing-php-cli:cache

testing-init:
	docker compose -f docker-compose-testing.yml up -d
	docker compose -f docker-compose-testing.yml run --rm site-php-cli wait-for-it site-mysql:3306 -t 60
	docker compose -f docker-compose-testing.yml run --rm site-php-cli php bin/app.php migrate --interactive=0
	sleep 15

testing-e2e:
	docker compose -f docker-compose-testing.yml run --rm testing-site-php-cli composer test run acceptance

testing-down-clear:
	docker compose -f docker-compose-testing.yml down -v --remove-orphans

try-testing: try-build try-testing-build try-testing-init try-testing-e2e try-testing-down-clear

try-testing-build:
	REGISTRY=localhost IMAGE_TAG=0 make testing-build

try-testing-init:
	REGISTRY=localhost IMAGE_TAG=0 make testing-init

try-testing-e2e:
	REGISTRY=localhost IMAGE_TAG=0 make testing-e2e

try-testing-down-clear:
	REGISTRY=localhost IMAGE_TAG=0 make testing-down-clear

deploy:
	ssh deploy@${HOST} -p ${PORT} 'rm -rf site_${BUILD_NUMBER} && mkdir site_${BUILD_NUMBER}'

	envsubst < docker-compose-production.yml > docker-compose-production-env.yml
	scp -P ${PORT} docker-compose-production-env.yml deploy@${HOST}:site_${BUILD_NUMBER}/docker-compose.yml
	rm -f docker-compose-production-env.yml

	ssh deploy@${HOST} -p ${PORT} 'mkdir site_${BUILD_NUMBER}/secrets'
	scp -P ${PORT} ${COOKIE_SECRET_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/cookie_secret
	scp -P ${PORT} ${DB_PASSWORD_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/db_password
	scp -P ${PORT} ${DB_ROOT_PASSWORD_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/db_root_password
	scp -P ${PORT} ${REDIS_PASSWORD_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/redis_password
	scp -P ${PORT} ${MAILER_PASSWORD_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/mailer_password
	scp -P ${PORT} ${SENTRY_DSN_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/sentry_dsn
	scp -P ${PORT} ${BACKUP_AWS_SECRET_ACCESS_KEY_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/backup_aws_secret_access_key

	ssh deploy@${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker stack deploy --compose-file docker-compose.yml site --with-registry-auth --prune'

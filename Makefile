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

push-dev-cache:
	docker-compose push

site-init: site-permissions site-composer-install site-assets-install site-wait-db site-wait-redis site-migrations site-fixtures site-test-generate site-assets-build

site-clear:
	docker run --rm -v ${PWD}:/app -w /app alpine sh -c 'rm -rf .ready var/* public/assets/* tests/_output/* tests/_support/_generated/*'
	docker run --rm -v ${PWD}:/app -w /app alpine sh -c 'rm -rf vendor var/.p*'

site-permissions:
	docker run --rm -v ${PWD}:/app -w /app alpine chmod 777 var public/assets public/upload tests/_output tests/_support/_generated

site-composer-install:
	docker-compose run --rm site-php-cli composer install

site-composer-update:
	docker-compose run --rm site-php-cli composer update

site-composer-validate:
	docker-compose run --rm site-php-cli composer validate

site-assets-install:
	docker-compose run --rm site-node-cli yarn install

site-assets-update:
	docker-compose run --rm site-node-cli yarn upgrade

site-wait-db:
	docker-compose run --rm site-php-cli wait-for-it site-mysql:3306 -t 30

site-wait-redis:
	docker-compose run --rm site-php-cli wait-for-it site-redis:6379 -t 30

site-migrations:
	docker-compose run --rm site-php-cli composer app migrate -- --interactive=0

site-fixtures:
	docker-compose run --rm site-php-cli composer app fixture/load '*' -- --interactive=0
	docker-compose run --rm site-php-cli composer app cache/flush cache -- --interactive=0

site-backup-mysql:
	docker-compose run --rm site-mysql-backup

site-backup-upload:
	docker-compose run --rm site-upload-backup

site-ready:
	docker run --rm -v ${PWD}:/app --workdir=/app alpine touch .ready

site-assets-build:
	docker-compose run --rm site-node-cli yarn build

site-lint:
	docker-compose run --rm site-php-cli composer lint
	docker-compose run --rm site-php-cli composer php-cs-fixer fix -- --dry-run --diff

site-cs-fix:
	docker-compose run --rm site-php-cli composer php-cs-fixer fix

site-assets-lint:
	docker-compose run --rm site-node-cli yarn eslint
	docker-compose run --rm site-node-cli yarn stylelint

site-assets-eslint-fix:
	docker-compose run --rm site-node-cli yarn eslint-fix

site-assets-pretty:
	docker-compose run --rm site-node-cli yarn prettier

site-analyze:
	docker-compose run --rm site-php-cli composer psalm -- --no-diff

site-analyze-diff:
	docker-compose run --rm site-php-cli composer psalm

site-test-generate:
	docker-compose run --rm site-php-cli composer test build

site-test:
	docker-compose run --rm site-php-cli composer test run unit,integration,acceptance

build:
	DOCKER_BUILDKIT=1 docker --log-level=debug build --pull --build-arg BUILDKIT_INLINE_CACHE=1 \
	--cache-from ${REGISTRY}/site:cache \
	--tag ${REGISTRY}/site:cache \
	--tag ${REGISTRY}/site:${IMAGE_TAG} \
	--file docker/production/nginx/Dockerfile .

	DOCKER_BUILDKIT=1 docker --log-level=debug build --pull --build-arg BUILDKIT_INLINE_CACHE=1 \
	--cache-from ${REGISTRY}/site-php-fpm:cache \
	--tag ${REGISTRY}/site-php-fpm:cache \
	--tag ${REGISTRY}/site-php-fpm:${IMAGE_TAG} \
	--file docker/production/php-fpm/Dockerfile .

	DOCKER_BUILDKIT=1 docker --log-level=debug build --pull --build-arg BUILDKIT_INLINE_CACHE=1 \
	--cache-from ${REGISTRY}/site-php-cli:cache \
	--tag ${REGISTRY}/site-php-cli:cache \
	--tag ${REGISTRY}/site-php-cli:${IMAGE_TAG} \
	--file docker/production/php-cli/Dockerfile .

	DOCKER_BUILDKIT=1 docker --log-level=debug build --pull --build-arg BUILDKIT_INLINE_CACHE=1 \
	--cache-from ${REGISTRY}/site-mysql-backup:cache \
	--tag ${REGISTRY}/site-mysql-backup:cache \
	--tag ${REGISTRY}/site-mysql-backup:${IMAGE_TAG} \
	--file docker/common/mysql-backup/Dockerfile docker/common

	DOCKER_BUILDKIT=1 docker --log-level=debug build --pull --build-arg BUILDKIT_INLINE_CACHE=1 \
	--cache-from ${REGISTRY}/site-files-backup:cache \
	--tag ${REGISTRY}/site-files-backup:cache \
	--tag ${REGISTRY}/site-files-backup:${IMAGE_TAG} \
	--file docker/common/files-backup/Dockerfile docker/common/files-backup

	DOCKER_BUILDKIT=1 docker --log-level=debug build --pull --build-arg BUILDKIT_INLINE_CACHE=1 \
	--cache-from ${REGISTRY}/site-redis:cache \
	--tag ${REGISTRY}/site-redis:cache \
	--tag ${REGISTRY}/site-redis:6.2 \
	--file docker/common/redis/Dockerfile docker/common/redis

try-build:
	REGISTRY=localhost IMAGE_TAG=0 make build

push-build-cache:
	docker push ${REGISTRY}/site:cache
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
	docker push ${REGISTRY}/site-redis:6.2

deploy:
	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'rm -rf site_${BUILD_NUMBER} && mkdir site_${BUILD_NUMBER}'

	envsubst < docker-compose-production.yml > docker-compose-production-env.yml
	scp -o StrictHostKeyChecking=no -P ${PORT} docker-compose-production-env.yml deploy@${HOST}:site_${BUILD_NUMBER}/docker-compose.yml
	rm -f docker-compose-production-env.yml

	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'mkdir site_${BUILD_NUMBER}/secrets'
	scp -o StrictHostKeyChecking=no -P ${PORT} ${COOKIE_SECRET_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/cookie_secret
	scp -o StrictHostKeyChecking=no -P ${PORT} ${DB_PASSWORD_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/db_password
	scp -o StrictHostKeyChecking=no -P ${PORT} ${REDIS_PASSWORD_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/redis_password
	scp -o StrictHostKeyChecking=no -P ${PORT} ${MAILER_PASSWORD_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/mailer_password
	scp -o StrictHostKeyChecking=no -P ${PORT} ${SENTRY_DSN_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/sentry_dsn
	scp -o StrictHostKeyChecking=no -P ${PORT} ${BACKUP_AWS_SECRET_ACCESS_KEY_FILE} deploy@${HOST}:site_${BUILD_NUMBER}/secrets/backup_aws_secret_access_key

	ssh -o StrictHostKeyChecking=no deploy@${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker stack deploy --compose-file docker-compose.yml site --with-registry-auth --prune'

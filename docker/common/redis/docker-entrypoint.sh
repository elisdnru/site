#!/bin/sh
set -e

if [ ! -z "$REDIS_PASSWORD" ]; then
  echo "user default on >$REDIS_PASSWORD ~* &* +@all" > $HOME/users.acl
  set -- "$@" --aclfile $HOME/users.acl
fi

# first arg is `-f` or `--some-option`
# or first arg is `something.conf`
if [ "${1#-}" != "$1" ] || [ "${1%.conf}" != "$1" ]; then
	set -- redis-server "$@"
fi

# allow the container to be started with `--user`
if [ "$1" = 'redis-server' -a "$(id -u)" = '0' ]; then
	find . \! -user redis -exec chown redis '{}' +
	exec su-exec redis "$0" "$@"
fi

exec "$@"

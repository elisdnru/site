#!/bin/sh
set -e

if [ ! -z "$REDIS_PASSWORD" ]; then
  echo "user default on >$REDIS_PASSWORD ~* &* +@all" > /users.acl
  chmod a+r /users.acl
  set -- "$@" --aclfile /users.acl
fi

exec "$@"

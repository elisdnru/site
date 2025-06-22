#!/bin/sh
set -e

if [ -f "$REDIS_PASSWORD_FILE" ]; then
  export REDIS_PASSWORD="$(cat $REDIS_PASSWORD_FILE)"
  unset REDIS_PASSWORD_FILE
fi

exec "$@"

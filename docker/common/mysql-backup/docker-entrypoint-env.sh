#!/bin/sh
set -e

if [ -f "$MYSQL_PASSWORD_FILE" ]; then
  export MYSQL_PASSWORD="$(cat "$MYSQL_PASSWORD_FILE")"
  unset MYSQL_PASSWORD_FILE
fi

if [ -f "$AWS_SECRET_ACCESS_KEY_FILE" ]; then
  export AWS_SECRET_ACCESS_KEY="$(cat "$AWS_SECRET_ACCESS_KEY_FILE")"
  unset AWS_SECRET_ACCESS_KEY_FILE
fi

exec "$@"

#!/bin/sh
set -e

if [ -f "$AWS_SECRET_ACCESS_KEY_FILE" ]; then
  export AWS_SECRET_ACCESS_KEY="$(cat "$AWS_SECRET_ACCESS_KEY_FILE")"
  unset AWS_SECRET_ACCESS_KEY_FILE
fi

exec "$@"

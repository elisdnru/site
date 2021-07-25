#!/bin/bash

set -o errexit
set -o pipefail

if [ -f "$MYSQL_PASSWORD_FILE" ]; then
  MYSQL_PASSWORD="$(cat "$MYSQL_PASSWORD_FILE")"
fi

if [ -f "$AWS_SECRET_ACCESS_KEY_FILE" ]; then
  AWS_SECRET_ACCESS_KEY="$(cat "$AWS_SECRET_ACCESS_KEY_FILE")"
fi

BACKUP_FILE="${BACKUP_NAME:?}_$(date +%Y-%m-%d_%H-%M).sql.gz"

echo "Dump $BACKUP_FILE"

mysqldump --host="${MYSQL_HOST:?}" --user="${MYSQL_USER:?}" --password="${MYSQL_PASSWORD:?}" \
  --single-transaction "${MYSQL_DB:?}" | gzip -9 > $BACKUP_FILE

echo "Upload to S3"

export AWS_ACCESS_KEY_ID="${AWS_ACCESS_KEY_ID:?}"
export AWS_SECRET_ACCESS_KEY="${AWS_SECRET_ACCESS_KEY:?}"
export AWS_DEFAULT_REGION="${AWS_DEFAULT_REGION:?}"

aws --endpoint-url="${S3_ENDPOINT:?}" s3 cp "$BACKUP_FILE" "s3://${S3_BUCKET:?}/$BACKUP_FILE"

unlink "$BACKUP_FILE"

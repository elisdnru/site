#!/bin/bash

set -o errexit
set -o pipefail

if [ -f "$AWS_SECRET_ACCESS_KEY_FILE" ]; then
  AWS_SECRET_ACCESS_KEY="$(cat "$AWS_SECRET_ACCESS_KEY_FILE")"
fi

BACKUP_FILE="${BACKUP_NAME:?}_$(date +%Y-%m-%d_%H-%M).tar"

echo "Archive $BACKUP_FILE"

tar -cpf "$BACKUP_FILE" "${TARGET:?}"

echo "Upload to S3"

export AWS_ACCESS_KEY_ID="${AWS_ACCESS_KEY_ID:?}"
export AWS_SECRET_ACCESS_KEY="${AWS_SECRET_ACCESS_KEY:?}"
export AWS_DEFAULT_REGION="${AWS_DEFAULT_REGION:?}"
export AWS_ENDPOINT_URL="${S3_ENDPOINT:?}"

aws s3 cp "$BACKUP_FILE" "s3://${S3_BUCKET:?}/$BACKUP_FILE"

unlink "$BACKUP_FILE"

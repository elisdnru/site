#!/bin/bash

set -o errexit
set -o pipefail

if [ -f "$AWS_ACCESS_KEY_ID_FILE" ]; then
  AWS_ACCESS_KEY_ID="$(cat $AWS_ACCESS_KEY_ID_FILE)"
fi

if [ -f "$AWS_SECRET_ACCESS_KEY_FILE" ]; then
  AWS_SECRET_ACCESS_KEY="$(cat $AWS_SECRET_ACCESS_KEY_FILE)"
fi

BACKUP_FILE=site_${BACKUP_NAME}_$(date +%Y-%m-%d_%H-%M).tar

echo "Archive $BACKUP_FILE"

tar -cpf /tmp/$BACKUP_FILE $TARGET

echo "Upload to S3"

export AWS_ACCESS_KEY_ID="$AWS_ACCESS_KEY_ID"
export AWS_SECRET_ACCESS_KEY="$AWS_SECRET_ACCESS_KEY"
aws --endpoint-url=$S3_ENDPOINT s3 cp /tmp/$BACKUP_FILE s3://$S3_BUCKET/$BACKUP_FILE

unlink /tmp/$BACKUP_FILE

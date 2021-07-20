#!/bin/bash

set -o errexit
set -o pipefail

BACKUP_FILE=site_${BACKUP_NAME}_$(date +%Y-%m-%d_%H-%M).tar

echo "Archive $BACKUP_FILE"

tar -cpf /tmp/$BACKUP_FILE $TARGET

echo "Upload to S3"

aws --endpoint-url=$S3_ENDPOINT s3 cp /tmp/$BACKUP_FILE s3://$S3_BUCKET/$BACKUP_FILE

unlink /tmp/$BACKUP_FILE

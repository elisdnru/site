#!/bin/bash

set -o errexit
set -o pipefail

if [ -f "$MYSQL_PASSWORD_FILE" ]; then
  MYSQL_PASSWORD="$(cat $MYSQL_PASSWORD_FILE)"
fi

if [ -f "$AWS_ACCESS_KEY_ID_FILE" ]; then
  AWS_ACCESS_KEY_ID="$(cat $AWS_ACCESS_KEY_ID_FILE)"
fi

if [ -f "$AWS_SECRET_ACCESS_KEY_FILE" ]; then
  AWS_SECRET_ACCESS_KEY="$(cat $AWS_SECRET_ACCESS_KEY_FILE)"
fi

DUMP_FILE=site_mysql_$(date +%Y-%m-%d_%H-%M).sql.gz

echo "Dump $DUMP_FILE"

mysqldump --host=$MYSQL_HOST --user=$MYSQL_USER --password=$MYSQL_PASSWORD --single-transaction $MYSQL_DB | gzip -9 > $DUMP_FILE

echo "Upload to S3"

export AWS_ACCESS_KEY_ID="$AWS_ACCESS_KEY_ID"
export AWS_SECRET_ACCESS_KEY="$AWS_SECRET_ACCESS_KEY"
aws --endpoint-url=$S3_ENDPOINT s3 cp $DUMP_FILE s3://$S3_BUCKET/$DUMP_FILE

unlink $DUMP_FILE

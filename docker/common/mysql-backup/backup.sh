#!/bin/bash

set -o errexit
set -o pipefail

DUMP_FILE=site_mysql_$(date +%Y-%m-%d_%H-%M).sql.gz

echo "Dump $DUMP_FILE"

mysqldump --host=$MYSQL_HOST --user=$MYSQL_USER --password=$MYSQL_PASSWORD --single-transaction $MYSQL_DB | gzip -9 > $DUMP_FILE

echo "Upload to S3"

aws --endpoint-url=$S3_ENDPOINT s3 cp $DUMP_FILE s3://$S3_BUCKET/$DUMP_FILE

unlink $DUMP_FILE

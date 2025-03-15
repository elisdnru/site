FROM alpine:3.21

RUN apk add --no-cache bash aws-cli

RUN apk add --no-cache coreutils mariadb-client

RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app

COPY ./wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod 555 /usr/local/bin/wait-for-it

COPY ./mysql-backup/backup.sh /usr/local/bin/backup
RUN chmod 555 /usr/local/bin/backup

CMD ["backup"]

WORKDIR /app

RUN chown app:app /app

USER app

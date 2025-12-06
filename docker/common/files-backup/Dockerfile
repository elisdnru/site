FROM alpine:3.23

RUN apk add --no-cache aws-cli

RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app

COPY ./docker-entrypoint-env.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint-env.sh

ENTRYPOINT ["docker-entrypoint-env.sh"]

COPY ./backup.sh /usr/local/bin/backup
RUN chmod 555 /usr/local/bin/backup

CMD ["backup"]

WORKDIR /app

RUN chown app:app /app

USER app

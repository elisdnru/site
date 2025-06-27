FROM alpine:3.22

RUN apk add --no-cache bash aws-cli

RUN addgroup -g 1000 app && adduser -u 1000 -G app -s /bin/sh -D app

COPY ./backup.sh /usr/local/bin/backup
RUN chmod 555 /usr/local/bin/backup

CMD ["backup"]

WORKDIR /app

RUN chown app:app /app

USER app

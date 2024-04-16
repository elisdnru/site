FROM alpine

RUN apk add --no-cache bash aws-cli

COPY ./backup.sh /usr/local/bin/backup
RUN chmod 555 /usr/local/bin/backup

WORKDIR /app

CMD ["backup"]

FROM alpine:3.14

RUN apk add --no-cache python3 py3-pip bash \
    && pip3 install --upgrade awscli

COPY ./backup.sh /usr/local/bin/backup
RUN chmod 555 /usr/local/bin/backup

WORKDIR /app

CMD ["backup"]

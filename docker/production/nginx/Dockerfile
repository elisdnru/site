FROM nginx:1.21-alpine

RUN apk add --no-cache curl

COPY ./docker/common/nginx/snippets /etc/nginx/snippets
COPY ./docker/common/nginx/conf.d /etc/nginx/conf.d

WORKDIR /app

COPY ./public ./public

HEALTHCHECK --interval=30s --timeout=3s --start-period=5s CMD curl --fail http://127.0.0.1/health || exit 1

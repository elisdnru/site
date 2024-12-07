FROM node:22-alpine3.20 as builder

WORKDIR /app

COPY ./package.json ./yarn.lock ./
RUN yarn install && yarn cache clean

COPY ./ ./
RUN yarn build

FROM nginx:1.27-alpine3.20

RUN apk add --no-cache curl

COPY ./docker/common/nginx/snippets /etc/nginx/snippets
COPY ./docker/common/nginx/conf.d /etc/nginx/conf.d

WORKDIR /app

COPY --from=builder /app/public/build ./public/build
COPY ./public ./public

HEALTHCHECK --interval=10s --timeout=3s --start-period=10s CMD curl --fail http://127.0.0.1/health || exit 1

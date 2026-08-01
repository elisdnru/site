FROM node:26-alpine3.23

ENV COREPACK_ENABLE_DOWNLOAD_PROMPT=0

RUN npm install -g corepack && corepack enable && corepack prepare yarn@4.18.0 --activate

RUN apk add --no-cache shadow

ARG UID=1000
ARG GID=1000

RUN groupmod -g "${GID}" node && usermod -u "${UID}" node && chown node:node /home/node

WORKDIR /app

USER node

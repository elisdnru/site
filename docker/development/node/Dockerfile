FROM node:26-alpine3.23

RUN npm install -g yarn

RUN apk add --no-cache shadow

ARG UID=1000
ARG GID=1000

RUN groupmod -g "${GID}" node && usermod -u "${UID}" node && chown node:node /home/node

WORKDIR /app

USER node

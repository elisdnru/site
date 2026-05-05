FROM nginx:1.29-alpine3.23

COPY ./common/nginx/docker-entrypoint-nginx-conf.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint-nginx-conf.sh

ENTRYPOINT ["docker-entrypoint-nginx-conf.sh", "/docker-entrypoint.sh"]
CMD ["nginx", "-g", "daemon off;"]

COPY ./common/nginx/snippets /etc/nginx/snippets
COPY ./common/nginx/conf.d /etc/nginx/conf.d

WORKDIR /app

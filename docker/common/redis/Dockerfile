FROM redis:7.0-alpine3.20

COPY docker-entrypoint-env.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint-env.sh

COPY docker-entrypoint-acl.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint-acl.sh

ENTRYPOINT ["docker-entrypoint-env.sh", "docker-entrypoint-acl.sh", "docker-entrypoint.sh"]

CMD ["redis-server"]

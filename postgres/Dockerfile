FROM postgres:14

ENV POSTGRES_DB=php_login
ENV POSTGRES_USER=postgres
ENV POSTGRES_PASSWORD=admin
COPY postgres/init.sql /docker-entrypoint-initdb.d/

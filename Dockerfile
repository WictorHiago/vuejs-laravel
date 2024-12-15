FROM postgres:15-alpine

# Configurações do PostgreSQL
ENV POSTGRES_DB=laravel_db
ENV POSTGRES_USER=postgres
ENV POSTGRES_PASSWORD=postgres

# Expor a porta padrão do PostgreSQL
EXPOSE 5432

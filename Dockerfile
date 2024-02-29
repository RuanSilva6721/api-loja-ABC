# Imagem base do PHP 8.1
FROM php:8.1-fpm

# Instala as dependências necessárias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_pgsql zip


# Copia os arquivos do projeto para o contêiner
COPY . /var/www/html


# Instala as dependências do Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Copia o arquivo de configuração do PostgreSQL para o local correto
COPY pg_hba.conf /etc/postgresql/13/main/pg_hba.conf

# Copia o script SQL para a inicialização do banco de dados
COPY init.sql /docker-entrypoint-initdb.d/

# Expõe a porta 9003
EXPOSE 9003

CMD ["bash", "-c", "composer install && php artisan serve --host 0.0.0.0 --port 9003"]

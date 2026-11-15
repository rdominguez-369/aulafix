
# ==============================================
# AULAFIX - DOCKERFILE
# ==============================================

# PASO 1: Utilizar PHP 8.3 con Apache.
FROM php:8.3-apache

# PASO 2: Instalar la extensión PDO para MySQL.
# Esta extensión permitirá conectar PHP con
# nuestra base de datos MySQL 8.
RUN docker-php-ext-install pdo_mysql

# PASO 3: Habilitar el módulo rewrite de Apache.
# Permitirá utilizar reglas de reescritura
# de direcciones si las necesitamos.
RUN a2enmod rewrite

# PASO 4: Establecer el directorio de trabajo.
WORKDIR /var/www/html

# PASO 5: Exponer el puerto HTTP del contenedor.
EXPOSE 80

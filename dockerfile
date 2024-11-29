# Usar una imagen oficial de PHP con Apache
FROM php:7.4-apache

# Habilitar mod_rewrite en Apache (si es necesario)
RUN a2enmod rewrite

# Establecer el directorio de trabajo dentro del contenedor
WORKDIR /var/www/html

# Copiar todos los archivos del proyecto al contenedor
COPY . /var/www/html/

# Establecer permisos adecuados para los archivos copiados (si es necesario)
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto en el que Apache escuchará
EXPOSE 80

# Comando para iniciar Apache en primer plano
CMD ["apache2-foreground"]

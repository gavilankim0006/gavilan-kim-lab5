FROM php:8.2-apache

RUN a2enmod rewrite \
 && docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/

# Ensure the entrypoint is executable (git mode can regress on Windows checkouts)
RUN chmod +x /var/www/html/docker/entrypoint.sh

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
 && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
 && printf '<Directory ${APACHE_DOCUMENT_ROOT}>\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n' >> /etc/apache2/apache2.conf

RUN mkdir -p /var/www/html/runtime/{cache,logs,session} \
 && chown -R www-data:www-data /var/www/html/runtime

EXPOSE 80
ENTRYPOINT ["/var/www/html/docker/entrypoint.sh"]

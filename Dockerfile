FROM php:8.2-apache

# LavaLust needs URL rewriting for its routing
RUN a2enmod rewrite

# MySQL support
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy your project in
COPY . /var/www/html/

# LavaLust's entry point lives in public/, so that's the doc root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Allow .htaccess to actually work
RUN printf '<Directory ${APACHE_DOCUMENT_ROOT}>\n\tAllowOverride All\n</Directory>\n' >> /etc/apache2/apache2.conf

# Make sure runtime/ is writable (cache, logs)
RUN chown -R www-data:www-data /var/www/html/runtime

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

CMD ["/entrypoint.sh"]
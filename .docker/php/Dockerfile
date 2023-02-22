FROM php:7.4-apache

RUN apt-get update -y && apt-get install -y \
git \
zip \
curl \
sudo \
unzip \
libicu-dev \
libbz2-dev \
libpng-dev \
libjpeg-dev \
libmcrypt-dev \
libreadline-dev \
libfreetype6-dev \
g++ \
nodejs \
npm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN a2enmod rewrite

ENV APACHE_LOG_DIR=/var/log/apache2
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN echo "LogLevel debug" >> /etc/apache2/apache2.conf

# Install and enable xdebug.
RUN pecl install xdebug && docker-php-ext-enable xdebug

USER www-data

COPY --chown=www-data:www-data ./.docker/php/php.ini /usr/local/etc/php/conf.d/custom.php.ini
COPY --chown=www-data:www-data ./src /var/www/html
WORKDIR /var/www/html

# Add correct rights for www folder.
#RUN chown -R www-data:www-data /var/www/

RUN cd /var/www/html
RUN composer install

RUN php artisan config:cache
RUN php artisan key:generate

#CMD ["php-fmp artisan serve --host=0.0.0.0 --port=80"]

EXPOSE 80 443

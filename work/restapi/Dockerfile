# FROM php:8.0-apache
# RUN apt update
# RUN apt install libcurl4-openssl-dev pkg-config libssl-dev unzip -y
# RUN pecl install mongodb
# RUN docker-php-ext-enable mongodb.so
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN composer require --working-dir=/var/www mongodb/mongodb
FROM php:8.2.0-apache
# ADD /restapi/ /var/www/html/
# ADD /src/ /var/www/html/
# 1. Configure db management
RUN apt-get update -y && apt-get install -y libmariadb-dev
# 2. Install mysqli
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
# 3. Install mongo
RUN apt install libcurl4-openssl-dev pkg-config libssl-dev unzip -y  \
&& pecl install mongodb && docker-php-ext-enable mongodb.so
# 4. Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \ 
&& composer require --working-dir=/var/www mongodb/mongodb
EXPOSE 80

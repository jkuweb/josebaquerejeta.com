FROM  php:8.1-fpm-buster

ARG UID
ARG TIMEZONE

RUN adduser -u ${UID} --disabled-password --gecos "" joseba
RUN mkdir /home/joseba/.ssh
RUN chown -R joseba:joseba  /home/joseba/
RUN echo "StrictHostKeyChecking no" >> /home/joseba/.ssh/config
RUN echo "alias sf=/appdata/www/bin/console" >> /home/joseba/.bashrc

RUN apt update && apt install -y \
	gnupg \
	procps \
	openssl \
	wget \
	vim \
	unzip \
	git \
	libonig-dev \
	libxslt1-dev \
	zlib1g-dev \
	libzip-dev \
	libxml2-dev \
	libicu-dev \
	libpng-dev \
	acl \
	libjpeg-dev \
	libfreetype6-dev 

RUN docker-php-ext-install \
	intl pdo zip pdo_mysql xsl opcache exif mbstring

 # Install and update composer
RUN curl https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
RUN composer self-update

# Install Symfony binary
USER joseba
RUN wget https://get.symfony.com/cli/installer -O - | bash
#RUN mv /home/joseba/.symfony*/ /home/joseba/.symfony
USER root 
RUN mv  /home/joseba/.symfony5/bin/symfony /usr/local/bin/symfony	

# Set timezone
#RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
#    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
#    && "date"

RUN mkdir -p /appdata/www

WORKDIR /appdata/www


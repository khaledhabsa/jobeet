FROM php:8.1.2
# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libzip-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libmcrypt-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl
RUN apt-get update -y && apt-get install -y openssl zip unzip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer 
RUN docker-php-ext-install pdo_mysql zip exif pcntl
RUN docker-php-ext-configure  gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd
WORKDIR /app
COPY . /app
RUN composer update
RUN composer require predis/predis
RUN php artisan key:generate

# Migrate each module individually as needed
RUN php artisan module:migrate Company
RUN php artisan module:migrate Users
RUN php artisan module:migrate Jobs

# Migrate core component 
RUN php artisan migrate

# Seed DB with test data 
$ php artisan db:seed

#RUN php artisan passport:install
RUN php artisan optimize
CMD php artisan serve --host=0.0.0.0 --port=80
EXPOSE 80
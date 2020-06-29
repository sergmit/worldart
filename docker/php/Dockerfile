FROM crunchgeek/php-fpm:7.3

#RUN apt-get update && apt-get install -y wget
#RUN wget https://get.symfony.com/cli/installer -O - | bash
#RUN export PATH="$HOME/.symfony/bin:$PATH"
#RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

RUN composer create-project --prefer-dist laravel/laravel
WORKDIR /var/www
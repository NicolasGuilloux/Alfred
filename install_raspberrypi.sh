#!/bin/bash

# Autheur: Nicolas Guilloux
# Website: https://nicolasguilloux.eu/
# Email:   novares.x@gmail.com

# Based on this tutorial: https://medium.com/@roniemeque/using-raspberry-pi-for-laravel-developing-30dabcdeba43

# Install the dependancies

    # Nginx
    sudo apt-get install nginx
    sudo /etc/init.d/nginx start

    # Install PHP
    sudo apt install php7.1 php7.1-curl php7.1-gd php7.1-imap php7.1-json php7.1-mcrypt php7.1-mysql php7.1-opcache php7.1-xmlrpc php7.1-xml php7.1-fpm php7.1-zip php7.1-mbstring -y

    # Install Composer
    curl -sS https://getcomposer.org/installer | php
    sudo mv composer.phar /usr/local/bin/composer

    # Install MariaDB
    sudo apt install mariadb-server mariadb-client -y

    dbPasswd=$(date +%s | sha256sum | base64 | head -c 32 ; echo)
    dbPasswd=alfredPasswd

    # CREATE DATABASE alfred;
    # CREATE USER 'alfred'@'localhost' IDENTIFIED BY '$dbPasswd';
    # GRANT ALL PRIVILEGES ON * . * TO 'alfred'@'localhost';
    # FLUSH PRIVILEGES;

    sudo mysql --host=localhost --user=root -e "CREATE DATABASE alfred; CREATE USER 'alfred'@'localhost' IDENTIFIED BY '$dbPasswd'; GRANT ALL PRIVILEGES ON alfred.* TO 'alfred'@'localhost'; FLUSH PRIVILEGES;" -p

    # Install NodeJS
    curl -sL https://deb.nodesource.com/setup_8.x | sudo -E bash -
    sudo apt install nodejs



# Edit the configuration of Nginx
echo "Create a new Nginx website with the following configuration:"
nginxConfig="server {
    # Listen to the http://
    listen 80 default_server;
    listen [::]:80 default_server;

    # Root directory
    root $PWD/public;

    # Add index.php to the list if you are using PHP
    index index.php;

    server_name Alfred;

    location / {
        # First attempt to serve request as file, then
        # as directory, then fall back to displaying a 404.
        try_files \$uri \$uri/ /index.php\$is_args\$args;
    }

    # PHP files
    location ~ \.php$ {
        try_files \$uri /index.php =404;

        # With php-fpm (or other unix sockets):
        fastcgi_pass unix:/var/run/php/php7.1-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }
}"
echo "$nginxConfig" | sudo tee /etc/nginx/sites-available/alfred

# Disable all websites
sudo rm /etc/nginx/sites-enabled/*

# Enable Alfred
sudo ln -s /etc/nginx/sites-available/alfred /etc/nginx/sites-enabled/
sudo service nginx restart

# Add rights for the pi user to edit the website
sudo groupadd www-data
sudo gpasswd -a pi www-data
sudo chown www-data:www-data -R *
sudo chmod 754 -R *
sudo chmod 774 -R storage

# Update the project dependancies
composer update --no-scripts

# Update the .env file
echo "New .env file:"
envConfig="APP_NAME=Alfred
APP_LONG_NAME=\"Alfred, the sustainable butler\"
APP_ENV=prod
APP_KEY=base64:PAX3Jys9BQY5zDQ0rwSMHLIMAm7ysiTg/hx7Ax9sYtY=
APP_DEBUG=false
APP_URL=http://alfred.nicolasguilloux.eu

LOG_CHANNEL=stack

ACCUWHEATER_KEY=bFNH6oFTRa0bhpn8pvgqM1qroqB2gxVA

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alfred
DB_USERNAME=alfred
DB_PASSWORD=$dbPasswd

BROADCAST_DRIVER=log
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_DRIVER=sync

MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null"

echo "$envConfig" | sudo tee .env

# Install the Database
php artisan migrate:fresh --seed

# Create a link to the storage
sudo php artisan storage:link

exit 0;

#!/bin/bash

echo "Installing..."

sudo apt-get install apache2

sudo apt-get install mysql-server libapache2-mod-auth-mysql php5-mysql

sudo apt-get install php5 php5-cgi php5-cli php5-curl php5-dbg php5-dev php5-gd php5-intl php5-json php5-mysql php5-mcrypt php5-xdebug libapache2-mod-php5

sudo mysql_install_db
sudo /usr/bin/mysql_secure_installation


sudo printf '<IfModule mod_dir.c>\n          DirectoryIndex index.php index.html index.cgi index.pl index.xhtml index.htm\n</IfModule>' > /etc/apache2/mods-enabled/dir.conf

sudo service apache2 restart

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"

cd $DIR

sudo chmod -R 777 $DIR

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === '92102166af5abdb03f49ce52a40591073a7b859a86e8ff13338cf7db58a19f7844fbc0bb79b2773bf30791e935dbd938') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

php composer.phar update

sudo chmod -R 777 $DIR

sudo a2enmod rewrite
sudo cp $DIR/.company-management.com.conf_dev /etc/apache2/sites-available/company-management.com.conf
sudo printf "127.0.1.1       $(hostname)\n127.0.0.1  localhost\n127.0.0.1       company-management.com\n::1     ip6-localhost ip6-loopback\nfe00::0 ip6-localnet\nff00::0 ip6-mcastprefix\nff02::1 ip6-allnodes\nff02::2 ip6-allrouters" > /etc/hosts
sudo a2ensite company-management.com.conf

sudo service apache2 restart

echo "Done, if the script did everything correctly, you should see project start page at company-management.com"

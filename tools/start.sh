#! /bin/sh

#/Users/akalend/sbin/php-fpm start 
spawn-fcgi -p 9000  -n  -f   php-cgi &
sudo /usr/local/nginx/sbin/nginx 

/usr/local/mysql/bin/mysqld_safe --user=akalend  & 

memcached -d

sudo /usr/local/bin/searchd
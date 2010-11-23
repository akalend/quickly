#! /bin/sh

#/Users/akalend/sbin/php-fpm start 
spawn-fcgi -p 9000  -n  -f   php-cgi &
sudo /usr/local/nginx/sbin/nginx 

sudo /opt/local/share/mysql5/mysql/mysql.server start

sudo /Users/akalend/dist/mongodb-osx-i386-2010-02-19/mongo/mongod &

memcached -d

sudo /usr/local/bin/searchd
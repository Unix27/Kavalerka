`/opt/php73/bin/php /usr/local/bin/composer require laravel/horizon`

`/opt/php73/bin/phpize ./configure --with-php-config=/opt/php73/bin/php-config make && make install && make clean`

`touch /opt/php73/etc/mods-available/redis.ini`

`echo "extension=/opt/php73/lib/php/modules/redis.so" > /opt/php73/etc/mods-available/redis.ini`

`<LocationMatch "/cabinet/*"> 
        allow from all 
        Satisfy any 
        ProxyPass http://localhost:3000/
        ProxyPassReverse http://localhost:3000/
</LocationMatch>`



supervisorctl

supervisorctl reread

supervisorctl update

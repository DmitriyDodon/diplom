#!/bin/sh
/usr/bin/composer install 
/usr/bin/printf "yes\n" | /usr/local/bin/php /app/bin/console doctrine:migrations:migrate


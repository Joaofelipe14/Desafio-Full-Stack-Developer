php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan queue:failed
php artisan queue:retry all
php artisan queue:work --tries=3 --delay=10 --sleep=3 --verbose

php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan queue:failed
php artisan queue:retry all
php artisan queue:work --tries=3 --delay=10 --sleep=3 --verbose

joaofelipe@Joao-nitro:~/Área de trabalho/Huggy teste/docker$ sudo docker run --net=host -it -e NGROK_AUTHTOKEN=2lOUWFQSMbQzRKNulty26KUtNP9_7EmMQQmEou8CX8Aq6txU1 ngrok/ngrok:latest http 8000

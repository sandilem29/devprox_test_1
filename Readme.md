#This should detail all the necessary steps to run the application
# credits to stackoverflow and https://daveismyname.blog/laravel-import-large-csv-file for sharing some lights
#requires php 7.1 or later to run properly

#installation
Clone the repo.
Run composer install -> to make sure all dependencies are there.
cp .env.example to .env.
Setup up your mysql server credentials.
run php artisan config:clear
run php artisan serve optionally you can specify the port eg. "php artisan serve --port 8001"

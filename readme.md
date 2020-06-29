## Комманды

Старт
````
make start
````

Рестарт
````
make restart
````

Console
````
make bash
composer install
````

Создать таблицы в базе данных
````
php console/app.php migration
````

Получить данные
````
php console/app.php parse
````

Очистить кэш
````
php console/app.php cache --clear
````

## Используемые библиотеки

PHP:
* fabpot/goutte": "^4.0",
* "predis/predis": "^1.1",
* "twig/twig": "^3.0",
* "illuminate/database": "^7.17"

Frontend:
* Bootstrap: 4.5
* Jquery: 3.5

Время: 40ч
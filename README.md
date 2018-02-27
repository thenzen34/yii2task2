Yii2Task2
==================

Тестовое задание


УСТАНОВКА
---------

Скачать проект

    git clone https://github.com/thenzen34/yii2task2.git
    
Установить зависимости
    
    composer install
    
НАСТРОЙКА
--------

Указать настройки для подключения к БД в файле config/db-local.php по примеру db-local.sample.php

```php
return [
    'components' => [
        'db' => [
            'username' => '...',
            'password' => '...',
        ],
    ],
];
```

Запустить миграцию

    php yii migrate
    
Сгенерировать статические данные о бонусах и менеджерах

    php job/init
    
Сгенерировать за последние пол года стату по разговорам
    
    php job/generate


УПРАВЛЕНИЕ
--------

Создание звонков

    Admin -> Managers -> View -> Create Call
    
Статистика
--------

Агрегация данных идет сторедом, вызов которого происходит по крону

    php jobs/calc-by-day
    php jobs/calc-by-month
Yii2Task2
==================

Тестовое задание


УСТАНОВКА
---------

Скачать проект

    git clone https://github.com/thenzen34/yii2task2.git
    
Установить зависимости
    
    composer install

Дать права 777 на папки web/assets и runtime

    chmod 777 web/assets
    chmod 777 runtime
    
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

Возможно сгенерировать стату заново и в других объемах

    php job/generate 7000

УПРАВЛЕНИЕ
--------

Создание звонков в течении дня

    Admin -> Managers -> View -> Create Call
    
Статистика
--------

Агрегация данных идет сторедом, вызов которого происходит по крону

    php jobs/calc-by-day
    php jobs/calc-by-month
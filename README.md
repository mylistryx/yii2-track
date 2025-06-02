<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic Project Template</h1>
    <br>
</p>

Yii 2 Basic Project Template is a skeleton [Yii 2](https://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

[![Latest Stable Version](https://img.shields.io/packagist/v/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![Total Downloads](https://img.shields.io/packagist/dt/yiisoft/yii2-app-basic.svg)](https://packagist.org/packages/yiisoft/yii2-app-basic)
[![build](https://github.com/yiisoft/yii2-app-basic/workflows/build/badge.svg)](https://github.com/yiisoft/yii2-app-basic/actions?query=workflow%3Abuild)

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources

Краткая документация
------------------

Собрать контейнеры
``````
docker compose up -d
``````
Обновить зависимости composer
``````
docker exec -it app composer install
``````

Применить миграции
``````
docker exec -it app yii migrate --interactive=0
``````
Применить миграции для тестов
``````
docker exec -it app yii_test migrate --interactive=0
``````
Запустить тесты
``````
docker exec -it app codecept build && codecept run
``````
Web интерфейс (ссылка на панели вверху):

``````
http://localhost:8000
``````

В гриде фильтры - id, status - строгое соответствие. track_number - LIKE, на нем уникальный индекс на уровне БД, так что
сильно те затупляет. Пробовал загнать 100 000 000 записей, ~2 секунд подбор. Если упрется - поле дробить на части по
маске и далее играть с индексами, либо поисковый движок типа manticore.

REST API:

````````
GET http://localhost:8000/api/track?access-token=100-token
````````

POST/PUT/PATCH/DELETE/OPTIONS - в соответствии с документацией к REST в
Yii2 https://www.yiiframework.com/doc/guide/2.0/ru/rest-quick-start

Авторизация через Bearer token или query string.

Фильтрация так же в соответствии с документацией
Yii2 https://www.yiiframework.com/doc/guide/2.0/en/rest-filtering-collections:

По нескольким значениям

``````
http://localhost:8000/api/track?access-token=100-token&filter[status][in][]=new&filter[status][in][]=failed
``````

По строгому соответствию

``````
http://localhost:8000/api/track?access-token=100-token&filter[status][eq]=new
``````

Логирование изменений Track происходит через Yii Event. Если понадобится добавить лог еще какой, добавляем handler и
всё. Модель базовая чиста, никаких beforeUpdate, afterUpdate и иже с ними.
Просмотр лога при детальном просмотре или через extraFields в API. Можно было сделать на уровне БД и триггеров, но на
практике с этим были только проблемы, проще на уровне кода.

``````
http://localhost:8000/api/tracks/1?access-token=100-token&expand=changeLog (Предварительно для первой записи нагенерено несколько произвольных изменений)
``````

Массовые изменения сделал на уровне контроллера. В идеале перенести в экшен, добавить filter как для index, и апдейтить
все, что попало под фильтр. Долго!
Динамическая модель валидирует входяще данные, далее в цикле правим значение (если через batch - Event не отработает и в
логе будет пусто).

Пример запроса для штормовского http клиента:

``````
PUT http://localhost:8000/api/track/update-multiple
Content-Type: application/json

{
"id": [1,2,3,4,5,6,7,8,9,10,100,200,300,500],
"status": "failed"
}

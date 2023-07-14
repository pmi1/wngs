vernal
=============================

A Symfony project created on October 13, 2016, 4:46 pm.


УСТАНОВКА
------------

### Подготовка рабочей среды

###### Установка symfony

	$ sudo mkdir -p /usr/local/bin
	$ sudo curl -LsS https://symfony.com/installer -o /usr/local/bin/symfony
	$ sudo chmod a+x /usr/local/bin/symfony

Актуальная документация по установке symfony может быть найдена здесь:
https://symfony.com/doc/current/setup.html#creating-symfony-applications

###### Установка Composer

	php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
	php -r "if (hash_file('SHA384', 'composer-setup.php') === 'aa96f26c2b67226a324c27919f1eb05f21c248b987e6195cad9690d5c1ff713d53020a02ac8c217dbf90a7eacc9d141d') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
	php composer-setup.php
	php -r "unlink('composer-setup.php');"

Актуальная документация по установке composer может быть найдена здесь:
https://getcomposer.org/download/

### Настройка веб-сервера

При использовании веб-сервера в качестве директории хоста необходимо указать директорию web, а не корень проекта.

Также проект можно запустить в качестве службы:
php bin/console server:run
По-умолчанию сайт будет доступен на 8000 порту.

### Настройка конфигурационных файлов

На основе файла app\config\parameters.yml.dist необходимо создать файл app\config\parameters.yml

Параметры:

	database_host: <хост базы данных>
	database_port: <порт> 
	database_name: <название базы данных>
	database_user: <имя пользователя БД>
	database_password: <пароль пользователя БД>
    admin_mail: <email администратора>
    sender_mail: <email с которого будут отправляться письма>
    mailer_transport: mail <или другой вид отправки, настроенный на сервере. Например smtp или sendmail>

### Перед запуском сайта необходимо произвести миграцию базы данных

	php bin/console doctrine:migrations:migrate

В ходе выполнения миграций создается дефолтный административный аккаунт.
Логин: vernal_u
Пароль: 1234

### Установка Elastic Search

1. Скачиваем elasticsearch версии 5.3.0

	curl -L -O https://artifacts.elastic.co/downloads/elasticsearch/elasticsearch-5.3.0.tar.gz

2. Для запуска Elasticsearch возможно потребуется обновить Java JDK до 8-й версии

	http://www.oracle.com/technetwork/java/javase/downloads/index.html
	rpm -Uvh jdk-8u121-linux-x64.rpm

3. Распаковываем elasticsearch

	tar -xzf elasticsearch-5.3.0.tar.gz

4. Настраиваем конфиг elasticsearch-5.3.0/config/elasticsearch.yml для возможности обращения к движку извне

	http.cors.enabled: true
	http.cors.allow-origin: "*"
	http.host: <домен сайта>
	http.port: 9200

5. Запуск elastic в качестве демона

	cd elasticsearch-5.3.0/bin
	./elasticsearch -d

6. Возможные проблемы при запуске elastic, связанные с настройками операционной системы

	/etc/security/limits.conf
	    vernal  -  nofile  65536
	    vernal  -  nproc  2048

	/etc/sysctl.conf
	    vm.max_map_count=262144

ПРИ НЕОБХОДИМОСТИ ПОЛНОЙ ПЕРЕСБОРКИ ИНДЕКСОВ ELASTIC SEARCH
------------

	php bin/console fos:elastica:populate

ЗАПУСК КОРРЕКТИРОВЩИКА КОДА
------------

	php php-cs-fixer fix /path/to/project --level=symfony


ПОДГОТОВКА К ЗАПУСКУ WEBPACK
------------

Необходимые версии программного обеспечения:

	npm - ^3.10.10
	node - ^6.9.5
	webpack - ^2.2.1

Предварительно требуется установка (из директории webpack): 

	npm install ts-loader
	npm install typescript -g

ЗАПУСК СБОРКИ ЧЕРЕЗ MABA WEBPACK
------------

	php bin/console maba:webpack:compile

Результат сборки будет размещен в директории web/dist

ГЕНЕРАЦИЯ FIXTURES
------------

	php bin/console vernal:faker

ЗАПУСК ТЕСТОВ
------------

Предварительно требуется установка PHPUnit:
https://phpunit.de/manual/current/en/installation.html#installation.phar

Запуск тестов из корня проекта

	phpunit -c phpunit.xml.dist

CRON
------------

	3 * * * * php <путь до корня проекта>bin/console vernal:clinicratingcalc
    4 * * * * php <путь до корня проекта>bin/console vernal:diseaseratingcalc
	5 * * * * php <путь до корня проекта>bin/console fos:elastica:populate
    9 * * * * php <путь до корня проекта>bin/console vernal:clearcompare
    10 */2 * * * php <путь до корня проекта>bin/console vernal:remixlastrequest

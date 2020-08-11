# Yii2 eXeCUT CMS
## Установка

Самый простой способ установки - это установка поверх приложения на базе [yiisoft/yii2-app-advanced](https://github.com/yiisoft/yii2-app-advanced).
Для установки Yii2 CMS в свой проект необходимо произвести всего три шага:
1. Подключите пакет CMS-а 
   1. Если у вас уже существующий проект, то подключить пакет можно путём запуска команды ```composer require execut/yii2-cms```.
   1. Если вы собираетесь разворачивать Yii2 CMS на новом приложении, то можете установить установить зараннее подготовленный проект-шаблон
   [execut/yii2-cms-advanced-template](https://github.com/execut/yii2-cms-advanced-template/). Инструкция установки [здесь](https://github.com/execut/yii2-cms-advanced-template/blob/master/docs/guide/start-installation.md).
1. Примените миграции ``` ./yii migrate/up --interactive 0```
1. Создайте пользователя-администратора командой ```./yii cms/users/create-admin admin password email@example.com```,
где: admin - логин, password - пароль, email@example.com - email пользователя

## Использование
Если вы использовали в backend и frontend-приложениях стандартные слои в директориях layouts/main.php, то после установки CMS они должны переопределиться.
В этих слоях выводится весь контент CMS.
Если этого не произошло, то значит вы используете нестандартные слои и CMS не переназначил их, думая, что вы хотите использовать свои.
Чтобы использовать свой слой, необходимо в нём вывести все элементы для работы CMS по подобию этих двух: 
[frontend.php](https://github.com/execut/yii2-cms/blob/master/views/layouts/frontend.php) и
[backend.php](https://github.com/execut/yii2-cms/blob/master/views/layouts/backend.php).

В backend-приложении должны начать выводиться разделы и появиться меню:
![i/backend-pages.jpg](https://raw.githubusercontent.com/execut/yii2-cms/master/docs/guide-ru/i/backend-pages.jpg)

При этом frontend-приложение должно показывать страницы вместе с меню:
![i/backend-pages.jpg](https://raw.githubusercontent.com/execut/yii2-cms/master/docs/guide-ru/i/frontend-page.jpg)
# eXeCUT Yii2 CMS
Warning! Beta version. Please add tasks [here](https://github.com/execut/yii2-cms/issues) if you find errors. I will try to fix them quickly

CMS, based on Yii2 modular system and extension [yii2-crud-fields](https://github.com/execut/yii2-crud-fields/). All system modules are standalone Yii2 modules and can be used separately from CMS.

List of system features and modules:

Feature | Module | Extended by modules | Development status
-------------------- | ----------- | -------------- | ------
Aliases for urls of records like page and logging their changes | [execut/yii2-alias](http://github.com/execut/yii2-alias) | yii2-files, yii2-images, yii2-news, yii2-pages, yii2-shops | ![Complete](https://img.shields.io/packagist/v/execut/yii2-alias.svg?color=green&label=%20)
Goods | [execut/yii2-goods](http://github.com/execut/yii2-goods) | yii2-files, yii2-pages | ![Complete](https://img.shields.io/packagist/v/execut/yii2-goods.svg?color=green&label=%20)
Files | [execut/yii2-files](http://github.com/execut/yii2-files) | yii2-alias, yii2-goods, yii2-images, yii2-pages, yii2-seo |  ![Complete](https://img.shields.io/packagist/v/execut/yii2-seo.svg?color=green&label=%20)
Images | [execut/yii2-images](http://github.com/execut/yii2-images) | yii2-files | ![Complete](https://img.shields.io/packagist/v/execut/yii2-files.svg?color=green&label=%20)
Menus | [execut/yii2-menu](http://github.com/execut/yii2-menu) | yii2-pages | ![Complete](https://img.shields.io/packagist/v/execut/yii2-menu.svg?color=green&label=%20)
Site pages content | [execut/yii2-pages](http://github.com/execut/yii2-pages) | yii2-alias, yii2-files, yii2-goods, yii2-menu, yii2-seo, yii2-sitemap, yii2-settings | ![Complete](https://img.shields.io/packagist/v/execut/yii2-pages.svg?color=green&label=%20)
SEO metadata | [execut/yii2-seo](http://github.com/execut/yii2-seo) | yii2-files, yii2-pages |  ![Complete](https://img.shields.io/packagist/v/execut/yii2-seo.svg?color=green&label=%20)
Site settings | [execut/yii2-settings](http://github.com/execut/yii2-settings) | yii2-rbac |  ![Complete](https://img.shields.io/packagist/v/execut/yii2-settings.svg?color=green&label=%20)
Robots.txt generation | [execut/yii2-robots-txt](http://github.com/execut/yii2-robots-txt) | - |  ![Complete](https://img.shields.io/packagist/v/execut/yii2-robots-txt.svg?color=green&label=%20)
Sitemap generation | execut/yii2-sitemap | yii2-pages, yii2-news, yii2-shops | In progress
Site settings | [execut/yii2-settings](http://github.com/execut/yii2-settings) | yii2-pages, yii2-news, yii2-shops |  ![Complete](https://img.shields.io/packagist/v/execut/yii2-settings.svg?color=green&label=%20)
Information pages about chain of stores | execut/yii2-shops | yii2-seo | In progress
Blog, articles and news | execut/yii2-news | yii2-seo | In progress
Users manager | execut/yii2-users | yii2-rbac | In progress
RBAC manager | execut/yii2-rbac | yii2-users | In progress
Feedback | execut/yii2-feedback | yii2-users, yii2-antispam, yii2-settings | In progress
Antispam protection | execut/yii2-antispam | - | In progress
Orders | execut/yii2-orders | yii2-goods | New
Basket | execut/yii2-basket | yii2-orders, yii2-antispam | New

Supported databases:
* PostgreSQL
* MySQL

## Installation

The easiest installation method is to install over of a [yiisoft/yii2-app-advanced](https://github.com/yiisoft/yii2-app-advanced) based application.
To install Yii2 CMS into your project, you need to take only three steps:
1. Connect the CMS package
   1. If you have an existing project, you can connect the package by running the command ``` composer require execut/yii2-cms```.
   1. If you are going to deploy Yii2 CMS on a new application, you can install a prepared project-template [execut/yii2-cms-advanced-template](https://github.com/execut/yii2-cms-advanced-template/). Installation instructions [here](https://github.com/execut/yii2-cms-advanced-template/blob/master/docs/guide/start-installation.md).
1. Apply migrations ```./yii migrate/up --interactive 0```
1. Create an admin user with the command ```./yii cms/users/create-admin admin password email@example.com```,
where: admin - login, password - password, email@example.com - user email

## Usage
If you used standard layers layouts/main.php in the in backend and frontend applications, then after installing the CMS, they should be redefined.
All CMS content is displayed in these layers.
If this did not happen, then you are using non-standard layers, and the CMS did not reassign them, thinking that you want to use your own.
To use custom layer, you need to display all the elements for the CMS to work in it in the likeness of these two:
[frontend.php](https://github.com/execut/yii2-cms/blob/master/views/layouts/frontend.php) and
[backend.php](https://github.com/execut/yii2-cms/blob/master/views/layouts/backend.php).

The backend application should start displaying sections and a menu should appear:
![i/backend-pages.jpg](https://raw.githubusercontent.com/execut/yii2-cms/master/docs/guide-ru/i/backend-pages.jpg)

In this case, the frontend application should show pages along with the menu:
![i/backend-pages.jpg](https://raw.githubusercontent.com/execut/yii2-cms/master/docs/guide-ru/i/frontend-pages.jpg)

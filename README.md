# eXeCUT Yii2 CMS
Warning! Beta version. Please add tasks [here](https://github.com/execut/yii2-cms/issues) if you find errors. I will try to fix them quickly

CMS, based on Yii2 modular system. All system modules are standalone Yii2 modules and can be used separately from CMS.

List of system features and modules:

Feature | Module | Expanded by modules | Development status
-------------------- | ----------- | -------------- | ------
Aliases for urls of records like page and logging their changes | [execut/yii2-alias](http://github.com/execut/yii2-alias) | yii2-files, yii2-images, yii2-news, yii2-pages, yii2-shops | Complete
Goods | [execut/yii2-goods](http://github.com/execut/yii2-goods) | yii2-files, yii2-pages | Complete
Files | [execut/yii2-files](http://github.com/execut/yii2-files) | yii2-alias, yii2-goods, yii2-images, yii2-pages, yii2-seo | Complete
Images | [execut/yii2-images](http://github.com/execut/yii2-images) | yii2-files | Complete
Menus | [execut/yii2-menu](http://github.com/execut/yii2-menu) | yii2-pages | Complete
Site pages content | [execut/yii2-pages](http://github.com/execut/yii2-pages) | yii2-alias, yii2-files, yii2-goods, yii2-menu, yii2-seo, yii2-sitemap | Complete
SEO metadata | [execut/yii2-seo](http://github.com/execut/yii2-seo) | yii2-files, yii2-pages | Complete
Site settings | [execut/yii2-settings](http://github.com/execut/yii2-settings) | yii2-pages, yii2-rbac | Complete
Robots.txt generation | [execut/yii2-robots-txt](http://github.com/execut/yii2-robots-txt) | - | Complete
Sitemap generation | execut/yii2-sitemap | yii2-pages, yii2-news, yii2-shops | In progress
Site settings | [execut/yii2-settings](http://github.com/execut/yii2-settings) | yii2-pages, yii2-news, yii2-shops | Complete
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

* If you do not have yii2 app advanced, install it via [instructions here](https://github.com/yiisoft/yii2-app-advanced/blob/master/docs/guide/start-installation.md)
* Register user via standard controller /site/signup and activate it by setting status to 10 inside database.
* Require CMS via composer by running ```composer require execut/yii2-cms```
* Add bootstrapping of CMS inside your applications configs ```(console|frontend|backend)/config/main.php```:
```php
return [
    ...
    'bootstrap' => [
        ...
        \execut\cms\bootstrap\Console::class, //for console application
        \execut\cms\bootstrap\Frontend::class, //for frontend application
        \execut\cms\bootstrap\Backend::class, //for backend application
    ],
    ...
];
```
* Set CMS language inside ```backend/config/main.php```. Now only supported ```ru```:
```
return [
    ...
    'language' => 'ru',
    ...
];
```
* Apply migrations by running:
```ssh
./yii migrate/up --interactive 0
```
* Remove or rename unused files ```frontend/web/robots.txt``` and ```frontend/controllers/SiteController.php```
* Congratulations! CMS installed

## Usage
After installation CMS has 3 applications: frontend - here site for users, backend - administration panel and console.

For open CMS admin panel enter backend url. Here you can manage your site. Instructions for working with sections are on the page of the module responsible for a specific section. Links to pages listed in the table above.

![Demo](https://raw.githubusercontent.com/execut/yii2-cms/master/docs/demo.png)

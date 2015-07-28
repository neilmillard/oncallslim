# On Call Slim 3 App
based on the skeleton akrabat/slim3-skeleton

This is a simple project for Slim 3 that includes Twig, Flash messages and Monolog. In addition this project
also has Redbean and Authentication.
* 'slim_docs': http://www.slimframework.com/docs/index.html
* 'authentication' : http://github.com/zendframework/zf2
* 'redbean': http://www.redbeanphp.com/

## Clone this project:

    $ composer create-project -n -s dev neilmillard/oncallslim my-app

### Run it:

1. `$ cd my-app`
2. `$ php -S 0.0.0.0:8888 -t public public/index.php`
3. Browse to http://localhost:8888

## Key directories

* `app`: Application code
* `app/src`: All class files within the `App` namespace
* `app/templates`: Twig template files
* `cache/twig`: Twig's Autocreated cache files
* `log`: Log files
* `public`: Webserver root
* `vendor`: Composer dependencies

## Key files

* `public/index.php`: Entry point to application
* `app/settings.php`: Configuration, copy from settings_dist.php
* `app/dependencies.php`: Services for Pimple
* `app/middleware.php`: Application middleware
* `app/routes.php`: All application routes are here
* `app/src/Action/HomeAction.php`: Action class for the home page
* `app/templates/home.twig`: Twig template file for the home page

#### IIS

Ensure the `Web.config` and `index.php` files are in the same public-accessible directory.
* `Rewrite IIS extension`: http://www.iis.net/learn/extensions/url-rewrite-module/using-the-url-rewrite-module

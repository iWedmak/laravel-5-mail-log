# laravel-5-mail-log
* install
```bash
composer require iwedmak/mail-log
```
* Or
```bash
php composer.phar require iwedmak/mail-log
```
* Or add to composer.json
```bash
"iwedmak/mail-log": "dev-master"
```

Register provider, add this to config/app.php in providers array:
```php
iWedmak\Mail\MailLogServiceProvider::class,
```
After that u will need to publish config
```bash
php artisan vendor:publish
```
and publish migrations and migrate
``` bash
php artisan maillog:migration
php artisan migrate
```

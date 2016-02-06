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

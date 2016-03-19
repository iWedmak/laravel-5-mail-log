# laravel-5-mail-log
Logs every email sended by laravel (via Mail class include queued mails), preventing duplicates, u can override this by adding in bcc `skeep@me.com` or u can limit frequency (by default 30 minutes) of duplicates by adding in bcc `delay@me.com` (this can be changed in config file)
Monitors email reads, have event MessageRead.
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

Now we can subscribe to mailsend event, by adding to `app/Providers/EventServiceProvider.php` 
```php
protected $subscribe = [
    'iWedmak\Mail\MailEventListener',
];
```
Now u have one more event, it's `iWedmak\Mail\MessageRead` when email was read.

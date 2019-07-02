<h1 align="center">MIKHGEN</h1>
<p align="center">
    <img align="center" src="https://media.giphy.com/media/YoE5bm8H2muwIvc0Dj/giphy.gif">
</p>

Mikhgen adalah aplikasi Agen Hotspot agar bisa memonitor penghasilannya, aplikasi ini simple, hanya menarik laporan penjualan dari mikrotik, aplikasi ini harus di padukan dengan Mikhmon v2.


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


PRE REQUISITES
------------

Sebelum bisa menjalankan aplikasi, anda perlu install [Composer](http://getcomposer.org/), agar bisa mengupdate dependency pada aplikasi ini. 

REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.4.0.


INSTALLATION
------------

### Install from an Archive File

Download repository ini sebagai zip, dan simpan di htdocs xampp, 

Set cookie validation key in `config/web.php` file to some random secret string:

```php
'request' => [
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => '<secret random string goes here>',
],
```

You can then access the application through the following URL:

~~~
http://localhost/mikhgen/web/
~~~


CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

**NOTES:**
- Database tidak akan dibuat secara otomatis, anda harus membuat databasenya secara manual, sebelum menjalankan aplikasi
- Check and edit the other files in the `config/` directory to customize your application as required.


FITUR
-------
- TO be edited

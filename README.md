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


CONTRIBUTING
------------

### Requirement
- PHP language for backend
- HTML, CSS, JavaScript for frontend
- VueJs for interactivity
- Semantic UI for rich ui
- MySQL for database
- PHP Engine v7 language support

### Notes
Setelah anda clone repository ini, sebelum mengubah konfigurasi, silahkan anda run git command `git --assume-unchanged` untuk semua file pada folder config, agar yang lain tidak mendapatkan perubahan konfigurasi anda, karena setiap komputer berbeda konfigurasi. baru setelah itu anda boleh commit, saat ini gunakan saja master.


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
- To be edited

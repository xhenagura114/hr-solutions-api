# Landmark Solution #

Our HR system, built in Laravel, is a powerful software solution that provides a comprehensive range of features for efficient management of human resource processes. It is designed with a user-friendly interface and allows businesses to easily manage employee data, recruitment and onboarding, performance tracking, payroll and benefits administration, training and development, and compliance management. Built with the Laravel framework, our HR system is scalable, secure, and provides seamless integration with other applications. It is an ideal solution for businesses of any size seeking to optimize their HR operations.

### General Information ###

**Laravel: v5.6.4**

**Get laravel version:**
```
$laravel = app();
return "Your Laravel version is ".$laravel::VERSION;
```
### Requirements ###

- **PHP** >= 7.1.3
- **OpenSSL** PHP Extension
- **PDO** PHP Extension
- **Mbstring** PHP Extension
Needed by UniSharp File Manager:
- **GD2** Image PHP extension
- **exif** PHP extension
- **https://askubuntu.com/questions/656794/how-to-install-libreoffice-5-0-in-ubuntu** loffice writer
- **http://www.mariorodriguez.co/2018/01/17/install-enable-imagick-on-ubuntu-16.04.html** configure imagick
- **https://github.com/barryvdh/laravel-translation-manager** translation manager

### Installation ###

- Install vendors:
```
composer install
```

- Copy .env.example and rename it .env:
```
cp .env.example .env
```

- Edit .env file with database name, username, password
```
DB_DATABASE=YOUR_DB_NAME
DB_USERNAME=YOUR_DB_USERNAME
DB_PASSWORD=YOUR_DB_PASSWORD
```

- Generate key:
```
php artisan key:generate
```

- Publish modules migrations
```
php artisan module:publish-migration
```

- Migrate DB:
```
php artisan migrate
```

### Modules ###

[Read Modules Documentation](https://nwidart.com/laravel-modules/v3/introduction)

### General Info ###

 - To access and make global variables add them to the core Controller in \App\Http\Controllers\Controller.php constructor: ```View::share('variable_name', $variable_value)```
 - To make a module migration and model ``` php artisan module:make-model Employee EmployeeManagementModule -m```
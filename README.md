<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Cigo Tracker Application</h1>
    <br>
</p>

This is application for Cigo Tracker

# Project Setup


## Please open terminal and run below command to clone repo

```git clone https://github.com/brijal1987/cigo-tracker.git```


## Go to project folder

```cd cigo-tracker```

## Install All Dependencies

```composer install```


## Initiallize developement files

```php init```

Which environment do you want the application to be initialized in?

  **[0] Development**

  **[1] Production**

`Enter 0 and Press Enter`

Initialize the application under 'Development' environment? [yes|no]

`Enter Yes and Press Enter`

## DB changes

Create DB named *'cigo-tracker'* and upload file from */database/cigo-tracker.sql*

**Open file *'/cigo-tracker/common/config/main-local.php'* and edit below code and set your db credentials as needed**

```
'db' => [

    'class' => 'yii\db\Connection',

    'dsn' => 'mysql:host=localhost;dbname=cigo-tracker',

    'username' => 'root',

    'password' => '',

    'charset' => 'utf8',

],
```

**Open file *'/cigo-tracker/common/config/params.php'* and put your api key for https://www.geocod.io/**

```GEO_CODIO_API_KEY=e65be9046f4064e5056cf69565eee5fe955d5ee```


## Run Project and open URL http://localhost:8080/

```php yii serve --docroot="frontend/web/"```

`http://localhost:8080/`


## Login Credentials

username: cigotracker

password: Cigo@123


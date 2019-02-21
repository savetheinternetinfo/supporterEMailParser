## :chart_with_upwards_trend: Local testing

### Installation & Quick setup:

0. First we need to install an Apache Server with PHP, Composer and NPM. For example [Laragon](https://laragon.org/download/)
1. Clone the repository into the /www/ directory of Laragon and navigate to it

2. The `.env.example` file needs to be copied to `.env`
3. In `.env` change the following entries:
- DB_CONNECTION=mysql -> DB_CONNECTION=sqlite
- DB_DATABASE=homestead -> DB_DATABASEX=homestead
4. In `.env` add an Admin account by filling out the following lines: (The e-mail address doesn't have to be real, but it has to be valid format)
- ADMIN_USER_NAME=
- ADMIN_USER_MAIL=
- ADMIN_USER_PASS=

5. Create the sqlite file <repository>/database/database.sqlite (Just use touch or create an empty text file)

6. In laragon/bin/php/php-x.x.x/php.ini at around line 906 you need to enable the following extensions:
- extension=imap
- extension=pdo_sqlite

7. Composer Update & Install <br>
$ `composer update` <br>
$ `composer install`

8. Generate Key <br>
$ `php artisan key:generate`
9. Generate Sqlite Database <br>
$ `php artisan migrate`
10. Create Admin Account <br>
$ `php artisan admin:create`

11. Installieren NPM Packets <br>
$ `npm i`
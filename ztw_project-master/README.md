# \#ZTW

## First steps
```bash
composer install
```

## Database
```
user: studia_web_zend
password: studia_web_zend
db_name: studia_web_zend
hostname: 127.0.0.1
port: 3306
driver: PDO
```
```sql
CREATE USER 'studia_web_zend'@'localhost' IDENTIFIED BY 'studia_web_zend';
GRANT ALL PRIVILEGES ON `studia_web_zend%` . * TO 'studia_web_zend'@'localhost';
FLUSH PRIVILEGES;
create database studia_web_zend CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## Run using PHP's built-in web server:

```bash
$ cd path/to/install
$ php -S 0.0.0.0:8080 -t public
# OR use the composer alias:
$ composer run --timeout 0 serve
```

This will start the cli-server on port 8080, and bind it to all network
interfaces. You can then visit the site at http://localhost:8080/
- which will bring up Zend Framework welcome page.

**Note:** The built-in CLI server is *for development only*.

## Development mode

```bash
$ composer development-enable  # enable development mode
$ composer development-disable # disable development mode
$ composer development-status  # whether or not development mode is enabled
```

You may provide development-only modules and bootstrap-level configuration in
`config/development.config.php.dist`, and development-only application
configuration in `config/autoload/development.local.php.dist`. Enabling
development mode will copy these files to versions removing the `.dist` suffix,
while disabling development mode will remove those copies.

Development mode is automatically enabled as part of the skeleton installation process. 
After making changes to one of the above-mentioned `.dist` configuration files you will
either need to disable then enable development mode for the changes to take effect,
or manually make matching updates to the `.dist`-less copies of those files.

## Running Unit Tests
Run the tests using:

```bash
$ ./vendor/bin/phpunit
```

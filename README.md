Description
----------------

Implementation of solution for a supermarket checkout that calculates the total price of a number of items. Calculate priced individually, some items are multi-priced: buy `n` of them, and they'll cost you `y` cents.

Setup
----------------

First setup you DB connection credentials in `config.php`. 

 ```gradle
define( 'DB_NAME', 'name' );
define( 'DB_USER', 'username' );
define( 'DB_PASSWORD', 'password' );
define( 'DB_HOST', 'host' );

```

Then, then you should run database script `database.php`.

**Notice:** Keep in mind that script will overwrite if you have existing database with same name as listed in config.php

Last, add the WooCommerce API credentials in `Rest.php` file.

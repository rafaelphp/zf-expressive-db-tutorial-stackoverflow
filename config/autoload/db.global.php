<?php
/**
 * Created by PhpStorm.
 * User: webmaster
 * Date: 28/03/17
 * Time: 07:35 PM
 */

define('DBHOST','localhost');
define('DBNAME','expressive');
define('DBUSER','root');
define('DBPASS','');


##################################
### RETURN ARRAY CONFIGURATION ###
##################################

return [
    'db' => [
        'driver' => 'Pdo',
        'dsn'    => 'mysql:dbname='.DBNAME.';host='.DBHOST,
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ],
        'username' => DBUSER,
        'password' => DBPASS,
    ],
];

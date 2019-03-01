<?php # mysqli_connect-wtia.php
define('DB_USER', 'teamwong_phpscript');
define('DB_PASSWORD', 'GRCabjkv2019');
define('DB_HOST', 'localhost');
define('DB_NAME', 'teamwong_wtiaconnect');

$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
    OR die('Could not connect to MySQL: ' . mysqli_connect_error());


mysqli_set_charset($dbc, 'utf8');
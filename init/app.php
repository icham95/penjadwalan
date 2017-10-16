<?php 

require "vendor/autoload.php";

$app = new \Slim\App([
  'settings' => [
    'displayErrorDetails' => true,
    'db' => [
      'driver'    => 'mysql',
      'host'      => 'localhost',
      'database'  => 'dbs_start2',
      'username'  => 'root',
      'password'  => 'root',
      'charset'   => 'utf8',
      'collation' => 'utf8_unicode_ci',
      'prefix'    => '',
    ]
  ]
]);

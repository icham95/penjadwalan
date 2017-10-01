<?php 

session_start();
require './init/app.php';
require './init/container.php';
require './routes/web.php';
require './routes/api.php';

$app->run();
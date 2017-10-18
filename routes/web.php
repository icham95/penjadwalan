<?php 

$app->get('/dosen/login', 'App\Controllers\Web\DosenController:login')->setName('dosen-login');
$app->get('/dosen/logout', 'App\Controllers\Web\DosenController:logout')->setName('dosen-logout');

$app->group('/dosen', function () use ($app) {
  
  $app->get('/dashboard', 'App\Controllers\Web\DosenController:dashboard')->setName('dosen-dashboard');
  $app->get('/km', 'App\Controllers\Web\DosenController:ketersediaan_mengajar')->setName('dosen-km');
  $app->get('/setting', 'App\Controllers\Web\DosenController:setting')->setName('dosen-setting');
  
})->add(new App\Middleware\Auth\Dosen($app->getContainer()->get('router')));
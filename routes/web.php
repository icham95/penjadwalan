<?php 

$app->get('/dosen/login', 'App\Controllers\Web\DosenController:login')->setName('dosen-login');
$app->get('/dosen/logout', 'App\Controllers\Web\DosenController:logout')->setName('dosen-logout');

$app->group('/admin', function () use ($app) {
  
  $app->get('/dashboard', 'App\Controllers\AdminController:dashboard')->setName('admin-dashboard');
  $app->get('/edit-user', 'App\Controllers\AdminController:editUser')->setName('admin-edit-user');
  
})->add(new App\Middleware\AuthAdmin($app->getContainer()->get('router')));
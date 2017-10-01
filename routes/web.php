<?php 

$app->get('/', 'App\Controllers\HomesideController:index')->setName('homeside');
$app->get('/login/admin', 'App\Controllers\AdminController:login')->setName('admin-login');
$app->get('/logout/admin', 'App\Controllers\AdminController:logout')->setName('admin-logout');

$app->group('/admin', function () use ($app) {
  
  $app->get('/dashboard', 'App\Controllers\AdminController:dashboard')->setName('admin-dashboard');
  $app->get('/edit-user', 'App\Controllers\AdminController:editUser')->setName('admin-edit-user');
  
})->add(new App\Middleware\AuthAdmin($app->getContainer()->get('router')));
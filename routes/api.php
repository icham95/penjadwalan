<?php 

$app->group('/api', function () use($app) {

  $app->post('/admin-login', 'App\Controllers\Api\Admin:login')
      ->add(App\Middleware\ValidationHelper::validate('login'));

  $app->group('/v1', function () use($app) {

    $app->get('/users', 'App\Controllers\Api\Admin:get_users');
    $app->get('/users/count', 'App\Controllers\Api\Admin:get_users_count');
    $app->put('/users/{id}', 'App\Controllers\Api\Admin:update_user');
    $app->delete('/users/{id}', 'App\Controllers\Api\Admin:delete_user');
    $app->post('/users', 'App\Controllers\Api\Admin:create_user')
        ->add(App\Middleware\ValidationHelper::validate('apiCreateUser'));

    $app->get('/mahasiswa', 'App\Controllers\Api\Admin:get_mahasiswas');
    $app->get('/dosen', 'App\Controllers\Api\Admin:get_dosens');

  })->add(new App\Middleware\AuthAdmin($app->getContainer()->get('router')));

});

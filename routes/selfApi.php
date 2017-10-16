<?php 

$app->group('/api/self', function () use($app) {

  $app->post('/dosen/auth', 'App\Controllers\SelfApi\Auth\DosenController:make_auth')
      ->add(App\Middleware\ValidationHelper::validate('auth_dosen'));

  $app->group('/dosen', function () use($app) {

    $app->get('/dosen', 'App\Controllers\SelfApi\DosenController:index');
    $app->get('/dosen/{id}', 'App\Controllers\SelfApi\DosenController:single');
    $app->post('/dosen', 'App\Controllers\SelfApi\DosenController:create');
    $app->put('/dosen/{id}', 'App\Controllers\SelfApi\DosenController:update');
    $app->delete('/dosen/{id}', 'App\Controllers\SelfApi\DosenController:delete');

    $app->get('/tahun-akademik', 'App\Controllers\SelfApi\TahunAkademikController:index');
    $app->get('/tahun-akademik/{id}', 'App\Controllers\SelfApi\TahunAkademikController:single');
    $app->post('/tahun-akademik', 'App\Controllers\SelfApi\TahunAkademikController:create');
    $app->put('/tahun-akademik/{id}', 'App\Controllers\SelfApi\TahunAkademikController:update');
    $app->delete('/tahun-akademik/{id}', 'App\Controllers\SelfApi\TahunAkademikController:delete');

    $app->get('/ketersediaan-mengajar', 'App\Controllers\SelfApi\KetersediaanMengajarController:index');
    $app->get('/ketersediaan-mengajar/{id}', 'App\Controllers\SelfApi\KetersediaanMengajarController:single');
    $app->post('/ketersediaan-mengajar', 'App\Controllers\SelfApi\KetersediaanMengajarController:create');
    $app->put('/ketersediaan-mengajar/{id}', 'App\Controllers\SelfApi\KetersediaanMengajarController:update');
    $app->delete('/ketersediaan-mengajar/{id}', 'App\Controllers\SelfApi\KetersediaanMengajarController:delete');

    // $app->post('/users', 'App\Controllers\Api\Admin:create_user')
    //     ->add(App\Middleware\ValidationHelper::validate('apiCreateUser'));

  })->add(new App\Middleware\Auth\Dosen($app->getContainer()->get('router')));

});

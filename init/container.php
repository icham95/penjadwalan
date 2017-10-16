<?php 

$container = $app->getContainer();

// register illuminate/database
$container['db'] = function ($container) {
  $capsule = new Illuminate\Database\Capsule\Manager;
  $capsule->addConnection($container['settings']['db']);
  $capsule->setAsGlobal();
  $capsule->bootEloquent();
  return $capsule;
};

// Register Twig View helper
$container['view'] = function ($c) {
  $view = new \Slim\Views\Twig( __DIR__ . '/../resources/views/', [
      'cache' => false,
  ]);

  $twig = $view->getEnvironment();
  if (!isset($_SESSION['dosen'])) {
    $_SESSION['dosen']['logged'] = false;
    $_SESSION['dosen']['id'] = false;
  }
  $twig->addGlobal('session', $_SESSION);
  
  // Instantiate and add Slim specific extension
  $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
  $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));

  return $view;
};

$container['notAllowedHandler'] = function ($container) {
    return function ($request, $response, $methods) use ($container) {
        return $container['response']
            ->withStatus(405)
            ->withHeader('Allow', implode(', ', $methods))
            ->withHeader('Content-type', 'text/html')
            ->write('Method must be one of: ' . implode(', ', $methods));
    };
};
<?php

namespace App\Middleware;

use App\Helper\Session;

class AuthAdmin
{
  private $router;
  
  public function __invoke($request, $response, $next)
  {
    return $this->cekAdmin($request, $response, $next);
  }

  public function __construct($router)
  {
    $this->router = $router;
  }

  private function cekAdmin($request, $response, $next)
  {
    if (Session::get('admin') == false) {
      $url = $request->getUri()->withPath($this->router->pathFor('admin-login'));
      return $response->withRedirect($url);
    }
    if (Session::get('admin')['logged'] == false) {
      $url = $request->getUri()->withPath($this->router->pathFor('admin-login'));
      return $response->withRedirect($url);
    }
    if (Session::get('admin')['logged'] == true) {
      return $response = $next($request, $response);
    }
  }
}

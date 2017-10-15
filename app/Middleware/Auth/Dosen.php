<?php 

namespace App\Middleware\Auth;

use App\Helper\Session;

class Dosen
{
  private $router;
  
  public function __invoke($request, $response, $next)
  {
    if (Session::get('dosen') == false) {
      $url = $request->getUri()->withPath($this->router->pathFor('dosen-login'));
      return $response->withRedirect($url);
    }
    if (Session::get('dosen')['logged'] == false) {
      $url = $request->getUri()->withPath($this->router->pathFor('dosen-login'));
      return $response->withRedirect($url);
    }
    if (Session::get('dosen')['logged'] == true) {
      return $response = $next($request, $response);
    }
  }

  public function __construct($router)
  {
    $this->router = $router;
  }
}

<?php 

namespace App\Middleware;

class ValidationReturn
{
  public function __invoke($req, $res, $next)
  {

    if ($req->getAttribute('has_errors')) {
      return $res->withJson([
        'success' => false,
        'code' => 1,
        'msg' => $req->getAttribute('errors')
      ]);
    }

    $res = $next($req, $res);
    return $res;
  }
}

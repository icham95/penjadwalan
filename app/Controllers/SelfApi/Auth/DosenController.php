<?php 

namespace App\Controllers\SelfApi\Auth;

use App\Models\Dosen;
use App\Helper\Session;

class DosenController extends \App\Controllers\Controller
{
  public function make_auth($req, $res)
  {
    if ($req->getAttribute('has_errors')) {
      return $res->withJson([
        'success' => false,
        'code' => 1,
        'msg' => $req->getAttribute('errors')
      ]);
    }

    $username = $req->getParsedBody()['username'];
    $password = $req->getParsedBody()['password'];

    $user = Dosen::where('username', $username)->first();
    if (!$user) {
      return $res->withJson([
        'success' => false,
        'code' => 2,
        'msg' => 'username tidak ditemukan.'
      ]);
    }

    if ((string)$password !== (string)$user->password) {
      return $res->withJson([
        'success' => false,
        'code' => 3,
        'msg' => 'username dan password tidak cocok'
      ]);
    }

    Session::set('dosen', [
      'logged' => true
    ]);

    return $res->withJson([
      'success' => true,
      'code' => 1
    ]);
  }
}

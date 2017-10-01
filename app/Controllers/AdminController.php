<?php 

namespace App\Controllers;

use App\Controllers\Controller;
use App\Helper\Session;

class AdminController extends Controller
{
  public function login($req, $res)
  {
    if (Session::get('admin') == true) {
      if (Session::get('admin')['logged'] == true) {
        $url = $req->getUri()->withPath($this->router->pathFor('admin-dashboard'));
        return $res->withRedirect($url);
      }
    }
    $this->view->render($res, 'admin/login.twig');
  }

  public function logout($req, $res)
  {
    session_destroy();
    $url = $req->getUri()->withPath($this->router->pathFor('admin-login'));
    return $res->withRedirect($url);
  }

  public function dashboard($req, $res)
  {
    $this->view->render($res, 'admin/dashboard.twig');
  }

  public function editUser($req, $res)
  {
    $this->view->render($res, 'admin/edit-user.twig');
  }
}

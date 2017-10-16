<?php 

namespace App\Controllers\Web;

class DosenController extends \App\Controllers\Controller
{
  public function login($req, $res)
  {
    $this->view->render($res, 'dosen/login.twig');
  }

  public function logout($req, $res)
  {
    session_destroy();
    $url = $req->getUri()->withPath($this->router->pathFor('dosen-login'));
    return $res->withRedirect($url);
  }

  public function dashboard($req, $res)
  {
    $this->view->render($res, 'dosen/dashboard.twig');
  }

  public function setting($req, $res)
  {
    $this->view->render($res, 'dosen/setting/default.twig');
  }
}

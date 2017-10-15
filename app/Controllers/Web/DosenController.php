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
    # code...
  }
}

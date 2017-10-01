<?php 

namespace App\Controllers;

use App\Controllers\Controller;
use App\Helper\Session;

class HomesideController extends Controller
{
  public function index($req, $res)
  {
    $this->view->render($res, 'default.twig');
  }
}
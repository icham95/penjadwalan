<?php 

namespace App\Controllers;

use Interop\Container\ContainerInterface;

class Controller
{
  protected $container;
  protected $db;
  protected $view;
  protected $router;
  protected $path;
  
  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
    $this->db = $this->container->db;
    $this->view = $this->container->view;
    $this->router = $this->container->get('router');
    $this->path = $_SERVER['DOCUMENT_ROOT'] . '/project/start/';
  }
}

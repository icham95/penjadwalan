<?php 

namespace App\Controllers;

use Interop\Container\ContainerInterface;

class Controller
{
  protected $container;
  protected $db;
  protected $view;
  protected $router;
  
  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
    $this->db = $this->container->db;
    $this->view = $this->container->view;
    $this->router = $this->container->get('router');
  }
}

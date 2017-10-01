<?php 

namespace App\Helper;

class Session
{
  static public function get($name)
  {
    if (isset($_SESSION)) {
      if (isset($_SESSION[$name])) {
        return $_SESSION[$name];
      }
      return false;
    }
    return false;
  }

  static public function set($name, $value) {
    $_SESSION[$name] = $value;
  }
}

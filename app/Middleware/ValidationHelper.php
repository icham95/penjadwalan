<?php 

namespace App\Middleware;

use Respect\Validation\Validator as v;
use DavidePastore\Slim\Validation\Validation;

class ValidationHelper
{
  public static function validate($fn_name)
  {
    return new Validation(\call_user_func([new ValidationHelper(), $fn_name]));
  }

  public function auth_dosen()
  {
    return [
      'username' => v::notBlank()->alnum()->noWhitespace()->length(1, 10),
      'password' => v::notBlank()->alnum()->length(4, 16)
    ];
  }

  public function createDosen()
  {
    return [
      'nip'      => v::notBlank()->alnum()->noWhitespace()->length(1, 10),
      'username' => v::notBlank()->alnum()->noWhitespace()->length(1, 10),
      'password' => v::notBlank()->alnum()->length(4, 16)
    ];
  }
}

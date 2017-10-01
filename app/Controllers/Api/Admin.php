<?php 

namespace App\Controllers\Api;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Helper\Session;

class Admin extends \App\Controllers\Controller
{
  public function login($req, $res, $args)
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

    $user = User::where('username', $username)->first();
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

    Session::set('admin', [
      'logged' => true
    ]);

    return $res->withJson([
      'success' => true,
      'code' => 1
    ]);
  }

  public function get_users($req, $res)
  {

    $limit = (isset($_GET['limit']) ? $_GET['limit'] : 5);
    $offset = (isset($_GET['offset']) ? $_GET['offset'] : 0);
    $order_what = (isset($_GET['order_what']) ? $_GET['order_what'] : 'id_user');
    $order_by = (isset($_GET['order_by']) ? $_GET['order_by'] : 'DESC');
    $search_what = (isset($_GET['search_what']) ? $_GET['search_what'] : 'username');
    $search_value = (isset($_GET['search_value']) ? $_GET['search_value'] : '');
    $datas = User::orderBy($order_what, $order_by)
                  ->offset($offset)
                  ->limit($limit)
                  ->where($search_what, 'like', '%' . $search_value . '%')
                  ->get();
    if (!$datas) {
      return $res->withJson([
        'success' => false,
        'code' => 1,
        'msg' => 'data tidak ditemukan'
      ]);
    }

    return $res->withJson([
      'success' => true,
      'code' => 1,
      'data' => $datas
    ]);
  }

  public function get_mahasiswas($req, $res)
  {
    $limit = (isset($_GET['limit']) ? $_GET['limit'] : 5);
    $offset = (isset($_GET['offset']) ? $_GET['offset'] : 0);
    $order_what = (isset($_GET['order_what']) ? $_GET['order_what'] : 'id_mahasiswa');
    $order_by = (isset($_GET['order_by']) ? $_GET['order_by'] : 'DESC');
    $search_what = (isset($_GET['search_what']) ? $_GET['search_what'] : 'npm');
    $search_value = (isset($_GET['search_value']) ? $_GET['search_value'] : '');
    $datas = Mahasiswa::orderBy($order_what, $order_by)
                ->offset($offset)
                ->limit($limit)
                ->where($search_what, 'like', '%' . $search_value . '%')
                ->get();

    if (!$datas) {
      return $res->withJson([
        'success' => false,
        'code' => 1,
        'msg' => 'data tidak ditemukan'
      ]);
    }

    return $res->withJson([
      'success' => true,
      'code' => 1,
      'data' => $datas
    ]);
  }

  public function get_dosens($req, $res)
  {
    $limit = (isset($_GET['limit']) ? $_GET['limit'] : 5);
    $offset = (isset($_GET['offset']) ? $_GET['offset'] : 0);
    $order_what = (isset($_GET['order_what']) ? $_GET['order_what'] : 'id_dosen');
    $order_by = (isset($_GET['order_by']) ? $_GET['order_by'] : 'DESC');
    $search_what = (isset($_GET['search_what']) ? $_GET['search_what'] : 'kode_dosen');
    $search_value = (isset($_GET['search_value']) ? $_GET['search_value'] : '');
    $datas = Dosen::orderBy($order_what, $order_by)
                ->offset($offset)
                ->limit($limit)
                ->where($search_what, 'like', '%' . $search_value . '%')
                ->get();

    if (!$datas) {
      return $res->withJson([
        'success' => false,
        'code' => 1,
        'msg' => 'data tidak ditemukan'
      ]);
    }

    return $res->withJson([
      'success' => true,
      'code' => 1,
      'data' => $datas
    ]);
  }

  public function create_user($req, $res)
  {
    if ($req->getAttribute('has_errors')) {
      return $res->withJson([
        'success' => false,
        'code' => 1,
        'msg' => $req->getAttribute('errors')
      ]);
    }

    if ($req->getParsedBody()['level'] == 1 ) {
      $dosen = Dosen::where('id_dosen', $req->getParsedBody()['id_login'])->first();
      if (!$dosen) {
        return $res->withJson([
          'success' => false,
          'code' => 2,
          'msg' => 'dosen tidak ditemukan.'
        ]);
      }
    }

    if ($req->getParsedBody()['level'] == 2 ) {
      $mahasiswa = Mahasiswa::where('id_mahasiswa', $req->getParsedBody()['id_login'])->first();
      if (!$mahasiswa) {
        return $res->withJson([
          'success' => false,
          'code' => 2,
          'msg' => 'mahasiswa tidak ditemukan.'
        ]);
      }
    }
    
    $user = User::where([
      'id_login' => $req->getParsedBody()['id_login'],
      'level' => $req->getParsedBody()['level']
    ])->first();

    if ($user) {
      return $res->withJson([
        'success' => false,
        'code' => 3,
        'msg' => 'User sudah mempunyai akun.'
      ]);
    }

    $user = User::where('username', $req->getParsedBody()['username'])->first();
    if ($user) {
      return $res->withJson([
        'success' => false,
        'code' => 4,
        'msg' => 'Username sudah digunakan.'
      ]);
    }

    User::insert([
        'id_login' => $req->getParsedBody()['id_login'],
        'username' => $req->getParsedBody()['username'],
        'password' => $req->getParsedBody()['password'],
        'level' => $req->getParsedBody()['level']
      ]);

    return $res->withJson([
      'success' => true,
      'code' => 1,
      'data_back' => $req->getParsedBody()
    ]);
  }
  
  public function delete_user($req, $res, $args)
  {
    $user = User::where('id_user', $args['id'])->first();
    if (!$user) {
      return $res->withJson([
        'success' => false,
        'code' => 1,
        'msg' => 'User tidak ditemukan.'
      ]);
    }
    $user->delete();
    return $res->withJson([
      'success' => true,
      'code' => 1,
      'msg' => 'id user ' . $args['id'] . ' berhasil dihapus'
    ]);
  }

  public function update_user($req, $res, $args)
  {
    $user = User::find($args['id']);
    if (!$user) {
      return $res->withJson([
        'success' => false,
        'code' => 1,
        'msg' => 'User tidak ditemukan.'
      ]);
    }

    $err = 0;
    $put = $req->getParsedBody();
    if (isset($put['username'])) {
      $cek = User::where('username', $put['username'])->first();
      if ($cek) {
        return $res->withJson([
          'success' => false,
          'code' => 2,
          'msg' => 'Username sudah digunakan.'
        ]);  
      }
      $user->update([
        'username' => $put['username']
      ]);
      $err = 1;
    }
    if (isset($put['password'])) {
      $user->update([
        'password' => $put['password']
      ]);
      $err = 1;
    }
    if (isset($put['level'])) {
      $user->update([
        'level' => $put['level']
      ]);
      $err = 1;
    }

    if ($err = 1) {
      return $res->withJson([
        'success' => true,
        'code' => 1,
        'msg' => 'id user ' . $args['id'] . ' berhasil diupdate',
        'data_back' => $put
      ]);
    } else {
      return $res->withJson([
        'success' => false,
        'code' => 2,
        'msg' => 'gagal update.'
      ]);
    }
  }

  public function get_users_count($req, $res)
  {
    if (isset($_GET['mahasiswa'])) {
      return $res->withJson([
        'success' => true,
        'code' => 1,
        'count' => User::where('level', 2)->count()
      ]);
    }
    if (isset($_GET['dosen'])) {
      return $res->withJson([
        'success' => true,
        'code' => 1,
        'count' => User::where('level', 1)->count()
      ]);
    }
    return $res->withJson([
      'success' => true,
      'code' => 1,
      'count' => User::count()
    ]);
  }
}

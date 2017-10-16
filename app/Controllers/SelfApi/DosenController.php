<?php 

namespace App\Controllers\SelfApi;

use App\Models\Dosen;

class DosenController extends \App\Controllers\Controller
{
  public function index($req, $res)
  {
    $dosen = Dosen::all();
    return $res->withJson([
      'success' => true,
      'code' => 1,
      'data' => $dosen
    ]);
  }

  public function single($req, $res, $arg)
  {
    $dosen = Dosen::where('kd_dosen', $arg['id'])->get();
    return $res->withJson([
      'success' => true,
      'code' => 1,
      'data' => $dosen
    ]);
  }

  public function create($req, $res)
  {
    if ($req->getAttribute('has_errors')) {
      return $res->withJson([
        'success' => false,
        'code' => 1,
        'msg' => $req->getAttribute('errors')
      ]);
    }
    
    $parsed = $req->getParsedBody();

    try {
      // return kd_dosen
      // $parsed[nama] atau yang opsional, itu udah otomatis kalo ga ada bakalan null dari slim nya.
      $dosen = Dosen::create([
        'nip' => $parsed['nip'],
        'nama' => $parsed['nama'],
        'alamat' => $parsed['alamat'],
        'no_hp' => $parsed['no_hp'],
        'foto' => $parsed['foto'],
        'username' => $parsed['username'],
        'password' => $parsed['password'],
      ]);
    } catch (\Exception $e) {
      return $res->withJson([
        'success' => false,
        'code' => 3,
        'msg' => 'error.'
      ]);
    }
  
    return $res->withJson([
      'success' => true,
      'code' => 1,
      'msg' => 'berhasil menyimpan data',
      'data_back' => $parsed
    ]);

  }

  public function update($req, $res, $arg)
  {
    if ($req->getAttribute('has_errors')) {
      return $res->withJson([
        'success' => false,
        'code' => 1,
        'msg' => $req->getAttribute('errors')
      ]);
    }
    
    $parsed = $req->getParsedBody();
    
    $update_success = [];
    foreach ($parsed as $index => $value) {
      try {
        Dosen::where('kd_dosen', $arg['id'])->update([
          "$index" => $value
        ]);
        $update_success[$index] = true;
      } catch (\Exception $e) {
        $update_success[$index] = false;
      }
    }

    return $res->withJson([
      'success' => true,
      'code' => 1,
      'msg' => $update_success,
      'data_back' => $parsed
    ]);
  }

  public function delete($req, $res, $arg)
  {
    try {
      Dosen::where('kd_dosen', $arg['id'])->delete();
    } catch (\Exception $e) {
      return $res->withJson([
        'success' => false,
        'code' => 3,
        'msg' => 'error.'
      ]);
    }

    return $res->withJson([
      'success' => true,
      'code' => 1,
      'msg' => 'berhasil menghapus data'
    ]);
  }
}

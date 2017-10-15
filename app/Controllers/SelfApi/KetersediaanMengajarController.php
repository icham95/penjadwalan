<?php 

namespace App\Controllers\SelfApi;

use App\Models\KetersediaanMengajar;

class KetersediaanMengajarController extends \App\Controllers\Controller
{
  public function index($req, $res)
  {
    $ketersediaanMengajar = KetersediaanMengajar::all();
    return $res->withJson([
      'success' => true,
      'code' => 1,
      'data' => $ketersediaanMengajar
    ]);
  }

  public function single($req, $res, $arg)
  {
    $ketersediaanMengajar = KetersediaanMengajar::where('kd_km', $arg['id'])->get();
    return $res->withJson([
      'success' => true,
      'code' => 1,
      'data' => $ketersediaanMengajar
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
      // $parsed[nama] atau yang opsional, itu udah otomatis kalo ga ada bakalan null dari slim nya.
      $ketersediaanMengajar = KetersediaanMengajar::create([
        'kd_tahun_akademik' => $parsed['kd_thn_akademik'],
        'semester' => $parsed['semester'],
        'hari' => $parsed['hari'],
        'waktu_mulai' => $parsed['waktu_mulai'],
        'waktu_akhir' => $parsed['waktu_akhir']
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
        KetersediaanMengajar::where('kd_km', $arg['id'])->update([
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
      KetersediaanMengajar::where('kd_km', $arg['id'])->delete();
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

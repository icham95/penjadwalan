<?php 

namespace App\Controllers\SelfApi;

use App\Models\TahunAkademik;

class TahunAkademikController extends \App\Controllers\Controller
{
  public function index($req, $res)
  {
    $tahunAkademik = TahunAkademik::all();
    return $res->withJson([
      'success' => true,
      'code' => 1,
      'data' => $tahunAkademik
    ]);
  }

  public function single($req, $res, $arg)
  {
    $tahunAkademik = TahunAkademik::where('kd_thn_akademik', $arg['id'])->get();
    return $res->withJson([
      'success' => true,
      'code' => 1,
      'data' => $tahunAkademik
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
      $tahunAkademik = TahunAkademik::create([
        'thn_akademik' => $parsed['thn_akademik'],
        'semester' => $parsed['semester'],
        'status_thn_akademik' => $parsed['status_thn_akademik']
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
        TahunAkademik::where('kd_thn_akademik', $arg['id'])->update([
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
      TahunAkademik::where('kd_thn_akademik', $arg['id'])->delete();
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

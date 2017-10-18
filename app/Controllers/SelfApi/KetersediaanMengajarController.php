<?php 

namespace App\Controllers\SelfApi;

use App\Models\KetersediaanMengajar;

class KetersediaanMengajarController extends \App\Controllers\Controller
{
  public function index($req, $res)
  {
    $orderBy    = (isset($_GET['orderBy']) ? $_GET['orderBy'] : 'kd_km');
    $orderValue = (isset($_GET['orderValue']) ? $_GET['orderValue'] : 'desc');
    $whereBy    = (isset($_GET['whereBy']) ? $_GET['whereBy'] : 'kd_km');
    $whereValue = (isset($_GET['whereValue']) ? $_GET['whereValue'] : '');
    $limit      = (isset($_GET['limit']) ? $_GET['limit'] : '10');
    $offset     = (isset($_GET['offset']) ? $_GET['offset'] : '0');
    
    $tahun      = (isset($_GET['tahun']) ? $_GET['tahun'] : '');
    $tahun      = urldecode($tahun);
    $semester   = (isset($_GET['semester']) ? $_GET['semester'] : '');
    $hari       = (isset($_GET['hari']) ? $_GET['hari'] : '');
    $waktu_mulai       = (isset($_GET['waktu_mulai']) ? $_GET['waktu_mulai'] : '');
    $waktu_akhir       = (isset($_GET['waktu_akhir']) ? $_GET['waktu_akhir'] : '');

    $ketersediaanMengajar = KetersediaanMengajar::with(['tahun_akademik' => function ($query) use($tahun) {
                              $query->where('thn_akademik', 'like', '%' . $tahun . '%');
                            }])
                            ->whereHas('tahun_akademik', function ($query) use($tahun) {
                              $query->where('thn_akademik', 'like', '%' . $tahun . '%');
                            })
                            ->orderBy($orderBy, $orderValue)
                            ->where('semester', 'like', '%' . $semester . '%')
                            ->where('hari', 'like', '%' . $hari . '%')
                            ->where('waktu_mulai', 'like', '%' . $waktu_mulai . '%')
                            ->where('waktu_akhir', 'like', '%' . $waktu_akhir . '%')
                            ->offset($offset)
                            ->limit($limit);
    if ($whereBy != 'kd_km') {
      $ketersediaanMengajar = $ketersediaanMengajar->where($whereBy, '=', $whereValue);
    }
    $ketersediaanMengajar = $ketersediaanMengajar->get();
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

  public function create($req, $res, $arg)
  {
    $parsed = $req->getParsedBody();
    
    try {
      // $parsed[nama] atau yang opsional, itu udah otomatis kalo ga ada bakalan null dari slim nya.
      $ketersediaanMengajar = KetersediaanMengajar::create([
        'kd_tahun_akademik' => $parsed['kd_tahun_akademik'],
        'semester' => $parsed['semester'],
        'hari' => $parsed['hari'],
        'waktu_mulai' => $parsed['waktu_mulai'],
        'waktu_akhir' => $parsed['waktu_akhir'],
        'kd_dosen' => $arg['id']
      ]);
    } catch (\Exception $e) {
      return $res->withJson([
        'success' => false,
        'code' => 3,
        'msg' => 'error.' . $e
      ]);
    }
  
    return $res->withJson([
      'success' => true,
      'code' => 1,
      'msg' => 'berhasil menyimpan data',
      'data_back' => KetersediaanMengajar::with('tahun_akademik')->where('kd_km', $ketersediaanMengajar->kd_km)->first()
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

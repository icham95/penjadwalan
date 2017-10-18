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
    $foto = false;
    foreach ($parsed as $index => $value) {
      if ($index == 'foto') {
        try {
          $path = $this->path . 'resources/images/';
          $new_name = md5(time()) . '.png';
          $path = $path . $new_name;
          
          $img = base64_decode($value);
          $img = imagecreatefromstring($img);

          imagepng($img, $path);
          imagedestroy($img);

          // cek apakah user punya foto sebelum nya
          $dosen = Dosen::where('kd_dosen', $arg['id'])->first();
          if ($dosen->foto != null) {
            // delete foto
            if (file_exists($this->path . 'resources/images/' . $dosen->foto)) {
              unlink($this->path . 'resources/images/' . $dosen->foto);
            }
          }
          
          $dosen->update([
            "$index" => $new_name
          ]);
          
          $foto = true;
          $update_success[$index] = true;
        } catch (\Exception $e) {
          return $res->withJson([
            'success' => false,
            'code' => 2,
            'msg' => 'upload foto failed'
          ]);      
        }
      } else {
        try {
          Dosen::where('kd_dosen', $arg['id'])->update([
            "$index" => $value
          ]);
          $update_success[$index] = true;
        } catch (\Exception $e) {
          $update_success[$index] = false;
        }
      }
    }

    return $res->withJson([
      'success' => true,
      'code' => 1,
      'msg' => $update_success,
      'data_back' => ($foto) ? $new_name : $parsed,
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

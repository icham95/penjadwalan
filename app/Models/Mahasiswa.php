<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
  protected $table = "tbl_mahasiswa";
  protected $guarded = [];
  protected $primaryKey = 'id_mahasiswa';
}

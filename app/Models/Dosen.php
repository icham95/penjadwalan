<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
  protected $table = "tbl_dosen";
  protected $guarded = [];
  protected $primaryKey = 'id_dosen';
}

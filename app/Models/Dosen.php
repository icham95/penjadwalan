<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
  protected $table = "tbl_dosen";
  protected $guarded = [];
  protected $primaryKey = 'kd_dosen';
  public $timestamps = false;

  public function km()
  {
    return $this->hasMany('App\Models\KetersediaanMengajar', 'kd_dosen', 'kd_dosen');
  }
}

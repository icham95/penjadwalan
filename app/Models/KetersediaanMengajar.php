<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KetersediaanMengajar extends Model
{
  protected $table = "tbl_ketersediaan_mengajar";
  protected $guarded = [];
  protected $primaryKey = 'kd_km';
  public $timestamps = false;
}

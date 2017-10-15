<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
  protected $table = "tbl_thn_akademik";
  protected $guarded = [];
  protected $primaryKey = 'kd_thn_akademik';
  public $timestamps = false;
}

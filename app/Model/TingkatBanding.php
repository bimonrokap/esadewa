<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TingkatBanding extends Model
{
    protected $fillable = ['id_wilayah', 'lingkungan', 'id_satker'];
}

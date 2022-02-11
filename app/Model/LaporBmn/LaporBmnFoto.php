<?php

namespace App\Model\LaporBmn;

use Illuminate\Database\Eloquent\Model;

class LaporBmnFoto extends Model
{
    protected $fillable = ['id_lapor_bmn', 'foto'];

    /**
     * @param $id
     * @param null $file
     * @param bool $asset
     * @return string
     */
    static function imageLocation($id, $file = null, $asset = false)
    {
        if($asset) {
            return asset("file/lapor/".$id."/foto" . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/lapor/".$id."/foto" . (!is_null($file) ? '/'.$file : ''));
    }
}

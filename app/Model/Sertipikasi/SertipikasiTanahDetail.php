<?php

namespace App\Model\Sertipikasi;

use Illuminate\Database\Eloquent\Model;

class SertipikasiTanahDetail extends Model
{
    protected $fillable = [
        'id_sertipikasi_tanah',
        'letter_number',
        'letter_date',
        'perihal',
        'catatan',
        'dokumen',
        'created_by'
    ];

    /**
     * @param $id
     * @param null $file
     * @param bool $asset
     * @return string
     */
    static function docLocation($id, $file = null, $asset = false)
    {
        if($asset) {
            return asset("file/sertipikasi/".$id."/doc" . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/sertipikasi/".$id."/doc" . (!is_null($file) ? '/'.$file : ''));
    }
}

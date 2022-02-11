<?php

namespace App\Model\LaporBmn;

use App\Scope\ScopeUsulanBy;
use Illuminate\Database\Eloquent\Model;

class LaporBmn extends Model
{
    use ScopeUsulanBy;

    protected $fillable = ['id_asset', 'id_category_asset', 'jenis', 'uraian', 'status', 'file', 'created_by'];

    /**
     * @param $id
     * @param null $file
     * @param bool $asset
     * @return string
     */
    static function docLocation($id, $file = null, $asset = false)
    {
        if($asset) {
            return asset("file/lapor/".$id . '/doc' . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/lapor/".$id . '/doc' . (!is_null($file) ? '/'.$file : ''));
    }

    /**
     * @param $id
     * @param null $file
     * @param bool $asset
     * @return string
     */
    static function balasLocation($id, $file = null, $asset = false)
    {
        if($asset) {
            return asset("file/lapor/".$id . '/balas' . (!is_null($file) ? '/'.$file : ''));
        }
        return public_path("file/lapor/".$id . '/balas' . (!is_null($file) ? '/'.$file : ''));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function foto()
    {
        return $this->hasMany('App\Model\LaporBmn\LaporBmnFoto', 'id_lapor_bmn');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reply()
    {
        return $this->hasMany('App\Model\LaporBmn\LaporBmnReply', 'id_lapor_bmn');
    }
}

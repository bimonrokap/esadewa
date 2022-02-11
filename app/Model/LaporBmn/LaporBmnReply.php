<?php

namespace App\Model\LaporBmn;

use App\Scope\ScopeUsulanBy;
use Illuminate\Database\Eloquent\Model;

class LaporBmnReply extends Model
{
    use ScopeUsulanBy;

    protected $fillable = ['id_lapor_bmn', 'jawaban', 'file', 'created_by'];

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}

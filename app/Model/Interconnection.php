<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Interconnection extends Model
{
    protected $fillable = ['table', 'count', 'date', 'status', 'count_real'];
}

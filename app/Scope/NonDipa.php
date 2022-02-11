<?php
namespace App\Scope;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class NonDipa implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where(function ($query){
            $query->where(\DB::raw('SUBSTRING(kode, 1, 5)'), '00501')->orWhere(function ($q){
                $q->where(\DB::raw('SUBSTRING(kode, 1, 5)'), '!=', '00501')->where(\DB::raw('SUBSTRING(kode, -2)'), 'KP');
            });
        });
    }
}
<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\PermissionGroup
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $id_permission_type
 * @property string $slug
 * @property string $name
 * @property string $desc
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereIdPermissionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PermissionGroup whereSlug($value)
 */
class PermissionGroup extends Model
{
    /**
     * Indicates for mass assigment create method
     *
     * @var array
     */
    protected $fillable = [];
}

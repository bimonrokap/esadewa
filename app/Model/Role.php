<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Role
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Permission[] $permission
 * @property-write mixed $slug
 * @mixin \Eloquent
 * @property-read \App\Model\Role $parent
 * @property int $id
 * @property int|null $id_parent
 * @property string $name
 * @property string|null $description
 * @property int $level
 * @property string $type
 * @property int $created_by
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $permission_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereIdParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
class Role extends Model
{
    CONST SUPERADMIN = 1;
    CONST ADMIN = 2;
    CONST ADMIN_SATKER = 3;
    CONST SATKER = 4;
    CONST ADMIN_TINGKAT_BANDING = 5;
    CONST TINGKAT_BANDING = 6;
    CONST KORWIL = 7;
    CONST ESELON = 8;
    CONST ADMIN_KORWIL = 9;
    CONST ADMIN_ESELON = 10;
    CONST ADMIN_PUSAT = 11;

    protected $fillable = ['name', 'slug', 'level', 'type', 'id_parent', 'description'];

    /**
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }

    /**
     * Relation Many to Many with Permission
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function permission()
    {
        return $this->belongsToMany('App\Model\Permission', 'role_permissions');
    }

    public function parent()
    {
        return $this->belongsTo('App\Model\Role', 'id_parent');
    }
}

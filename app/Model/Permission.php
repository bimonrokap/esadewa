<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Permission
 *
 * @property-read \App\Model\Menu $menu
 * @mixin \Eloquent
 * @property int $id
 * @property int $menu_id
 * @property int $permission_group_id
 * @property string $name
 * @property string $display_name
 * @property string|null $desc
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $active
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission wherePermissionGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
class Permission extends Model {

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permissions';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    protected $casts = [
        'permission_group_id' => 'integer',
        'menu_id' => 'integer'
    ];

    /**
     * Indicates for mass assigment create method
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display-name',
        'desc',
    ];

    /**
     * Get the menu record associated with the permission.
     */
    public function menu()
    {
        return $this->belongsTo('App\Model\Menu');
    }
}

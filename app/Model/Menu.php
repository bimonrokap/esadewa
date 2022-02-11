<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Menu
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Menu[] $children
 * @property-read \App\Model\Menu $parent
 * @property-write mixed $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Menu childless()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Permission[] $permission
 * @property int $id
 * @property int|null $id_parent
 * @property string $name
 * @property string|null $icon
 * @property string $title
 * @property string|null $route
 * @property int $order
 * @property int $weight
 * @property int|null $active
 * @property string|null $type
 * @property-read \Illuminate\Database\Eloquent\Collection|Menu[] $allChildren
 * @property-read int|null $all_children_count
 * @property-read Menu|null $allParent
 * @property-read int|null $children_count
 * @property-read int|null $permission_count
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu query()
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereIdParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereRoute($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Menu whereWeight($value)
 */
class Menu extends Model
{

    protected $casts = [
        'order'  => 'integer',
        'weight' => 'integer',
    ];


    /**
     * @param $q
     */
    public function scopeChildless($q)
    {
        $q->has('children', '=', 0);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Model\Menu', 'id_parent')->orderBy('order')->whereActive(1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Model\Menu', 'id_parent');
    }

    /**
     * Get the menu record associated with the permission.
     */
    public function permission()
    {
        return $this->hasMany('App\Model\Permission')->whereActive(1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function allParent()
    {
        return $this->parent()->with('allParent');
    }

    /**
     * set Slug attribte
     *
     * @param $value
     */
    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }
}

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Menu
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Tutorial[] $children
 * @property-read \App\Model\Tutorial $parent
 * @property-write mixed $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Tutorial childless()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Permission[] $permission
 * @property int $id
 * @property int|null $id_parent
 * @property string|null $filename
 * @property string|null $file
 * @property string|null $filetype
 * @property string|null $type
 * @property int|null $orders
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $order
 * @property-read \Illuminate\Database\Eloquent\Collection|Tutorial[] $allChildren
 * @property-read int|null $all_children_count
 * @property-read Tutorial|null $allParent
 * @property-read int|null $children_count
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial whereFiletype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial whereIdParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial whereOrders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tutorial whereUpdatedAt($value)
 */
class Tutorial extends Model
{

    protected $fillable = ['filename', 'id_parent', 'file', 'filetype', 'type', 'order'];

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
        return $this->hasMany('App\Model\Tutorial', 'id_parent')->orderBy('type', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Model\Tutorial', 'id_parent');
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
}

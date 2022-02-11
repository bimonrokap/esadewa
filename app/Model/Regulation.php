<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Menu
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Regulation[] $children
 * @property-read \App\Model\Regulation $parent
 * @property-write mixed $slug
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Regulation childless()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Permission[] $permission
 * @property int $id
 * @property int|null $id_parent
 * @property string|null $filename
 * @property string|null $file
 * @property string|null $filetype
 * @property string|null $type
 * @property int|null $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Regulation[] $allChildren
 * @property-read int|null $all_children_count
 * @property-read Regulation|null $allParent
 * @property-read int|null $children_count
 * @method static \Illuminate\Database\Eloquent\Builder|Regulation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Regulation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Regulation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Regulation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regulation whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regulation whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regulation whereFiletype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regulation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regulation whereIdParent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regulation whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regulation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Regulation whereUpdatedAt($value)
 */
class Regulation extends Model
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
        return $this->hasMany('App\Model\Regulation', 'id_parent')->orderBy('type', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Model\Regulation', 'id_parent');
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

<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\DocTemplate
 *
 * @property int $id
 * @property int|null $id_default_doc_template_history
 * @property string|null $name
 * @property string|null $slug
 * @property-read \App\Model\DocTemplateHistory|null $defaultDocument
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\DocTemplateHistory[] $history
 * @property-read int|null $history_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\DocTemplateParam[] $param
 * @property-read int|null $param_count
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplate whereIdDefaultDocTemplateHistory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplate whereSlug($value)
 * @mixin \Eloquent
 */
class DocTemplate extends Model
{
    public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function history()
    {
        return $this->hasMany('App\Model\DocTemplateHistory', 'id_doc_template');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function defaultDocument()
    {
        return $this->belongsTo('App\Model\DocTemplateHistory', 'id_default_doc_template_history');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function param()
    {
        return $this->hasMany('App\Model\DocTemplateParam', 'id_doc_template');
    }
}

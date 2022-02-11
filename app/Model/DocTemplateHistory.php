<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\DocTemplateHistory
 *
 * @property int $id
 * @property int $id_doc_template
 * @property string|null $version
 * @property string|null $file
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\DocTemplate $document
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateHistory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateHistory whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateHistory whereIdDocTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateHistory whereVersion($value)
 * @mixin \Eloquent
 */
class DocTemplateHistory extends Model
{
    protected $fillable = ['id_doc_template', 'version', 'file', 'created_by'];

    public function document()
    {
        return $this->belongsTo('App\Model\DocTemplate', 'id_doc_template');
    }
}

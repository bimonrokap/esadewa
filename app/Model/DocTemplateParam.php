<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\DocTemplateParam
 *
 * @property int $id
 * @property int $id_doc_template
 * @property string|null $name
 * @property string|null $value
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateParam newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateParam newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateParam query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateParam whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateParam whereIdDocTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateParam whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocTemplateParam whereValue($value)
 * @mixin \Eloquent
 */
class DocTemplateParam extends Model
{
    public $timestamps = false;

    protected $fillable = ['id_doc_template', 'name', 'value'];
}

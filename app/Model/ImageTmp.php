<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\ImageTmp
 *
 * @property int $id
 * @property string|null $uuid
 * @property string $file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ImageTmp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageTmp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageTmp query()
 * @method static \Illuminate\Database\Eloquent\Builder|ImageTmp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageTmp whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageTmp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageTmp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ImageTmp whereUuid($value)
 * @mixin \Eloquent
 */
class ImageTmp extends Model
{

    protected $fillable = ['uuid', 'file'];

    /**
     * @return string
     */
    static function imageLocation()
    {
        return public_path('file/tmpImage');
    }
}

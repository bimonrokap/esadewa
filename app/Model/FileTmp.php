<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\FileTmp
 *
 * @property int $id
 * @property string|null $uuid
 * @property string $file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|FileTmp newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileTmp newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FileTmp query()
 * @method static \Illuminate\Database\Eloquent\Builder|FileTmp whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileTmp whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileTmp whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileTmp whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FileTmp whereUuid($value)
 * @mixin \Eloquent
 */
class FileTmp extends Model
{

    protected $fillable = ['uuid', 'file'];

    /**
     * @return string
     */
    static function location()
    {
        return public_path('file/fileFile');
    }
}

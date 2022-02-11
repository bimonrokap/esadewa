<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Faq
 *
 * @mixin \Eloquent
 * @property int $id
 * @property string $object
 * @property string $file
 * @property string|null $date
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UploadAsset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UploadAsset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UploadAsset query()
 * @method static \Illuminate\Database\Eloquent\Builder|UploadAsset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UploadAsset whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UploadAsset whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UploadAsset whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UploadAsset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UploadAsset whereObject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UploadAsset whereUpdatedAt($value)
 */
class UploadAsset extends Model
{
    protected $fillable = ['object', 'file', 'date', 'created_by'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}

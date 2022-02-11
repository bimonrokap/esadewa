<?php
namespace App\Model;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\Faq
 *
 * @mixin \Eloquent
 * @property int $id
 * @property int $satker_id
 * @property string $file
 * @property string $date
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Model\Satker $satker
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|BackupSimak newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BackupSimak newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BackupSimak query()
 * @method static \Illuminate\Database\Eloquent\Builder|BackupSimak whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupSimak whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupSimak whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupSimak whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupSimak whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupSimak whereSatkerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupSimak whereUpdatedAt($value)
 */
class BackupSimak extends Model
{
    protected $fillable = ['satker_id', 'file', 'date', 'created_by'];

    static function latestData($date = null)
    {
        if(!is_null($date)) {
            $dateNow = Carbon::parse($date)->subMonth(1);
        } else {
            $dateNow = Carbon::now()->subMonth(1);
        }

        return self::whereSatkerId(\Auth::user()->id_satker)
            ->whereYear('date', $dateNow->year)
            ->whereMonth('date', $dateNow->month)
            ->first();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function satker()
    {
        return $this->belongsTo('App\Model\Satker', 'satker_id');
    }
}

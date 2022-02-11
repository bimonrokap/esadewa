<?php

namespace App;

use App\Model\Role;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Role[] $roles
 * @mixin \Eloquent
 * @property-read \App\Model\Satker $satker
 * @property-write mixed $password
 * @property int $id
 * @property int $id_role
 * @property int|null $id_wilayah
 * @property int|null $id_satker
 * @property string|null $lingkungan
 * @property string|null $nip
 * @property string $name
 * @property string $username
 * @property string|null $jabatan
 * @property string|null $telp
 * @property string|null $image
 * @property string|null $type
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read int|null $notifications_count
 * @property-read Role $role
 * @property-read \App\Model\Wilayah|null $wilayah
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIdWilayah($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJabatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLingkungan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUsername($value)
 */
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_role', 'id_wilayah', 'name', 'username', 'password', 'image', 'id_satker', 'type', 'telp', 'nip', 'jabatan', 'lingkungan'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Model\Role', 'id_role');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function satker()
    {
        return $this->belongsTo('App\Model\Satker', 'id_satker');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wilayah()
    {
        return $this->belongsTo('App\Model\Wilayah', 'id_wilayah');
    }

    /**
     * @return mixed
     */
    public function maxRoleLevel()
    {
        return $this->role;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        // TODO Cache
        return $this->id_role ==  Role::SUPERADMIN;
    }

    /**
     * @return bool
     */
    public function isAdminSatker()
    {
        return $this->id_role == Role::ADMIN_SATKER;
    }

    /**
     * @return bool
     */
    public function isKorwil()
    {
        return $this->id_role == Role::KORWIL;
    }

    /**
     * @return bool
     */
    public function isAdminKorwil()
    {
        return $this->id_role == Role::ADMIN_KORWIL;
    }

    /**
     * @return bool
     */
    public function isEselon()
    {
        return $this->id_role == Role::ESELON;
    }

    /**
     * @return bool
     */
    public function isAdminEselon()
    {
        return $this->id_role == Role::ADMIN_ESELON;
    }

    /**
     * @return bool
     */
    public function isSatkerRole()
    {
        return $this->id_role == Role::SATKER;
    }

    /**
     * @return bool
     */
    public function isTingkatBanding()
    {
        return $this->id_role == Role::TINGKAT_BANDING;
    }

    /**
     * @return bool
     */
    public function isAdminTingkatBanding()
    {
        return $this->id_role == Role::ADMIN_TINGKAT_BANDING;
    }

    /**
     * @return bool
     */
    public function isAdminPusat()
    {
        return $this->id_role == Role::ADMIN_PUSAT;
    }

    public function isBindBySatker()
    {
        return $this->isSatkerRole() || $this->isAdminSatker();
    }

    /**
     * @return bool
     */
    public function isSatker()
    {
        return $this->id_role == Role::SATKER;
    }

    /**
     * @return bool
     */
    public function isPusat()
    {
        return $this->type == 'pusat';
    }
}

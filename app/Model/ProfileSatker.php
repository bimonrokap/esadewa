<?php
namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\ProfileSatker
 *
 * @property int $id
 * @property int $id_satker
 * @property string $ketua_pengadilan
 * @property string|null $wakil_ketua_pengadilan
 * @property int|null $jumlah_hakim
 * @property string|null $panitera_pengadilan
 * @property string|null $sekretaris_pengadilan
 * @property int|null $jumlah_tenaga_teknis
 * @property string|null $klasifikasi
 * @property int|null $jumlah_tenaga_kesekratariatan
 * @property int|null $jumlah_ptt
 * @property string|null $operator_simak
 * @property string|null $alamat_kantor
 * @property string|null $telp
 * @property string|null $no_hp
 * @property string|null $koord
 * @property string|null $website
 * @property string|null $email_kantor
 * @property string|null $email_admin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereAlamatKantor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereEmailAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereEmailKantor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereIdSatker($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereJumlahHakim($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereJumlahPtt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereJumlahTenagaKesekratariatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereJumlahTenagaTeknis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereKetuaPengadilan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereKlasifikasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereKoord($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereNoHp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereOperatorSimak($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker wherePaniteraPengadilan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereSekretarisPengadilan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereTelp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereWakilKetuaPengadilan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProfileSatker whereWebsite($value)
 * @mixin \Eloquent
 */
class ProfileSatker extends Model
{
    protected $fillable = [
        'id_satker',
        'ketua_pengadilan',
        'wakil_ketua_pengadilan',
        'jumlah_hakim',
        'panitera_pengadilan',
        'jumlah_tenaga_teknis',
        'no_hp',
        'telp',
        'klasifikasi',
        'sekretaris_pengadilan',
        'jumlah_tenaga_kesekratariatan',
        'jumlah_ptt',
        'operator_simak',
        'website',
        'email_kantor',
        'email_admin',
        'koord',
        'alamat_kantor'
    ];
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = 'layanan';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama'
    ];

    public function getTambalBan($query = true){
        return $query ? $this->belongsToMany(
            'App\Tambalban',
            'layanan_tambal_ban',
            'layanan_id',
            'tambal_ban_id') :
            $this->belongsToMany(
            'App\Tambalban',
            'layanan_tambal_ban',
            'layanan_id',
            'tambal_ban_id')->get();
    }
}

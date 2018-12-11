<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TambalBan extends Model
{
    protected $table = 'tambal_ban';

    public $timestamps = false;

    protected $fillable = ['nama', 'lat', 'lng', 'jam_kerja', 'keterangan', 'no_telp'];

    public function getLayanan($query = true){
        return $query ? $this->belongsToMany(
            'App\Layanan',
            'layanan_tambal_ban',
            'tambal_ban_id',
            'layanan_id') :
            $this->belongsToMany(
                'App\Layanan',
                'layanan_tambal_ban',
                'tambal_ban_id',
                'layanan_id')->get();
    }

    public static function getQuery($nama, $layanan = null){

        return is_null($layanan) ? TambalBan::where('nama', 'like', '%' . $nama . '%')->orWhere('alamat', 'like', '%' . $nama . '%')->get() :
            TambalBan::where(function ($q) use ($nama) {
            $q->where('nama', 'like', '%' . $nama . '%')->orWhere('alamat', 'like', '%' . $nama . '%');
        })->where(function ($q) use ($layanan) {
                $q->whereIn('id', $layanan);
        })->get();
    }

    public function getGaleri($query = true){
        return $query ? $this->hasMany('App\Galeri', 'tambal_ban_id') : $this->hasMany('App\Galeri', 'tambal_ban_id')->get();
    }
}

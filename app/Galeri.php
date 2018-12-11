<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $table = 'galeri';

    public $timestamps = false;

    protected $fillable = ['tambal_ban_id', 'gambar'];

    public function getTambalBan($query = true){

    }
}

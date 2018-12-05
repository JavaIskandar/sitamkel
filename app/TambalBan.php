<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TambalBan extends Model
{
    protected $table = 'tambal_ban';

    protected $fillable = ['nama', 'lat', 'lng'];

    public function getLayanan(){

    }
}

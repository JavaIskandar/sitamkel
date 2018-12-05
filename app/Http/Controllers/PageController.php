<?php

namespace App\Http\Controllers;

use App\Helper;
use App\Layanan;
use App\Pengaturan;
use App\TambalBan;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(Request $request){
        $lat = (double)Pengaturan::getOption('default_lat');
        $lng = (double)Pengaturan::getOption('default_lng');
        $zoom = (double)Pengaturan::getOption('default_zoom');

        $layanan = Layanan::all();

        if (is_null($request->q) && is_null($request->layanan)){
            $tambal_ban = TambalBan::all();
        }
        else if (!is_null($request->q) && $request->layanan == ''){
            $tambal_ban = TambalBan::where('nama', 'like', '%' . $request->q . '%')->orWhere('alamat', 'like', '%' . $request->q . '%')->get();
        }

        else if (!is_null($request->q) && $request->layanan != ''){

        }

        foreach ($tambal_ban as $key => $item){
            $tambal_ban[$key]->status_jam = Helper::is_jam_kerja(json_decode($item->jam_kerja));
        }


        $tambal_ban = json_decode(json_encode($tambal_ban));

        return view('welcome', [
            'tambal_ban' => $tambal_ban,
            'layanan' => $layanan,
            'def_lat' => $lat,
            'def_lng' => $lng,
            'def_zoom' => $zoom
        ]);
    }
}

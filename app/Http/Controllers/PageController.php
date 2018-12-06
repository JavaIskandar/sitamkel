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
        else{
            $tambal_ban = $this->getTambalBanByQuery($request);
        }

        foreach ($tambal_ban as $key => $item){
            $tambal_ban[$key]->status_jam = Helper::is_jam_kerja(json_decode($item->jam_kerja));
        }

        return view('welcome', [
            'tambal_ban' => $tambal_ban,
            'layanan' => $layanan,
            'def_lat' => $lat,
            'def_lng' => $lng,
            'def_zoom' => $zoom
        ]);
    }

    private function getTambalBanByQuery($request){

        if (!is_null($request->q) && $request->layanan == ''){
            $tambal_ban = TambalBan::getQuery($request->q);
        }

        else if (!is_null($request->q) && $request->layanan != ''){
            $layanan_id = Layanan::where('id', $request->layanan)->first()->getTambalBan()->get()->pluck('id')->toArray();
            $tambal_ban = TambalBan::getQuery($request->q, $layanan_id);
        }

        else if (is_null($request->q) && $request->layanan != ''){
            $tambal_ban = Layanan::find($request->layanan)->getTambalBan(false);
        }

        return $tambal_ban;
    }

    public function showLoginForm(){
        return view('auth.login');
    }

    public function showDashboard(Request $request){

        $layanan = Layanan::all();

        if (is_null($request->q) && is_null($request->layanan)){
            $tambal_ban = TambalBan::all();
        }
        else{
            $tambal_ban = $this->getTambalBanByQuery($request);
        }

        return view('dashboard', [
            'layanan' => $layanan,
            'tambalBan' => $tambal_ban,
            'no' => 0
        ]);
    }

    public function tambahTambalBan(){
        $layanan = Layanan::all();
        $jam = Helper::get_jam();
        $hari = Helper::get_hari();

        $lat = (double)Pengaturan::getOption('default_lat');
        $lng = (double)Pengaturan::getOption('default_lng');
        $zoom = (double)Pengaturan::getOption('default_zoom');

        return view('form_tambal_ban', [
            'hari' => $hari,
            'jam' => $jam,
            'layanan' => $layanan,
            'def_lat' => $lat,
            'def_lng' => $lng,
            'def_zoom' => $zoom
        ]);
    }

    public function showDetail(Request $request){

        $tambalBan = TambalBan::find($request->id);
        $layanan = $tambalBan->getLayanan(false);
        $hari = Helper::get_hari();

        $lat = (double)Pengaturan::getOption('default_lat');
        $lng = (double)Pengaturan::getOption('default_lng');
        $zoom = (double)Pengaturan::getOption('default_zoom');

        return view('detail_tempat', [
            'tambal_ban' => $tambalBan,
            'layanan' => $layanan,
            'hari' => $hari,
            'jam' => json_decode($tambalBan->jam_kerja),
            'galeri' => [],
            'def_lat' => $lat,
            'def_lng' => $lng,
            'def_zoom' => $zoom
        ]);
    }

    public function showDetailRute(Request $request){

        $tambalBan = TambalBan::find($request->id);

        $lat = (double)Pengaturan::getOption('default_lat');
        $lng = (double)Pengaturan::getOption('default_lng');
        $zoom = (double)Pengaturan::getOption('default_zoom');

        return view('detail_rute', [
            'tambal_ban' => $tambalBan,
            'def_lat' => $lat,
            'def_lng' => $lng,
            'def_zoom' => $zoom
        ]);
    }
}

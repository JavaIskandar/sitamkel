<?php

namespace App\Http\Controllers;

use App\Layanan;
use App\TambalBan;
use Illuminate\Http\Request;

class TambalBanController extends Controller
{
    public function tambahTambalBan(Request $request){

        $jam['buka'] = $request->jam_buka;
        $jam['tutup'] = $request->jam_tutup;

        $jam = json_encode($jam);

        $tambalBan = TambalBan::create([
            'nama' => $request->nama,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'alamat' => $request->alamat,
            'jam_kerja' => $jam,
            'keterangan' => $request->keterangan
        ]);

        $idLayanan = $request->layanan;

        foreach ($idLayanan as $item){
            $layanan = Layanan::find($item);
            $layanan->getTambalBan()->attach($tambalBan->id);
        }


        return redirect()->route('user.dashboard');
    }
    public function updateTambalban(Request $request){

    }
    public function hapusTambalBan(Request $request){

    }
}

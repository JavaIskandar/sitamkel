<?php

namespace App\Http\Controllers;

use App\Galeri;
use App\Helper;
use App\Layanan;
use App\TambalBan;
use Illuminate\Http\Request;

class TambalBanController extends Controller
{
    public function tambahTambalBan(Request $request){

        $jam['buka'] = $request->jam_buka;
        $jam['tutup'] = $request->jam_tutup;

        $jam = json_encode($jam);

        $idLayanan = $request->layanan;

        if(isset($request->gambar)){
            $path = $request->file('gambar')->store('gambar');
        }

        $tambalBan = TambalBan::create([
            'nama' => $request->nama,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'alamat' => $request->alamat,
            'jam_kerja' => $jam,
            'keterangan' => $request->keterangan,
            'gambar' => $path
        ]);

        foreach ($idLayanan as $item){
            $layanan = Layanan::find($item);
            $layanan->getTambalBan()->attach($tambalBan->id);
        }

        return redirect()->route('user.dashboard');
    }
    public function updateTambalban(Request $request){

        $jam['buka'] = $request->jam_buka;
        $jam['tutup'] = $request->jam_tutup;

        $jam = json_encode($jam);
        $tambalBan = TambalBan::find($request->id);
        $tambalBan->update([
            'nama' => $request->nama,
            'lat' => $request->lat,
            'lng' => $request->lng,
            'alamat' => $request->alamat,
            'jam_kerja' => $jam,
            'keterangan' => $request->keterangan
        ]);

        $idLayanan = $request->layanan;

        $tambalBan->getLayanan()->detach();

        foreach ($idLayanan as $item){
            $layanan = Layanan::find($item);
            $layanan->getTambalBan()->attach($tambalBan->id);
        }
    }

    public function tambahBanyak(Request $request){
        $jenis = str_replace(' ', '+', $request->jenis).'+';
        $query = str_replace(' ', '+', $request->q);

        $query = $jenis.$query;
        $query = json_decode(file_get_contents(Helper::get_geocode($query)),true);
        $listTambalBan = TambalBan::all();
        $jumlah = 0;

        foreach ($query as $q){
            //$rq = json_decode(file_get_contents(get_reverse_geocode($q['lat'], $q['lon'])),true);
            $info = explode (",", $q['display_name']);
            $nama_tempat = $info[0];

            $lokasi = $info[1];

            foreach ($info as $key=>$item){
                if($key>1){
                    $lokasi = $lokasi.','.$item;
                }
            }

            $lat = $q['lat'];
            $lng = $q['lon'];
            $cek = true;

            foreach ($listTambalBan as $item){
                if ($item->lat.''  == $lat && $item->lng.'' == $lng){
                    $cek=false;
                }
            }
            if ($cek){
                TambalBan::create([
                    'nama' => $nama_tempat,
                    'lat' => $lat,
                    'lng' => $lng,
                    'alamat' => $lokasi,
                    'jam_kerja' => '{"buka":["--","--","--","--","--","--","--"],"tutup":["--","--","--","--","--","--","--"]}'
                ]);
                $jumlah++;
            }
        }
    }

    public function tambahGaleri(Request $request){
        if(isset($request->gambar)){
            $path = $request->file('gambar')->store('gambar/'.$request->id);
            $galeri = Galeri::create([
                'tambal_ban_id' => $request->id,
                'gambar' => $path
            ]);
        }

    }

    public function hapusTambalBan(Request $request){
        $tambalBan = TambalBan::find($request->id);
        $tambalBan->getLayanan()->detach();
        $tambalBan->getGaleri()->detach();
        $tambalBan->delete();
        return route('user.dashboard');
    }
}

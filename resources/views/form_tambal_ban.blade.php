@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Tambah Tempat</h1>
    </div>
    @if(!$edit)
        <form method="post" action="{{ route('user.tambal-ban.tambah-banyak.proses') }}" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-inline">
                <select class="form-control" name="jenis">
                    <option value="tambal ban">Tambal Ban</option>
                    <option value="bengkel">Bengkel</option>
                </select>
                <div class="form-group">
                    <input class="form-control" type="text" placeholder="nama, wilayah,..." name="q" value=""/>
                    <button name="tambah_banyak" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>
                        Tambah
                    </button>
                </div>
            </div>
        </form>
    @endif
    <br>
    <form method="post"
          action="{{ !$edit ? route('user.tambal-ban.tambah.proses') : route('user.tambal-ban.update.proses', ['id' => $tambal_ban->id]) }}"
          enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nama Tempat <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="nama" value="{{ $edit ? $tambal_ban->nama : '' }}"/>
                </div>
                <div class="form-group">
                    <label>Gambar <span class="text-danger">*</span></label>
                    <input class="form-control" type="file" name="gambar"/>
                </div>
                <div class="form-group">
                    <label>Latitude <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="lat" id="lat"
                           value="{{ $edit ? $tambal_ban->lat : '' }}"/>
                </div>
                <div class="form-group">
                    <label>Longitude <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" id="lng" name="lng"
                           value="{{ $edit ? $tambal_ban->lng : '' }}"/>
                </div>
                <div class="form-group">
                    <label>Lokasi <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" id="alamat" name="alamat"
                           value="{{ $edit ? $tambal_ban->alamat : '' }}"/>
                    <button type="button" onclick="getGeocode()" class="btn btn-primary">GeoCode</button>
                    <button type="button" onclick="getReverseGeocode()" class="btn btn-primary">Reverse GeoCode</button>
                </div>
                <div class="form-group">
                    <label>layanan</label>
                    <div class="row">
                        @foreach ($layanan as $item)
                            <div class="col-lg-6">
                                <div class="checkbox">
                                    @if($edit)
                                        <label><input type="checkbox" id="layanan{{ $item->id }}"
                                                      value="{{ $item->id }}"
                                                      name="layanan[]" {{ in_array($item->id, $layanan_tambal_ban) ? 'checked' : ''}} >{{ $item->nama }}
                                        </label>
                                    @else
                                        <label><input type="checkbox" id="layanan{{ $item->id }}"
                                                      value="{{ $item->id }}"
                                                      name="layanan[]">{{ $item->nama }}
                                        </label>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label>Jam Kerja</label>
                    {{--{!! $hari = \App\Helper::get_hari();--}}
                    {{--$jam = \App\Helper::get_jam(); !!}--}}
                    @foreach ($hari as $key => $item)
                        <div class="row">
                            <div class="col-lg-2">
                                <label>{{ $item }}</label>
                            </div>
                            <div class="col-lg-6">
                                <select name="jam_buka[]">
                                    @foreach ($jam as $item)
                                        @if($edit && isset($tambal_ban->jam_kerja))
                                            <option value="{{ $item }}" {{ json_decode($tambal_ban->jam_kerja)->buka[$key] == $item ? 'selected' : '' }} >{{ $item }}</option>
                                        @else
                                            <option value="{{ $item }}">{{ $item }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                -
                                <select name="jam_tutup[]">
                                    @foreach ($jam as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea class="mce" name="keterangan">{{ $edit ? $tambal_ban->keterangan : '' }}</textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                    <a class="btn btn-danger" href="?m=tempat"><span class="glyphicon glyphicon-arrow-left"></span>
                        Kembali</a>
                </div>
            </div>
            <div class="col-sm-6">
                <div id="map" style="height: 700px;"></div>
                <div class="row">
                    @foreach($galeri as $item)
                        <div class="col-lg-3">
                            <img style="width: 100px; height: 100px"
                                 src="{{ route('user.get-gambar', ['path' => encrypt($item->gambar)]) }}"/>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </form>
    @if($edit)
        <form method="post"
              action="{{ route('user.galeri.tambah.proses', ['id' => $tambal_ban->id]) }}"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            <input class="form-control" type="file" name="gambar"/>
            <button type="submit" class="btn btn-light">Tambah Galeri</button>
        </form>
    @endif
@endsection
@push('js')
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        var defaultCenter = {
            lat: {{ $def_lat }},
            lng: {{ $def_lng }}
        };

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: {{ $def_zoom  }},
            center: defaultCenter
        });

        var marker = new google.maps.Marker({
            position: defaultCenter,
            map: map,
            title: 'Click to zoom',
            draggable: true
        });

        function getReverseGeocode() {

            var lat = document.getElementById('lat').value;
            var lng = document.getElementById('lat').value;
            $.ajax({
                url: "{{ route('get-reverse-geocode') }}",
                method: 'GET',
                data: {
                    lat: lat,
                    lng: lng
                },
                dataType: 'json',
                success: function (data) {
                    // alert(data['lat']);
                    // $('#lat').text(data['lat']);
                    console.log(data);
                    alert(data);

                }
            });
        }

        function getGeocode() {
            var query = document.getElementById('alamat').value;
            $.ajax({
                url: "{{ route('get-geocode') }}",
                method: 'GET',
                data: {query: query},
                dataType: 'json',
                success: function (data) {
                    // alert(data['lat']);
                    // $('#lat').text(data['lat']);
                    document.getElementById('lat').value = data['lat'];
                    document.getElementById('lng').value = data['lon'];

                    var latlng = new google.maps.LatLng(data['lat'], data['lon']);
                    marker.setPosition(latlng);
                }
            });
        }

        var default_lat = {{ $def_lat }};
        var default_lng = {{ $def_lng }};
        var default_zoom = {{ $def_zoom }};

        function initMap() {




            marker.addListener('drag', handleEvent);
            marker.addListener('dragend', handleEvent);

            var infowindow = new google.maps.InfoWindow({
                content: '<h4>Drag untuk pindah lokasi</h4>'
            });

            infowindow.open(map, marker);
        }

        function handleEvent(event) {
            document.getElementById('lat').value = event.latLng.lat();
            document.getElementById('lng').value = event.latLng.lng();
        }

        // https://nominatim.openstreetmap.org/search.php?format=json&q=masjid+surabaya&limit=50

        $(function () {
            initMap();
        })
    </script>
@endpush

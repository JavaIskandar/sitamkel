@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Tambah Tempat</h1>
    </div>
    <form method="post" action="{{ route('user.tambal-ban.tambah.proses') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="form-inline">
            <select class="form-control" name="jenis">
                <option value="tambal ban">Tambal Ban</option>
                <option value="bengkel">Bengkel</option>
            </select>
            <div class="form-group">
                <input class="form-control" type="text" placeholder="nama, wilayah,..." name="query" value=""/>
                <button name="tambah_banyak" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span>
                    Tambah
                </button>
            </div>
        </div>
    </form>
    <br>
    <form method="post" action="{{ route('user.tambal-ban.tambah.proses') }}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nama Tempat <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="nama" value=""/>
                </div>
                <div class="form-group">
                    <label>Gambar <span class="text-danger">*</span></label>
                    <input class="form-control" type="file" name="gambar"/>
                </div>
                <div class="form-group">
                    <label>Latitude <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="lat" id="lat" value=""/>
                </div>
                <div class="form-group">
                    <label>Longitude <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" id="lng" name="lng" value=""/>
                </div>
                <div class="form-group">
                    <label>Lokasi <span class="text-danger">*</span></label>
                    <input class="form-control" type="text" name="alamat" value=""/>
                </div>
                <div class="form-group">
                    <label>layanan</label>
                    <div class="row">
                        @foreach ($layanan as $item)
                            <div class="col-lg-6">
                                <div class="checkbox">
                                    <label><input type="checkbox" id="layanan{{ $item->id }}" value="{{ $item->id }}"
                                                  name="layanan[]">{{ $item->nama }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <label>Jam Kerja</label>
                    {{--{!! $hari = \App\Helper::get_hari();--}}
                    {{--$jam = \App\Helper::get_jam(); !!}--}}
                    @foreach ($hari as $item)
                        <div class="row">
                            <div class="col-lg-2">
                                <label>{{ $item }}</label>
                            </div>
                            <div class="col-lg-6">
                                <select name="jam_buka[]">
                                    @foreach ($jam as $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
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
                    <textarea class="mce" name="keterangan"></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                    <a class="btn btn-danger" href="?m=tempat"><span class="glyphicon glyphicon-arrow-left"></span>
                        Kembali</a>
                </div>
            </div>
            <div class="col-sm-6">
                <div id="map" style="height: 700px;"></div>
            </div>
        </div>
    </form>
@endsection
@push('js')
    <script>
        var default_lat = {{ $def_lat }};
        var default_lng = {{ $def_lng }};
        var default_zoom = {{ $def_zoom }};
    </script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        var defaultCenter = {
            lat: {{ $def_lat }},
            lng: {{ $def_lng }}
        };

        function initMap() {

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

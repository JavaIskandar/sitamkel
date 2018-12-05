@extends('layout')

@section('content')
    <div class="page-header">
        <h1>Tempat</h1>
    </div>
    <form class="form-inline" method="get" action="{{ route('cari') }}">
        {{ csrf_field() }}
        <input type="hidden" name="m" value="tempat"/>
        <div class="form-group">
            <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value=""/>
            <select class="form-control" name="layanan">
                <option value="">Jenis Layanan</option>
                @foreach ($layanan as $item)
                    <option value="{{ $item->id }}"> {{ $item->nama }}</option>
                @endforeach
            </select>
            <button class="btn btn-success"><span class="glyphicon glyphicon-search"></span></button>
        </div>
    </form>
    <br>
    <div id="map" style="height: 500px;"></div>
@endsection

@push('js')
<script>
    function tampilDekat() {
        getCurLocation();

        map_dekat = new google.maps.Map(document.getElementById('map'), {
            zoom: {{ $def_zoom }},
            center: {
                lat: default_lat,
                lng: default_lng
            }
        });

        {{--{{ dd(json_encode($tambal_ban)) }}--}}

        var data =  <?= json_encode($tambal_ban) ?>;

        $.each(data, function (k, v) {
            var obj = JSON.parse(v.jam_kerja);
            var pos = {
                lat: parseFloat(v.lat),
                lng: parseFloat(v.lng)
            };
            var contentString = '<h3>' + v.nama + '</h3>' +
                '<p align="left">'+v.alamat+'</p>'+
                '<p align="center"><a href="?m=tempat_detail&ID=' + v.id + '" class="link_detail btn btn-primary">Lihat Detail</a>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });

            if (v.status_jam == true){
                var marker = new google.maps.Marker({
                    position: pos,
                    icon: {
                        url: "http://maps.google.com/mapfiles/ms/icons/green-dot.png"
                    },
                    map: map_dekat,
                    animation: google.maps.Animation.DROP
                });
            }
            else{
                var marker = new google.maps.Marker({
                    position: pos,
                    icon: {
                        url: "http://maps.google.com/mapfiles/ms/icons/red-dot.png"
                    },
                    map: map_dekat,
                    animation: google.maps.Animation.DROP
                });
            }
            marker.addListener('click', function () {
                infowindow.open(map_dekat, marker);
            });
        });
    }

    $(function () {
        tampilDekat();
    })
</script>
@endpush
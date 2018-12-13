@extends('layout')

@section('content')
<div class="page-header">
    <h1>Tempat</h1>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <form class="form-inline" action="{{ route('user.dashboard') }}", method="get">
            {{ csrf_field() }}
            <input type="hidden" name="m" value="tempat" />
            <div class="form-group">
                <input class="form-control" type="text" placeholder="Pencarian. . ." name="q" value="" />
                <select class="form-control" name="layanan">
                    <option value="">Jenis Layanan</option>
                    @foreach ($layanan as $item)
                        <option value="{{ $item->id }}"> {{ $item->nama }}</option>
                    @endforeach
                </select>
                <button class="btn btn-success"><span class="glyphicon glyphicon-refresh"></span> Refresh</button>
                <a class="btn btn-primary" href="{{ route('user.tambal-ban.tambah') }}"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
            </div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead>
            <tr class="nw">
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Tempat</th>
                <th>Longitude</th>
                <th>Latitude</th>
                <th>Lokasi</th>
                <th>Aksi</th>
            </tr>
            </thead>
            @foreach($tambalBan as $item)
            <tr>
                <td>{{ ++$no }}</td>
                <td><img class="thumbnail" height="60" src="assets/images/tempat/small_{{ $item->gambar }}" /></td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->lat }}</td>
                <td>{{ $item->lng }}</td>
                <td>{{ $item->alamat }}</td>
                <td class="nw">
                    <a class="btn btn-xs btn-warning" href="{{ route('user.tambal-ban.edit', ['id' => $item->id]) }}"><span class="glyphicon glyphicon-edit"></span></a>
                    <a class="btn btn-xs btn-danger" href="" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
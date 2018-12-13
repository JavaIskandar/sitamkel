@extends('layout')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <form class="form-signin" action="{{ route('login.proses') }}" method="post">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" class="form-control" placeholder="Username" name="email" autofocus />
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" id="inputPassword" class="form-control" placeholder="Password" name="password" />
                </div>
                <button class="btn btn-primary btn-block" type="submit"><span class="glyphicon glyphicon-log-in"></span> Masuk</button>
            </form>
        </div>
    </div>
@endsection

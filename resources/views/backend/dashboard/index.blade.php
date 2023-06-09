@extends('layouts.backend')

@section('title')
    Dashboard
@endsection

@section('heading') 
    <h1>
        Halo, <b>{{ Auth::user()->name }}</b>! Selamat datang di halaman dashboard.
    </h1> <br>

    <div class="profile-info">
        <h1>Account Info :</h1>
        <ul>
            <li><strong>Username :</strong> {{ Auth::user()->name }}</li>
            <li><strong>Email :</strong> {{ Auth::user()->email }}</li>
            <li><strong>Level :</strong> {{ Auth::user()->roles }}</li>
        </ul>
    </div>
@endsection

@section('content')
@endsection

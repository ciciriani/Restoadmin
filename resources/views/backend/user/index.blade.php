@extends('layouts.backend')

@section('title')
    User
@endsection

@section('headerScripts')
    <!-- token csrf-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- css sweetalert-->
    <link rel="stylesheet" href="{{ asset('sweetalert/src/sweetalert2.scss') }}">
    <!-- css datatables -->
    <link rel="stylesheet" href="{{ asset('datatable/dataTables.bootstrap4.min.css') }}">
@endsection

@section('heading') 
    Halaman Pengguna
@endsection

@section('subHeading') 
    User
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addModalUser">
                            <span class="fas fa-plus"></span>
                            Tambah User
                        </button>
                    </div>
                    <div class="row">
                        <div class="col md-12 col-sm-12 table-responsive">
                            <table id="tableUser" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="main_checkbox" name="main_checkbox">
                                        </th>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Roles</th>
                                        <th>
                                            Action <br>
                                            <button class="btn btn-danger btn-sm" id="delAllBtn" type="submit">
                                                Hapus
                                            </button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.user.addModalUser')
    @include('backend.user.editModalUser')
@endsection

@section('footerScripts')
    <!-- js sweetalert-->
    <script src="{{ asset('sweetalert/src/sweetalert2.js') }}"></script>
    <script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/dataTables.bootstrap4.min.js') }}"></script>

    @include('backend.user.scripts')


@endsection
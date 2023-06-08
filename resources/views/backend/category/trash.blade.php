@extends('layouts.backend')

@section('title')
  Sampah
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
    Halaman Sampah
@endsection

@section('subHeading') 
    Sampah
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <ul class="nav nav-pills mb-2">
                                <li class="nav-item">
                                  <a class="nav-link active" href="{{ route('category.trash') }}">
                                    <span class="fas fa-trash"></span>
                                    Sampah
                                  </a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" href="{{ route('category') }}">
                                    <span class="fas fa-address-book"></span>
                                    Kategori
                                  </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col md-12 col-sm-12 table-responsive">
                            <table id="tableCategoryTrash" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            <input type="checkbox" id="mainTrash_checkbox" name="mainTrash_checkbox">
                                        </th>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Slug</th>
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
@endsection

@section('footerScripts')
    <!-- js sweetalert-->
    <script src="{{ asset('sweetalert/src/sweetalert2.js') }}"></script>
    <script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/dataTables.bootstrap4.min.js') }}"></script>

    @include('backend.category.scripts')


@endsection
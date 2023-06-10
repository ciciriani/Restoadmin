@extends('layouts.backend')

@section('title')
    Foods
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
    History Order
@endsection

@section('subHeading')
    Order
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#addModalOrders">
                            <span class="fas fa-plus"></span>
                            Tambah Order
                        </button>
                    </div>
                    <div class="col mb-3 text-right">
                        <button class="btn btn-danger" onclick="window.print()">PDF</button>
                    </div>
                    <div class="row">
                        <div class="col md-12 col-sm-12 table-responsive">
                            <table id="tableOrders" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>List Pembelian</th>
                                        <th>Total Harga</th>
                                        <th>Tanggal Transaksi</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $order->nama_pelanggan }}
                                            </td>
                                            <td>
                                                <ul>
                                                    @foreach ($order->orderDetails as $orderDetail)
                                                        <li>{{ $orderDetail->food->name }}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                {{ $order->total_harga }}
                                            </td>
                                            <td>
                                                {{ $order->created_at }}
                                            </td>
                                            <td>
                                                <a href="orders/destroy/{{ $order->id }}">
                                                    <button class="btn btn-danger">
                                                        <span class="fas fa-trash"></span> Hapus Histori
                                                    </button>
                                                </a>


                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('backend.orders.addModalOrders')
    @include('backend.orders.editModalOrders')
@endsection

@section('footerScripts')
    @include('backend.orders.scripts')
    <!-- js sweetalert-->
    <script src="{{ asset('sweetalert/src/sweetalert2.js') }}"></script>
    <script src="{{ asset('datatable/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                multiple: true
            });
        });
    </script>
@endsection

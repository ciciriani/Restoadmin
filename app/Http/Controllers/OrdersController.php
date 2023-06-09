<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function index()
    {
        return view('backend.orders.index');
    }

    public function fetchOrders(Request $request)
    {
        $orders = Orders::orderBy('id', 'desc')->get();

        if ($request->ajax()) {
            return datatables()->of($orders)
                ->addColumn('action', function ($data) {
                    return '
                    <div class="btn-group">
                        <button id="btnEditOrder" class="btn btn-warning btn-sm" data-id="' . $data['id'] . '" type="button">
                            <span class="fas fa-edit"></span>
                        </button>
                        <button id="btnDelOrder" class="btn btn-danger btn-sm" data-id="' . $data['id'] . '" type="button">
                            <span class="fas fa-trash"></span>
                        </button>
                    </div>
                ';
                })
                ->addColumn('checkbox', function ($row) {
                    return '
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="order_checkbox" id="order_checkbox" data-id="' . $row['id'] . '">
                    </div>
                ';
                })->rawColumns(['action', 'checkbox'])->make(true);
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'nama_pelanggan' => 'required | string',
            'id_meja' => 'required | integer',
            'id_food' => 'required | integer',
            'total_harga' => 'required | integer',
        ], [
            'nama_pelanggan.required' => 'Nama harus diisi',
            'nama_pelanggan.string' => 'Nama harus berupa string',
            'id_meja.required' => 'Meja harus diisi',
            'id_meja.integer' => 'Meja harus berupa angka',
            'id_food.required' => 'Makanan harus diisi',
            'id_food.integer' => 'Makanan harus berupa angka',
            'total_harga.required' => 'Total harga harus diisi',
            'total_harga.integer' => 'Total harga harus berupa angka',
        ]);

        if ($validation->passes()) {
            Orders::create([
                'nama_pelanggan' => $request->nama_pelanggan,
                'id_meja' => $request->id_meja,
                'id_food' => $request->id_food,
                'total_harga' => $request->total_harga,
            ]);

            return response()->json([
                'message' => 'Data berhasil ditambahkan',
            ]);
        }

        return response()->json([
            'message' => 'Data gagal ditambahkan',
            'error' => $validation->errors()->all(),
        ]);
    }
}

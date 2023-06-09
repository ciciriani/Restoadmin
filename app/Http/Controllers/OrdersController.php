<?php

namespace App\Http\Controllers;

use App\Models\Foods;
use App\Models\OrderDetails;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public function index()
    {
        // get foods with status tersedia
        $foods = Foods::where('status', 'tersedia')->get();
        $orders = Orders::orderBy('id', 'asc')->get();
        return view('backend.orders.index', compact('foods', 'orders'));
    }

    //store to order details
    public function storeOrderDetails(Request $request)
    {
        $payloadInsertOrder = [
            'nama_pelanggan' => $request->nama_pelanggan,
            'total_harga' => Foods::whereIn('id', $request->id_foods)->sum('harga'),
        ];

        $order = Orders::create($payloadInsertOrder);

        $payloadInsertOrderDetail = [];

        foreach ($request->id_foods as $key => $id_food) {
            $payloadInsertOrderDetail[] = [
                'id_order' => $order->id,
                'id_food' => $id_food,
            ];
        }

        OrderDetails::insert($payloadInsertOrderDetail);

        return back()->with('message', 'Data berhasil ditambahkan');
    }

    public function destroy($id)
    {
        $order = Orders::findOrFail($id);
        $order->delete();

        return back()->with('message', 'Data berhasil dihapus');
    }
}

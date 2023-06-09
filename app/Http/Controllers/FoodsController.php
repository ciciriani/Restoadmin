<?php

namespace App\Http\Controllers;

use App\Models\Foods;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class FoodsController extends Controller
{
    public function index()
    {
        return view('backend.foods.index');
    }

    public function fetchFoods(Request $request)
    {
        $foods = Foods::orderBy('id', 'desc')->get();

        if ($request->ajax()) {
            return datatables()->of($foods)
                ->addColumn('action', function ($data) {
                    return '
                    <div class="btn-group">
                        <button id="btnEditFood" class="btn btn-warning btn-sm" data-id="' . $data['id'] . '" type="button">
                            <span class="fas fa-edit"></span>
                        </button>
                        <button id="btnDelFood" class="btn btn-danger btn-sm" data-id="' . $data['id'] . '" type="button">
                            <span class="fas fa-trash"></span>
                        </button>
                    </div>
                ';
                })
                ->addColumn('checkbox', function ($row) {
                    return '
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="food_checkbox" id="food_checkbox" data-id="' . $row['id'] . '">
                    </div>
                ';
                })->rawColumns(['action', 'checkbox'])->make(true);
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required | string',
            'photo' => 'required | image | mimes:jpeg,png,jpg',
            'harga' => 'required | integer',
            'stock' => 'required | integer',
            'status' => 'required | string',
            'kategori' => 'required | string',
        ], [
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa string',
            'photo.required' => 'Photo harus diisi',
            'photo.image' => 'Photo harus berupa gambar',
            'photo.mimes' => 'Photo harus berupa jpeg, png, jpg',
            'harga.required' => 'Harga harus diisi',
            'harga.integer' => 'Harga harus berupa angka',
            'stock.required' => 'Stock harus diisi',
            'stock.integer' => 'Stock harus berupa angka',
            'status.required' => 'Status harus diisi',
            'status.string' => 'Status harus berupa string',
            'kategori.required' => 'Kategori harus diisi',
            'kategori.string' => 'Kategori harus berupa string',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ]);
        }

        $foods = new Foods();
        $foods->name = $request->name;

        //INSERT FILE NAME TO DATABASE
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); //GET FILE EXTENSION
            $filename = time() . '.' . $extension;
            $file->move('uploads/foods/', $filename);
            $foods->photo = $filename;
        } else {
            return $request;
            $foods->photo = '';
        }

        $foods->harga = $request->harga;
        $foods->stock = $request->stock;
        $foods->slug = Str::slug($request->name, '-');
        $foods->status = $request->status;
        $foods->kategori = $request->kategori;
        $foods->save();

        return response()->json([
            'success' => 'Data berhasil ditambahkan',
        ]);
    }

    public function edit(Request $request)
    {
        $foods = Foods::findOrFail($request->idFoods);

        return response()->json([
            'foods' => $foods,
        ]);
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required | string',
            'harga' => 'required | integer',
            'stock' => 'required | integer',
            'status' => 'required | string',
            'kategori' => 'required | string',
        ], [
            'name.required' => 'Nama harus diisi',
            'name.string' => 'Nama harus berupa string',
            'harga.required' => 'Harga harus diisi',
            'harga.integer' => 'Harga harus berupa angka',
            'stock.required' => 'Stock harus diisi',
            'stock.integer' => 'Stock harus berupa angka',
            'status.required' => 'Status harus diisi',
            'status.string' => 'Status harus berupa string',
            'kategori.required' => 'Kategori harus diisi',
            'kategori.string' => 'Kategori harus berupa string',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'errors' => $validation->errors(),
            ]);
        }

        $foods = Foods::findOrFail($request->idFoods);
        $foods->name = $request->name;

        //INSERT FILE NAME TO DATABASE, IF THERE IS NO FILE, THEN USE THE OLD FILE NAME
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $extension = $file->getClientOriginalExtension(); //GET FILE EXTENSION
            $filename = time() . '.' . $extension;
            $file->move('uploads/foods/', $filename);
            $foods->photo = $filename;
        } else {
            $foods->photo = $foods->photo;
        }

        $foods->harga = $request->harga;
        $foods->stock = $request->stock;
        $foods->slug = Str::slug($request->name, '-');
        $foods->status = $request->status;
        $foods->kategori = $request->kategori;
        $foods->update();

        return response()->json([
            'message' => 'Data berhasil diupdate',
        ]);
    }

    public function destroy(Request $request)
    {
        $foods = Foods::findOrFail($request->idFoods);
        $foods->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Data food dengan nama ' . $foods->name . ' berhasil dihapus',
        ]);
    }

    public function destroySelected(Request $request)
    {
        $foods = Foods::whereIn('id', $request->idFoods);
        $foods->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Tables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TablesController extends Controller
{
    public function index()
    {
        return view('backend.tables.index');
    }

    public function fetchTables(Request $request)
    {
        $tables = Tables::orderBy('id', 'desc')->get();

        if ($request->ajax()) {
            return datatables()->of($tables)
                ->addColumn('action', function ($data) {
                    return '
                    <div class="btn-group">
                        <button id="btnEditTable" class="btn btn-warning btn-sm" data-id="' . $data['id'] . '" type="button">
                            <span class="fas fa-edit"></span>
                        </button>
                        <button id="btnDelTable" class="btn btn-danger btn-sm" data-id="' . $data['id'] . '" type="button">
                            <span class="fas fa-trash"></span>
                        </button>
                    </div>
                ';
                })
                ->addColumn('checkbox', function ($row) {
                    return '
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="table_checkbox" id="table_checkbox" data-id="' . $row['id'] . '">
                    </div>
                ';
                })->rawColumns(['action', 'checkbox'])->make(true);
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'no_meja' => 'required | integer',
        ], [
            'no_meja.required' => 'No Meja harus diisi',
            'no_meja.integer' => 'No Meja harus berupa angka',
        ]);

        if ($validation->failed()) {
            return response()->json([
                'message' => $validation->errors()->all(),
                'status' => 400
            ]);
        }

        $tables = new Tables();
        $tables->no_meja = $request->no_meja;
        $tables->save();

        return response()->json([
            'message' => 'Data berhasil ditambahkan',
            'status' => 200
        ]);
    }

    public function edit(Request $request)
    {
        $tables = Tables::findOrFail($request->idMeja);

        return response()->json([
            'meja' => $tables,
            'status' => 200
        ]);
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'no_meja' => 'required | string',
            'status' => 'required | string',
        ], [
            'no_meja.required' => 'Nomor meja harus diisi',
            'no_meja.string' => 'Nomor meja harus berupa string',
            'status.required' => 'Status harus diisi',
            'status.string' => 'Status harus berupa string',
        ]);

        if ($validation->passes()) {
            $tables = Tables::findOrFail($request->idMeja);
            $tables->no_meja = $request->no_meja;
            $tables->status = $request->status;
            $tables->save();

            return response()->json([
                'message' => 'Data berhasil diupdate',
                'status' => 200
            ]);
        }

        return response()->json([
            'message' => 'Data gagal diupdate',
            'status' => 400
        ]);
    }

    public function destroy(Request $request)
    {
        $tables = Tables::findOrFail($request->idMeja);
        $tables->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'status' => 200
        ]);
    }

    public function destroySelected(Request $request)
    {
        $tables = Tables::whereIn('id', $request->idMeja);
        $tables->delete();

        return response()->json([
            'message' => 'Data berhasil dihapus',
            'status' => 200
        ]);
    }
}

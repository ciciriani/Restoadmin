<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return view('backend.category.index');
    }

    public function fetchCategory(Request $request)
    {
        $categories = Category::all();

        if ($request->ajax()) {
            return datatables()->of($categories)->addIndexColumn()->addColumn('action', function ($row) {
                return '
                    <div class="btn-group">
                        <button id="btnEditCategory" class="btn btn-warning btn-sm" data-id="' . $row['id'] . '" type="button">
                            <span class="fas fa-edit"></span>
                        </button>
                        <button id="btnDelCategory" class="btn btn-danger btn-sm" data-id="' . $row['id'] . '" type="button">
                            <span class="fas fa-trash"></span>
                        </button>
                    </div>
                ';
            })
                ->addColumn('checkbox', function ($row) {
                    return '
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="category_checkbox" id="category_checkbox" data-id="' . $row['id'] . '">
                    </div>
                ';
                })->rawColumns(['action', 'checkbox'])->make(true);
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required | string',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.string' => 'Nama harus berupa string',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validation->errors()->toArray(),
            ]);
        } else {
            $category = new Category();
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->save();

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil disimpan',
            ]);
        }
    }


    public function edit(Request $request)
    {
        $category = Category::findOrFail($request->idCategory);

        return response()->json([
            'status' => 200,
            'category' => $category,
        ]);
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required | string',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'name.string' => 'Nama harus berupa string',
        ]);


        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validation->errors()->toArray(),
            ]);
        } else {
            $category = Category::findOrFail($request->idCategory);
            $category->name = $request->name;
            $category->slug = Str::slug($request->name);
            $category->update();

            return response()->json([
                'status' => 200,
                'message' => 'Data user dengan nama ' . $category->name . ' berhasil diupdate',
            ]);
        }
    }

    public function trash()
    {
        return view('backend.category.trash');
    }

    public function fetchTrash(Request $request)
    {
        $categories = Category::onlyTrashed();

        if ($request->ajax()) {
            return datatables()->of($categories)->addIndexColumn()->addColumn('action', function ($row) {
                return '
                    <div class="btn-group">
                        <button id="btnRestoreCategory" class="btn btn-secondary btn-sm" data-id="' . $row['id'] . '" type="button">
                            <span class="fas fa-retweet"></span>
                        </button>
                        <button id="btnForceDelCategory" class="btn btn-danger btn-sm" data-id="' . $row['id'] . '" type="button">
                            <span class="fas fa-trash"></span>
                        </button>
                    </div>
                ';
            })
                ->addColumn('checkbox', function ($row) {
                    return '
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="categoryTrash_checkbox" id="categoryTrash_checkbox" data-id="' . $row['id'] . '">
                    </div>
                ';
                })->rawColumns(['action', 'checkbox'])->make(true);
        }
    }

    public function destroy(Request $request)
    {
        $category = Category::findOrFail($request->idCategory);
        $category->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Data user dengan nama ' . $category->name . ' berhasil dipindahkan ke trash',
        ]);
    }

    public function restore(Request $request)
    {
        $category = Category::withTrashed()->findOrFail($request->idCategory);
        $category->restore();

        return response()->json([
            'status' => 200,
            'message' => 'Data user dengan nama ' . $category->name . ' berhasil direstore',
        ]);
    }

    public function destroySelectedTrash(Request $request)
    {
        $idCategories = $request->idCategories;

        $query = Category::whereIn('id', $idCategories)->delete();

        if ($query) {
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil dihapus',
            ]);
        }
    }
}

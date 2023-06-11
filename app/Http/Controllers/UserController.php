<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Ini kontroller user, isinya yang berhubungan dengan halaman user, dibaca aja sesuai namanya, fetch itu artinya ngedapetin data
    public function index()
    {
        return view('backend.user.index');
    }
    public function fetchUser(Request $request)
    {
        $users = User::all();

        if ($request->ajax()) {
            return datatables()->of($users)->addIndexColumn()->addColumn('action', function ($row) {
                return '
                    <div class="btn-group">
                        <button id="btnEditUser" class="btn btn-warning btn-sm" data-id="' . $row['id'] . '" type="button">
                            <span class="fas fa-edit"></span>
                        </button>
                        <button id="btnDelUser" class="btn btn-danger btn-sm" data-id="' . $row['id'] . '" type="button">
                            <span class="fas fa-trash"></span>
                        </button>
                    </div>
                ';
            })
                ->addColumn('checkbox', function ($row) {
                    return '
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" name="user_checkbox" id="user_checkbox" data-id="' . $row['id'] . '">
                    </div>
                ';
                })->rawColumns(['action', 'checkbox'])->make(true);
        }
    }

    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required | string',
            'email' => 'required | email',
            'password' => 'required | string',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password tidak boleh kosong',
            'password.string' => 'Password harus berupa string',
        ]);


        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validation->errors()->toArray(),
            ]);
        } else {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->roles = 'admin';
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil disimpan',
            ]);
        }
    }

    public function edit(Request $request)
    {
        $user = User::findOrFail($request->idUser);

        return response()->json([
            'status' => 200,
            'user' => $user,
        ]);
    }

    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required | string',
            'email' => 'required | email',
            'password' => 'required | string',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password tidak boleh kosong',
            'password.string' => 'Password harus berupa string',
        ]);


        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'message' => $validation->errors()->toArray(),
            ]);
        } else {
            $user = User::findOrFail($request->idUser);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->roles = 'admin';
            $user->update();

            return response()->json([
                'status' => 200,
                'message' => 'Data user dengan nama ' . $user->name . ' berhasil diupdate',
            ]);
        }
    }
    public function destroy(Request $request)
    {
        $user = User::findOrFail($request->idUser);
        $user->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Data user dengan nama ' . $user->name . ' berhasil dihapus',
        ]);
    }

    public function destroySelected(Request $request)
    {
        $idUsers = $request->idUsers;
        $query = User::whereIn('id', $idUsers)->delete();

        if ($query) {
            return response()->json([
                'status' => 200,
                'message' => 'Data user berhasil dihapus',
            ]);
        }
    }
}

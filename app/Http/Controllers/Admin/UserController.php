<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->when(request()->q, function($users) {
            $users = $users->where('name', 'like', '%'. request()->q . '%');
        })->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $role = Collection::empty();
        $role->add('Admin');
        $role->add('User');

        $data = Collection::empty();
        $data->put('role', $role);

        return view('admin.user.create',[
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'       => 'required',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|confirmed',
            'role'       => 'required',
        ]);

        //save to DB
        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => bcrypt($request->password),
            'role'       => $request->role,
            'user_id'    => auth()->user()->id,
        ]);

        if($user){
            //redirect dengan pesan sukses
            return redirect()->route('admin.user.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.user.index')->with(['error' => 'Data Gagal Disimpan!']);
        }
    }

    public function edit(User $user)
    {

        $role = Collection::empty();
        $role->add('Admin');
        $role->add('User');

        $data = Collection::empty();
        $data->put('role', $role);

        return view('admin.user.edit', compact('user', 'data'));
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email,'.$user->id,
            'role'       => 'required',
        ]);

        //cek password
        if($request->password == "") {

            //update tanpa password
            $user = User::findOrFail($user->id);
            $user->update([
                'name'       => $request->name,
                'email'      => $request->email,
                'role'       => $request->role,
            ]);

        } else {

            //update dengan password
            $user = User::findOrFail($user->id);
            $user->update([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => bcrypt($request->password),
                'role'       => $request->role,
            ]);
        }

        if($user){
            //redirect dengan pesan sukses
            return redirect()->route('admin.user.index')->with(['success' => 'Data Berhasil Diupdate!']);
        }else{
            //redirect dengan pesan error
            return redirect()->route('admin.user.index')->with(['error' => 'Data Gagal Diupdate!']);
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        if($user){
            return response()->json([
                'status' => 'success'
            ]);
        }else{
            return response()->json([
                'status' => 'error'
            ]);
        }
    }
}

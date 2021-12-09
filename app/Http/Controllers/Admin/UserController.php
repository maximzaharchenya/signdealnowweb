<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->role == 0 || empty($request->role)){
            $users = User::latest()->paginate(8);
        }else{
            $users = User::latest()->where('type', $request->role)->paginate(8);
        }
        return view('admin.users.index')->with('users', $users);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'type' => 'required',
            'email' => ['required', 'string', 'email', 'unique:users'],
        ]);

        if ($validator->fails()) {
            return redirect('/admin/users/add');
        }

        $data = $request->all();
        if ($request->file('profile_image')){
            $data['profile_image'] = $request->file('profile_image')->store('Profile_img', 'public');
        }
        if ($data['password']) $data['password'] = bcrypt($data['password']);
        User::create($data);
        return redirect('/admin/users');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit')->with('user', $user);
    }

    public function update(User $user, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'surname' => 'required',
            'type' => 'required',
            'email' => ['required', 'string', 'email'],
        ]);
        if ($validator->fails()) {
            return redirect('/admin/users/'.$user['id'].'/edit');
        }

        $data = $request->all();

        if ($data['password']){
            $data['password'] = bcrypt($data['password']);
        }else{
            unset($data['password']);
        }

        if ($request->file('profile_image')){
            if (!empty($user['profile_image'])){
                Storage::delete('/public/' . $user->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('Profile_img', 'public');
        }else{
            unset($data['profile_image']);
        }
        $user->update($data);
        return redirect('/admin/users');
    }

    public function delete(User $user){
        $user->delete();
        return redirect('/admin/users');
    }

}


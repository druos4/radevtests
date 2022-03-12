<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use DB;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        $breadcrumbs = [
            ['title' => 'Админпанель', 'url' => '/admin',],
            ['title' => 'Пользователи', 'url' => '',],
        ];
        return view('admin.users.index', compact('users','breadcrumbs'));
    }

    public function create()
    {
        $roles = Role::all()->pluck('name', 'id');
        $breadcrumbs = [
            ['title' => 'Админпанель', 'url' => '/admin',],
            ['title' => 'Пользователи', 'url' => '/admin/users',],
            ['title' => 'Новый пользователь', 'url' => '',],
        ];
        return view('admin.users.create', compact('roles','breadcrumbs'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        DB::table('role_user')->insert([
            'role_id' => $request->get('role'),
            'user_id' => $user->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all()->pluck('name', 'id');
        $user->load('roles');
        $rolesIn = [];
        foreach($user->roles as $role){
            $rolesIn[] = $role->id;
        }

        return view('admin.users.edit', compact('roles', 'user','rolesIn'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->roles()->sync($request->input('role', []));
        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success'=>true, 'id' => $user->id]);
    }

}

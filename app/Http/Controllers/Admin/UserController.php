<?php

namespace App\Http\Controllers\Admin;

use App\AdminRole;
use App\AdminUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = AdminUser::orderBy('created_at', 'desc')->paginate(10);
        return view('admin/user/index', compact('users'));
    }

    public function create()
    {
        return view('admin/user/add');
    }

    public function store()
    {
        $this->validate(request(), [
            'name' => 'required|min:2',
            'password' => 'required|min:5',
            'avatar' => 'required',
        ]);
        $name = request('name');
        $password = bcrypt(request('password'));
        $avatar = request('avatar');
        AdminUser::create(compact('name', 'password', 'avatar'));
        return redirect('/admin/users');
    }

    public function role(AdminUser $user)
    {
        $roles = AdminRole::all();
        $myRole = $user->roles;
        return view('admin.user.role', compact('roles', 'myRole', 'user'));
    }

    public function storeRole(AdminUser $user)
    {
        $this->validate(request(),[
            'roles' => 'required|array',
        ]);

        $roles = AdminRole::findMany(request('roles'));
        $myRole = $user->roles;

        //要增加的角色
        $addRoles = $roles->diff($myRole);
        foreach ($addRoles as $role) {
            $user->assignRole($role);
        }

        //要删除的角色
        $deleteRoles = $myRole->diff($roles);
        foreach ($deleteRoles as $role) {
            $user->deleteRole($role);
        }

        return redirect('/admin/users');
    }
}

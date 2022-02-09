<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Faker\Generator;
use Spatie\Permission\Models\Role;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    

    public function userRoleControl()
    {
        $users=User::where('estado',1)->get();
        return view('user.admin.table')->with('users',$users);
    }

    public function userRoleEdit()
    {
        return view('user.admin.control')->with('users',User::where('estado',1)->get())
                                        ->with('roles',Role::get('name'));
    }

    public function userRoleSave(Request $req)
    {
        $roles = $req->roles;
        $users=User::all();

        foreach($users as $user) { 

            if (array_key_exists($user->email,$roles)) {
                $user->syncRoles($roles[$user->email]);
            }else{
                $user->syncRoles([]);
            }
        }
        return redirect(route('user.role.table'))->with('success','Cambios Hechos con Exito');
    }


}

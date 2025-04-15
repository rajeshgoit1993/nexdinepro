<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use Validator;
use App\Helpers\CustomHelpers;

class RoleController extends Controller
{
   public function index()
    {
        $all_roles = Role::all();
        //dd($all_roles);
        return view('admin.roles.index',['roles'=>$all_roles]);
    }
    public function create()
    {
         return view('admin.roles.create');
    }
     public function store(Request $request)
    {
        $this->validate($request, [
            'role_name' => 'required',
            'role_slug' => 'required|unique:roles,slug',               
        ]);
         $role = new Role;
        $role->name = $request->input('role_name');
        $role->slug = $request->input('role_slug');
         if($role->save())
         {
             return redirect()->route('role')->with('success',"Role has been added!");
         
        }
    }
     public function edit($id)
    {
     
        $id=CustomHelpers::custom_decrypt($id);

        $role = Role::findOrFail($id);
     //   dd($role);

        return view('admin.roles.edit',['role'=>$role]);
    }
    public function updateRole(Request $request)
    {   
      $id=CustomHelpers::custom_decrypt($request->input('id'));
        $role = Role::findOrFail($id);
        $user_id=$id;
        $this->validate($request, [
            'role_name' => 'required',
            'role_slug' => "required|unique:roles,slug,$user_id",               
        ]);
        $role->name = $request->input('role_name');
        $role->slug = $request->input('role_slug');
       if($role->save())
         {
             return redirect()->route('role')->with('success',"Role has been Updated!");
         
        }
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use App\Models\FanchiseRegistration;
use App\Models\FanchiseRegistrationStep;
use App\Models\RegistrationActivityStatus;
use App\Notifications\UserWelcomeNotification;
use Illuminate\Support\Carbon;
use App\Models\PageAccess;
use App\Models\Role;
use App\Models\User;
use App\Helpers\CustomHelpers;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use Validator;
use Sentinel;
use DB;
use Activation;
use Carbon\CarbonPeriod;
use App\Models\BirthdayNotification;
use Hash;
use Redirect;

class AdminController extends Controller
{
    //
    public function first_password_create()
    {
        $sentinel_id=Sentinel::getUser()->id;
          $password_format="123456";
          $user=User::find(Sentinel::getUser()->id);
            if(Hash::check($password_format , $user['password'])):
       return view('admin.createpassword');
        else:
      return Redirect::back();
        endif;
    }
    public function first_password_store(Request $request)
    {
        $request->validate([
         
           
           'password' => 'required',
           'confirm_password' => 'required|same:password'
       ]);

      $user=User::find(Sentinel::getUser()->id);

      $sentinel_id=Sentinel::getUser()->id;
      $user_employee_id=CustomHelpers::get_user_data($sentinel_id,'EMPLID'); 
      $password_format="123456";

      if($request->password==$password_format):

 return redirect()->back()->with("success","Old Password Not Accepted");
    

     elseif($request->password==$request->confirm_password):
         $user->password=bcrypt($request->password);
         $user->save();

         return redirect('/')->with("success","Password Updated Successfully");
       else:
         return redirect()->back()->with("success","Password not matched");
      endif;
    }
    public function dashboard()
    {

      

        //
        if(Sentinel::getUser()->inRole('superadmin')):
         
  
        return view('admin.dashboard.index');

      elseif(Sentinel::getUser()->inRole('store')):
        $data=User::where([['status','=',1],['registration_level','=',4]])
            ->where('id','=',Sentinel::getUser()->id)->get();
        return view('admin.dashboard.index_stores',compact('data'));
     elseif(Sentinel::getUser()->inRole('vendor')):
       $data=User::where([['status','=',1],['registration_level','=',5]])
            ->where('id','=',Sentinel::getUser()->id)->get();
       return view('admin.dashboard.index_stores',compact('data'));
      elseif(Sentinel::getUser()->inRole('factory')):
       $data=User::where([['status','=',1],['registration_level','=',6]])
            ->where('id','=',Sentinel::getUser()->id)->get();
       return view('admin.dashboard.index_stores',compact('data'));
      elseif(Sentinel::getUser()->inRole('masterfanchise') || Sentinel::getUser()->inRole('fanchise')):
     $data=[];
       return view('admin.dashboard.index_fanchise',compact('data'));

      else:
      $id=Sentinel::getUser()->id;
      $role=DB::table('role_users')->where('user_id','=',$id)->first();
      $role_id=$role->role_id;
      $page_acess=PageAccess::where('role_id','=',$role_id)->first();
      if($page_acess!=''):
          
            



          if($page_acess->new_registration==1):

          $all_roles = Role::whereIn('slug',['fanchise','masterfanchise'])->get();
          $states=State::all();
    // return redirect('New-Registration');
  return view('admin.dashboard.index_new_registration_allowed');

          else:

           $role_wise_array=['prelaunch_action'=>$page_acess->prelaunch_date,
                        'fanchise_status'=>$page_acess->fanchise_data,
                        'architect_status'=>$page_acess->architect,
                        'social_media_status'=>$page_acess->social,
                        'procurement_status'=>$page_acess->procurement,
                        'operations_status'=>$page_acess->operations,
                        'accounts_status'=>$page_acess->accounts,
                        ];
        

        foreach($role_wise_array as $row=>$col):
           if($col==0):
$new_query[]=[$row,'=',$col];
           endif;
        endforeach;    
          

            $query = DB::table('fanchise_registrations')
               ->join('users','fanchise_registrations.fanchise_id' , '=', 'users.id')
            ->where(function ($query) use ($role_wise_array) {
        foreach ($role_wise_array as $row=>$col)
        {
            // you can use orWhere the first time, doesn't need to be ->where
               if($col==1 && $row=='prelaunch_action'):
             $query->orWhere([[$row,'=',0],['status','=',5]]);
               elseif($col==1 && ($row=='fanchise_status' || $row=='architect_status' || $row=='social_media_status' || $row=='procurement_status' || $row=='operations_status' || $row=='accounts_status')):
                $query->orWhere([[$row,'=',0],['status','=',6]]);
             endif;
           }
         })
           ->get();
           $data=$query;
           
       
            
        return view('admin.dashboard.index_new_work',compact('data'));
          endif;
      else:
          
return view('admin.dashboard.index_blank');

      endif;
    

       endif;
       
    }
}

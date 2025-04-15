<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sentinel;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use DB;
use App\Models\User;
use Activation;
use App\Helpers\CustomHelpers;
use App\Models\BirthdayNotification;
use App\Models\UserLogin;
use Hash;
use Validator;  
use Session;
use Illuminate\Support\Facades\Http;
class LoginController extends Controller
{
    
    public function home()
    {
        return view('landing.index');
    }
    public function about()
    {
        return view('landing.about');
    }
    public function pos_front()
    {
        return view('landing.pos');
    }
    public function qsr()
    {
        return view('landing.qsr');
    }
    public function mms()
    {
        return view('landing.mms');
    }
    public function contact()
    {
        return view('landing.contact');
    }

    public function login_admin()
   {
   if(Sentinel::check())
        {
        return redirect()->route('admin_dashboard');
        }
        else
        {
       return view("authentication.login");     
        }
    

   }
    public function login_post(Request $request)
   {
    $user_id=$request->email;
    if($user_id=='admin@mail.com'):
    $data_activations=DB::table('activations')
                      ->where('user_id','=',1)
                      ->first();
    
    if($data_activations==''):
   
    $sentinal_user=Sentinel::findById(1);     
         $activation = Activation::create($sentinal_user);
         Activation::complete($sentinal_user, $activation->code);
            
     endif;    
     endif; 
   $error=array();
     try {

            if (Sentinel::authenticate($request->all()))
                {
     

                     Session::put('last_active_time', time());
                     //
                    $user_login_data=new UserLogin;
                    $user_login_data->system_ip=CustomHelpers::get_ip();
                    $user_login_data->user_id=Sentinel::getUser()->id;
                    $user_login_data->login_date=date('Y-m-d');
                    $user_login_data->login_time=date("H:i:s");
                    $user_login_data->login_date_time=date("Y-m-d H:i:s");
                    $user_login_data->login_latitude=$request->latitude;
                    $user_login_data->login_longitude=$request->longitude;
                    $user_login_data->login_accuracy=$request->accuracy;
                    $login_latitude=$request->latitude;
                    $login_longitude=$request->longitude;

                    
                    if(Sentinel::getUser()->parent_id==1)
                    {
                    $user_data_extra=DB::table('user_extra_details')->where('store_id',Sentinel::getUser()->id)->first();   
                    if($user_data_extra!='')
                    {
                    $office_data=DB::table('office_addresses')->where('id',$user_data_extra->office_location_id)->first();  
                    if($office_data!='')
                    {
                     
                    $office_latitude=$office_data->latitude;
                    $office_longitude=$office_data->longitude;
                    $user_login_data->office_latitude=$office_latitude;
                    $user_login_data->office_longitude=$office_longitude;
                    $user_login_data->office_location=$office_data->location;

                  //    $distance_api= 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$request->latitude.','.$request->longitude.'&destinations='.$office_latitude.','.$office_longitude.'&units=imperial&key=AIzaSyB5sJdNFoynsNtaXo370mxNsM19_JzorYk';
                  // $distance_response = Http::get($distance_api);
                  // $distance_response = $distance_response->json(); 
                  // $diff=$distance_response['rows'][0]['elements'][0]['distance']['value'];

                  // $user_login_data->login_distance_office=$diff;

                    }
                   $shift_data=DB::table('h_r_m_s_shifts')->where('id',$user_data_extra->shift_id)->first();  
                  if($office_data!='')
                    {
               $user_login_data->shift_id=$shift_data->id;
               $user_login_data->assign_login_time=$shift_data->login_time;
               $user_login_data->assign_logout_time=$shift_data->logout_time;
               $user_login_data->login_variance=$shift_data->login_variance;
               $user_login_data->lunch_start_time=$shift_data->lunch_start_time;
               $user_login_data->lunch_end_time=$shift_data->lunch_end_time;
                    }

                    } 



                   //  $url='https://maps.googleapis.com/maps/api/geocode/json?latlng='.$request->latitude.','.$request->longitude.'&key=AIzaSyB5sJdNFoynsNtaXo370mxNsM19_JzorYk';
                   
                   // $response = Http::get($url);
                   // $response = $response->json();
                   
                   // if($response['status']=='OK')
                   // {

                   // $user_login_data->login_location=$response['results']['0']['formatted_address'];
                  

                   // } 

                    }
       
      
                   
                    $user_login_data->save();
                    Session::put('login_time_id', $user_login_data->id);
                     //
                    $user=User::find(Sentinel::getUser()->id);
                    $user->last_login_systemip=CustomHelpers::get_ip();
                    $user->save();
                    
                    $today_check=BirthdayNotification::where([['user_id','=',Sentinel::getUser()->id],['notification','=',0],['dob','=',date('Y-m-d')]])->first();
                     if($today_check!=''):
                         $today_check->notification=1;
                           $today_check->save();
                 return view('admin.dashboard.birthdaycelebrations');
                     else:
             return redirect()->route('admin_dashboard');
                     endif;
                    
                    
                    
              //       if(Sentinel::getUser()->inRole('superadmin'))
              //   {
                   
                  
              //   }
           
              //   else
              //   {
              //       $user = Sentinel::getUser();
        
              // Sentinel::logout($user, true);
              //  $error['error']="Choose Correct Section And Try Again!!!";
              // return redirect('/')->with($error);
              //   }
                    
                }else{
                    $error['error'] ="Username or Password incorrect.";
                }
            } catch (NotActivatedException $e) {
                $error['error'] = 'Account is not activated!';
            } catch (ThrottlingException $e) {
                $delay = $e->getDelay();
                $error['error'] = "Your account is blocked for {$delay} second(s).";
            }
            return redirect()->back()->with($error);
   }
   public function logout(Request $request)
   {
    if(Session::has('login_time_id'))
         {
 $user_login_data=UserLogin::find(Session::get('login_time_id'));
 if($user_login_data!='')
 {
  $user_login_data->logout_time=date("H:i:s");
 $user_login_data->logout_date_time=date("Y-m-d H:i:s");
 $user_login_data->logout_type=1;

 $user_login_data->logout_latitude=$request->latitude;
 $user_login_data->logout_longitude=$request->longitude;
 $user_login_data->logout_accuracy=$request->accuracy;

                   
if(Sentinel::getUser()->parent_id==1)
                    {
          
                   
   // $user_data_extra=DB::table('user_extra_details')->where('store_id',Sentinel::getUser()->id)->first();   
   //                  if($user_data_extra!='')
   //                  {
   //                  $office_data=DB::table('office_addresses')->where('id',$user_data_extra->office_location_id)->first();  
   //                  if($office_data!='')
   //                  {
   //                    $office_latitude=$office_data->latitude;
   //                    $office_longitude=$office_data->longitude;
                     
   //                   $distance_api= 'https://maps.googleapis.com/maps/api/distancematrix/json?origins='.$request->latitude.','.$request->longitude.'&destinations='.$office_latitude.','.$office_longitude.'&units=imperial&key=AIzaSyB5sJdNFoynsNtaXo370mxNsM19_JzorYk';
   //                $distance_response = Http::get($distance_api);
   //                $distance_response = $distance_response->json(); 
   //                $diff=$distance_response['rows'][0]['elements'][0]['distance']['value'];

   //               $user_login_data->logout_distance_office=$diff;

   //                  }
   //                  } 


                  

                  
                    }




 $user_login_data->save();   
 }

         }
    $user=Sentinel::getUser();
    Sentinel::logout($user,true);
    return redirect("/");
   }
    public function change_password()
   {
   
    return view("authentication.change_password");
   }
   public function admin_psw_save(Request $request)
    {
        $request->validate([
         
           'current' => 'required',
           'new' => 'required',
           'confirm' => 'required|same:new'
         ]);

        $user=User::find(Sentinel::getUser()->id);
        if(Hash::check($request->current , $user['password']) && $request->new==$request->confirm):

         $user->password=bcrypt($request->new);
         $user->save();

         return redirect()->route('change_password')->with("success","Password Updated Successfully");
       else:
         return redirect()->back()->with("success","Password not matched");
        endif;
    }
    public function change_password_outlet(Request $request)
    {
        
        $validator = Validator::make($request->all(), 
              [ 
          'new' => 'required',
           'confirm' => 'required|same:new'
           
             ]); 
           if($validator->fails()) 
            {          
              $a='';
            $messages = $validator->messages();
             foreach ($messages->all(':message') as $message)
            {
                $a= $message;
            }
              
           echo $a;       
            } 
          else
          {
            $id=CustomHelpers::custom_decrypt($request->id); 
              $user=User::find($id);
       

         $user->password=bcrypt($request->new);
         $user->save();

        echo 'success';
    
          }
      
    }
}

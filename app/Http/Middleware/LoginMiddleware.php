<?php

namespace App\Http\Middleware;
use App\Helpers\CustomHelpers;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Sentinel;
use Session;
use URL;
use Hash;
use DB;
use App\Models\UserLogin;
use DateTime;
use App\Models\UserAttendencePicture;
use App\Models\Holiday;
use App\Models\FanchiseRegistration;
use App\Models\FranchiseCreditHistory;

class LoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Sentinel::check())
        {

          //auto logout

         if(Session::has('last_active_time'))
         {

          if((time()-Session::get('last_active_time'))>900)
          {
          $user=Sentinel::getUser();
          if($user->parent_id==1)
          {

             if(Session::has('login_time_id'))
         {
       
 $user_login_data=UserLogin::find(Session::get('login_time_id'));
 if($user_login_data!='')
 {
  $user_login_data->logout_time=date("H:i:s",Session::get('last_active_time'));
 $user_login_data->logout_date_time=date("Y-m-d H:i:s",Session::get('last_active_time'));
 $user_login_data->logout_type=2;
 $user_login_data->save();   
 }

         }

          Sentinel::logout($user,true);
          return redirect("/");
          }
          
          }
         }

          Session::put('last_active_time', time());
          //
          $sentinel_id=Sentinel::getUser()->id;
          $password_format="123456";
          $user=User::find(Sentinel::getUser()->id);
            if(Hash::check($password_format , $user['password'])):

        return redirect('/First-Reset-Password');

        else:
           $loged_user=Sentinel::getUser();
           $parent_id=$loged_user->parent_id;
if($parent_id!=1)
{
  $fanchise_detail=DB::table('users')
           ->join('fanchise_registrations','fanchise_registrations.fanchise_id','=','users.id')
          
           ->where('users.id','=',(int)$parent_id)
         
           ->select('users.*','fanchise_registrations.expire_date')
           
           ->first();
        
if($fanchise_detail->active_status==1)
{
 $expire_date=$fanchise_detail->expire_date;
$today=date('Y-m-d');

if($expire_date<$today)
{
  $available_fund=CustomHelpers::get_franchise_previous_credit_bal($fanchise_detail->id);
 $franchise_data=FanchiseRegistration::where('fanchise_id',$fanchise_detail->id)->first();        
    $subscription_type=$franchise_data->subscription_type;
    $minfund=$franchise_data->subscription_value;
    $subscription_value=$available_fund;
  

   if($subscription_value>=$minfund)
    {
    $debit=0;
  

   $today=date('Y-m-d');
  
    if($subscription_type==1)
    {
 $expire_date=date('Y-m-d', strtotime($today. ' + 30 days')); 
    }
    else
    {
 $expire_date=date('Y-m-d', strtotime($today. ' + 365 days')); 
    }
     $debit=$minfund;


$franchise_data->expire_date=$expire_date;
$franchise_data->save();

$previous_Bal=$available_fund;
$remaining_bal=(int)($previous_Bal-$debit);
 $credit_history=new FranchiseCreditHistory;
 $credit_history->franchise_id=$fanchise_detail->id;
 $credit_history->credit=0;
 $credit_history->debit=$debit;
 $credit_history->remaining_bal=$remaining_bal;
 $credit_history->action_user_id=Sentinel::getUser()->id;
 $credit_history->remarks='Auto Adjust Amount';
 $credit_history->save();

echo 'success';

    }

else
{
 $data=['error'=>'Account Expired'];

  return response()->view('outlet.error',compact('data')); 
}

  
}

}

else

{
 $data=['error'=>'Account Inactive! Kindly contact to admin'];
      return response()->view('outlet.error',compact('data'));
}




}
           
//            if($parent_id==1)
//           {

//            $user_data_extra=DB::table('user_extra_details')->where('store_id',Sentinel::getUser()->id)->first();
//             if($user_data_extra!='')
//             {
//            $shift_data=DB::table('h_r_m_s_shifts')->where('id',$user_data_extra->shift_id)->first();  
//            $now_time=strtotime(date("Y-m-d H:i:s"));
           
// $minutesToAdd = $shift_data->login_variance;

// $mrg_login_start= strtotime(date('Y-m-d '.$shift_data->login_time). '- '.$minutesToAdd.' minute');
// $mrg_login_end= strtotime(date('Y-m-d '.$shift_data->login_time). '+ '.$minutesToAdd.' minute');
// $lunch_login_start= strtotime(date('Y-m-d '.$shift_data->lunch_end_time). '- '.$minutesToAdd.' minute');
// $lunch_login_end= strtotime(date('Y-m-d '.$shift_data->lunch_end_time). '+ '.$minutesToAdd.' minute');

// $evening_login_start= strtotime(date('Y-m-d '.$shift_data->logout_time). '- '.$minutesToAdd.' minute');
// $evening_login_end= strtotime(date('Y-m-d '.$shift_data->logout_time). '+ '.$minutesToAdd.' minute');
// $user_attendence_picture_data=UserAttendencePicture::where('user_id',Sentinel::getUser()->id)->whereDate('login_date',date("Y-m-d"))->first();

// $check_early_holidays=Holiday::whereIn('holiday_type',[4,5])->whereDate('date',date("Y-m-d"))->first();
// if($check_early_holidays!='' && $check_early_holidays->holiday_type==4)
// {
//   $log='17:00:00';
// $evening_login_start= strtotime(date('Y-m-d '.$log). '- '.$minutesToAdd.' minute');
// $evening_login_end= strtotime(date('Y-m-d '.$log). '+ '.$minutesToAdd.' minute');
// }
// elseif($check_early_holidays!='' && $check_early_holidays->holiday_type==5)
// {
//   $log='11:30:00';
// $mrg_login_start= strtotime(date('Y-m-d '.$log). '- '.$minutesToAdd.' minute');
// $mrg_login_end= strtotime(date('Y-m-d '.$log). '+ '.$minutesToAdd.' minute');
// }



// if($user_attendence_picture_data=='')
// {
// $user_attendence_picture_data=new UserAttendencePicture;
// $user_attendence_picture_data->user_id=Sentinel::getUser()->id;
// $user_attendence_picture_data->login_date=date("Y-m-d"); 
// $user_attendence_picture_data->save();
// }
// if($now_time>$mrg_login_start && $now_time<$mrg_login_end && $user_attendence_picture_data->mrg_time=='')
// {
// return redirect('/Attendence-Picture');
// }
// elseif($now_time>$lunch_login_start && $now_time<$lunch_login_end && $user_attendence_picture_data->lunch_time=='')
// {
// return redirect('/Attendence-Picture');
// }
// elseif($now_time>$evening_login_start && $now_time<$evening_login_end && $user_attendence_picture_data->evening_time=='')
// {
 
//  return redirect('/Attendence-Picture'); 
// }


//             }
//           }



            $user_id=Sentinel::getUser()->id;
            $url=\Request::segment(1);
            $role=DB::table('role_users')->where('user_id','=',$user_id)->first();
            $role_id=$role->role_id;

            if($role_id!=1 && $role_id!=2 && $role_id!=12 && $role_id!=17 && $role_id!=18 && $role_id!=19 && $role_id!=20 && $role_id!=21 && $role_id!=27)
            {

              if($url=='foodMenuSales' || $url=='ConsumptionReport' || $url=='POS-Reports' || $url=='DSR-RSC-MTD' || $url=='Food-Menu-Category' || $url=='Food-Menu' || $url=='Outlet-Menu-Price')
              {
               if(CustomHelpers::get_page_access_data($user_id,'billing')==1)
               {
                return $next($request);   
               }
               else
               {
                 $user=Sentinel::getUser();
                 Sentinel::logout($user,true);
                 return redirect("/");
               }
              }
              elseif($url=='All-Products-List' || $url=='Firsttime-Stock-List' || $url=='Supply-Item-List')
              {
               if(CustomHelpers::get_page_access_data($user_id,'master_product')==1)
               {
                return $next($request);   
               }
               else
               {
                 $user=Sentinel::getUser();
                 Sentinel::logout($user,true);
                 return redirect("/");
               }
              }
              elseif($url=='Brand-List' || $url=='GST-List' || $url=='Unit-List' || $url=='TransportCharge-List' || $url=='Manage-City' || $url=='Warehouse-Setting')
              {
               if(CustomHelpers::get_page_access_data($user_id,'master_product')==1)
               {
                return $next($request);   
               }
               else
               {
                 $user=Sentinel::getUser();
                 Sentinel::logout($user,true);
                 return redirect("/");
               }
              }
              else
              {
               return $next($request);   
              }
            }
            else
            {
              return $next($request);  
            }
            


        endif;
            
            
          

        }
        else
        {
    Session::put('url', URL::current());
       
     return redirect('/login');
        }
    }
}

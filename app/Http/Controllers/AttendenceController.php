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
use App\Models\Weekoff;
use App\Models\Holiday;
use App\Models\UserAttendencePicture;
use App\Models\ChooseOptionalHolidays;
use Hash;
use Validator;  
use Session;
use Redirect;
use Carbon\Carbon;  

class AttendenceController extends Controller
{
    public function index()
    {
   
 $years = UserLogin::select('id', 'login_date')
         ->get()
         ->groupBy(function($date) {
        return Carbon::parse($date->login_date)->format('Y'); 
       
        });
  $months = UserLogin::select('id', 'login_date')
         ->get()
         ->groupBy(function($date) {
        return Carbon::parse($date->login_date)->format('m'); 
       
        });

   $month = date('m');
   $year = date('y');
   $full_year=date('Y');
   $num_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $full_year);
   $user_login_data = DB::table('user_logins')
            ->join('users','users.id', '=','user_logins.user_id')
            
            ->where([['users.parent_id',1],['users.registration_level',3]])
            ->whereMonth('user_logins.created_at', '=', $month)
            ->whereYear('user_logins.created_at', '=', $full_year)
            ->select('user_logins.*','users.name')
            ->get()->groupBy('user_id');
   
    $weekoffs=Weekoff::all();
    $holidays=Holiday::where('year',date('Y'));
    
   
  
    return view('admin.hrms.attendence.index', compact('user_login_data','num_of_days','month','weekoffs','holidays','full_year','years','months'));

    }
    public function get_filter_attendence(Request $request)
    {
    $year=$request->year;
    $month=$request->month; 

   $full_year=$year;
   $num_of_days = cal_days_in_month(CAL_GREGORIAN, $month, $full_year);
   $user_login_data = DB::table('user_logins')
            ->join('users','users.id', '=','user_logins.user_id')
            
            ->where([['users.parent_id',1],['users.registration_level',3]])
            ->whereMonth('user_logins.created_at', '=', $month)
            ->whereYear('user_logins.created_at', '=', $full_year)
            ->select('user_logins.*','users.name')
            ->get()->groupBy('user_id');
   
    $weekoffs=Weekoff::all();
    $holidays=Holiday::where('year',date('Y'));
  $options = view('admin.hrms.attendence.get_filter_attendence', compact('user_login_data','num_of_days','month','weekoffs','holidays','full_year'))->render();
        echo $options;

    }
    public function store_admin_attendence(Request $request)
    {
    $user_id=$request->user_id;
    $date=$request->date;
    
    $user_attendence_picture_data=UserAttendencePicture::where('user_id',$user_id)->whereDate('login_date',$date)->first();
    if($user_attendence_picture_data=='')
    {
   $user_attendence_picture_data=new UserAttendencePicture;
   $user_attendence_picture_data->user_id=$user_id;
   $user_attendence_picture_data->login_date=$date; 
  
    }
    $user_attendence_picture_data->status=$request->status;
    $user_attendence_picture_data->save();
    echo 'success';
    }
    public function get_attendence_details(Request $request)
    {
    $user_id=$request->user_id;
    $date=$request->date;
    $login_datas=DB::table('user_logins')->where('user_id',$user_id)->whereDate('login_date','=',$date)->get();
    $user_attendence_picture_data=UserAttendencePicture::where('user_id',$user_id)->whereDate('login_date',$date)->first();

    $options = view("admin.hrms.attendence.get_attendence_details",compact('login_datas','date','user_id','user_attendence_picture_data'))->render();
        echo $options;

    }
    public function attendence_picture()
    {
        if(Sentinel::check())
        {

        }
        else
        {
            return redirect('/');
        }
        $loged_user=Sentinel::getUser();

        $parent_id=$loged_user->parent_id;
           if($parent_id==1)
          {

           $user_data_extra=DB::table('user_extra_details')->where('store_id',Sentinel::getUser()->id)->first();
            if($user_data_extra!='')
            {
           $shift_data=DB::table('h_r_m_s_shifts')->where('id',$user_data_extra->shift_id)->first();  
           $now_time=strtotime(date("Y-m-d H:i:s"));
           
$minutesToAdd = $shift_data->login_variance;

$mrg_login_start= strtotime(date('Y-m-d '.$shift_data->login_time). '- '.$minutesToAdd.' minute');
$mrg_login_end= strtotime(date('Y-m-d '.$shift_data->login_time). '+ '.$minutesToAdd.' minute');
$lunch_login_start= strtotime(date('Y-m-d '.$shift_data->lunch_end_time). '- '.$minutesToAdd.' minute');
$lunch_login_end= strtotime(date('Y-m-d '.$shift_data->lunch_end_time). '+ '.$minutesToAdd.' minute');

$evening_login_start= strtotime(date('Y-m-d '.$shift_data->logout_time). '- '.$minutesToAdd.' minute');
$evening_login_end= strtotime(date('Y-m-d '.$shift_data->logout_time). '+ '.$minutesToAdd.' minute');
$user_attendence_picture_data=UserAttendencePicture::where('user_id',Sentinel::getUser()->id)->whereDate('login_date',date("Y-m-d"))->first();

$check_early_holidays=Holiday::whereIn('holiday_type',[4,5])->whereDate('date',date("Y-m-d"))->first();

if($check_early_holidays!='' && $check_early_holidays->holiday_type==4)
{
$log='17:00:00';
$evening_login_start= strtotime(date('Y-m-d '.$log). '- '.$minutesToAdd.' minute');
$evening_login_end= strtotime(date('Y-m-d '.$log). '+ '.$minutesToAdd.' minute');
}
elseif($check_early_holidays!='' && $check_early_holidays->holiday_type==5)
{
  $log='11:30:00';
$mrg_login_start= strtotime(date('Y-m-d '.$log). '- '.$minutesToAdd.' minute');
$mrg_login_end= strtotime(date('Y-m-d '.$log). '+ '.$minutesToAdd.' minute');
}


if($user_attendence_picture_data=='')
{
$user_attendence_picture_data=new UserAttendencePicture;
$user_attendence_picture_data->user_id=Sentinel::getUser()->id;
$user_attendence_picture_data->login_date=date("Y-m-d"); 
$user_attendence_picture_data->save();
}
if($now_time>$mrg_login_start && $now_time<$mrg_login_end && $user_attendence_picture_data->mrg_time=='')
{
$header='Good Morning !!!';
return view('admin.attendence_picture',compact('header'));
}
elseif($now_time>$lunch_login_start && $now_time<$lunch_login_end && $user_attendence_picture_data->lunch_time=='')
{
$header='Good Afternoon !!!';
return view('admin.attendence_picture',compact('header'));
}
elseif($now_time>$evening_login_start && $now_time<$evening_login_end && $user_attendence_picture_data->evening_time=='')
{
$header='Good Evening !!!';
return view('admin.attendence_picture',compact('header'));
}
else
{
 return redirect('/');    
}


            }

          }
          else
          {
            return redirect('/'); 
          }


         
    }
    public function save_attendence_picture(Request $request)
    {
       if(Sentinel::check())
        {

        }
        else
        {
            return redirect('/');
        }
     
     if($request->image!=''):
     $img =$request->image;
     $name=time().'.'.explode('/',explode(':',substr($request->image, 0, strpos($request->image,';')))[1])[1];
     \Image::make($request->image)->save(public_path('uploads/attendence_picture/').$name);

     //
$loged_user=Sentinel::getUser();

        $parent_id=$loged_user->parent_id;
           if($parent_id==1)
          {

           $user_data_extra=DB::table('user_extra_details')->where('store_id',Sentinel::getUser()->id)->first();
            if($user_data_extra!='')
            {
           $shift_data=DB::table('h_r_m_s_shifts')->where('id',$user_data_extra->shift_id)->first();  
           $now_time=strtotime(date("Y-m-d H:i:s"));
           
$minutesToAdd = $shift_data->login_variance;

$mrg_login_start= strtotime(date('Y-m-d '.$shift_data->login_time). '- '.$minutesToAdd.' minute');
$mrg_login_end= strtotime(date('Y-m-d '.$shift_data->login_time). '+ '.$minutesToAdd.' minute');
$lunch_login_start= strtotime(date('Y-m-d '.$shift_data->lunch_end_time). '- '.$minutesToAdd.' minute');
$lunch_login_end= strtotime(date('Y-m-d '.$shift_data->lunch_end_time). '+ '.$minutesToAdd.' minute');

$evening_login_start= strtotime(date('Y-m-d '.$shift_data->logout_time). '- '.$minutesToAdd.' minute');
$evening_login_end= strtotime(date('Y-m-d '.$shift_data->logout_time). '+ '.$minutesToAdd.' minute');
$check_early_holidays=Holiday::whereIn('holiday_type',[4,5])->whereDate('date',date("Y-m-d"))->first();



if($check_early_holidays!='' && $check_early_holidays->holiday_type==4)
{
  $log='17:00:00';
$evening_login_start= strtotime(date('Y-m-d '.$log). '- '.$minutesToAdd.' minute');
$evening_login_end= strtotime(date('Y-m-d '.$log). '+ '.$minutesToAdd.' minute');
}
elseif($check_early_holidays!='' && $check_early_holidays->holiday_type==5)
{
  $log='11:30:00';
$mrg_login_start= strtotime(date('Y-m-d '.$log). '- '.$minutesToAdd.' minute');
$mrg_login_end= strtotime(date('Y-m-d '.$log). '+ '.$minutesToAdd.' minute');
}

$attendence_pic=UserAttendencePicture::where('user_id',Sentinel::getUser()->id)->whereDate('login_date',date("Y-m-d"))->first();
if($attendence_pic=='')
{
$attendence_pic=new UserAttendencePicture;
$attendence_pic->user_id=Sentinel::getUser()->id;
$attendence_pic->login_date=date("Y-m-d"); 

}

if($now_time>$mrg_login_start && $now_time<$mrg_login_end)
{
$attendence_pic->mrg_system_ip=CustomHelpers::get_ip();
$attendence_pic->mrg_photo=$name;
$attendence_pic->mrg_time=date("H:i:s");
}
elseif($now_time>$lunch_login_start && $now_time<$lunch_login_end)
{
$attendence_pic->lunch_system_ip=CustomHelpers::get_ip();
$attendence_pic->lunch_photo=$name;
$attendence_pic->lunch_time=date("H:i:s");
}
elseif($now_time>$evening_login_start && $now_time<$evening_login_end)
{

$attendence_pic->evening_system_ip=CustomHelpers::get_ip();
$attendence_pic->evening_photo=$name;
$attendence_pic->evening_time=date("H:i:s");
}
$attendence_pic->save();


            }
          }

 $optional_holidays=ChooseOptionalHolidays::where([['user_id',Sentinel::getUser()->id],['year',date('Y')]])->first();
 if($optional_holidays=='')
 {

   $optional_holidays=new ChooseOptionalHolidays;
   $optional_holidays->user_id=Sentinel::getUser()->id;
   $optional_holidays->holiday_id=$request->holiday_id;
   $optional_holidays->year=Date('Y');
   $optional_holidays->save();
 }

 return redirect('/');

     //


     else:
        return Redirect::back()->with('error','Kindly Click Take Photo');

     endif;
    
    
    
  
   
    }
}

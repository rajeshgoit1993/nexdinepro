<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Reminder;
use Mail;
use Sentinel;
use App\Notifications\PasswordresetNotification;
use Notification;

class UserForgetPasswordController extends Controller
{

   public function password_forget()
    {
         return view('authentication.forgetpassword');
      
    }
    public function user_password_forget(Request $request)
    {

        $user=User::where('email','=',$request->email)->first();
       if(empty($user))
      {
        $error['error'] = "Email Id Not Exit";
        return redirect()->back()->with($error);
      }
        $sentinal_user=Sentinel::findById($user->id);
        if(empty($sentinal_user))
        {
            $error['error'] = "Email Id Not Exit";
            return redirect()->back()->with($error);
        }
 
        
         try{
        $sentinal_user->notify(new PasswordresetNotification());

        return redirect('/')->with(['success'=>'Reset Code was sent to your email']);
     }
    catch(\Exception $e){ // Using a generic exception
    return redirect('/')->with(['error'=>'Some issue contact admin']);
    }
      

    }

    public function reset_password($email, $code)
    {
      $user=User::where('email','=',$email)->first();
      
      if(empty($user))
      {
        abort(404);
      }
       $sentinal_user=Sentinel::findById($user->id);

      if($reminder=Reminder::exists($sentinal_user))
      {
   
        if($code == true)
        {
         
            return view("authentication.passwordreset");
        }
        else
        {
             return redirect('/');
        }
      }
      else
      {
             return redirect('/');
      }
    }
  public function user_password_reset(Request $request,$email, $code)
    {
         $request->validate([
           'password' => 'required',
           'cpassword' => 'required|same:password',
          
     
          ]);
      
        $user=User::where('email','=',$email)->first();
      
      if(empty($user))
      {
        abort(404);
      }
      $sentinal_user=Sentinel::findById($user->id);
      if($reminder=Reminder::exists($sentinal_user))
      {
        if($code == true)
        {
            Reminder::complete($sentinal_user,$code,$request->password);
            return redirect('/')->with(["success"=>"Please Login With Your New Password "]);
        }
        else
        {
            return redirect('/')->with(["error"=>"Code Invalid"]);
        }
      }
      else
      {
             return redirect('/')->with(["error"=>"Error"]);
      }
    }
}

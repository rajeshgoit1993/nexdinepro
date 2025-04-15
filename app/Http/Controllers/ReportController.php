<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FanchiseRegistration;
use App\Models\FanchiseRegistrationStep;
use App\Models\RegistrationActivityStatus;
use App\Notifications\UserWelcomeNotification;

use App\Models\Role;
use App\Models\User;
use App\Helpers\CustomHelpers;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\PreLaunch;
use App\Models\PreLaunchDoc;
use Validator;
use Sentinel;
use DB;
use PDF;

class ReportController extends Controller
{
    //
    public function loi()
    {

     $id=Sentinel::getUser()->id;
         $fanchise_detail=User::where('id','=',$id)->first();
        $data=FanchiseRegistration::where('fanchise_id','=',$id)->first(); 
        $pdf = PDF::loadView('report.loi', compact('data','fanchise_detail'));
     
        return $pdf->download('LOI.pdf');
        // return view('report.loi', compact('data','fanchise_detail'));
    }
     public function adminloi($id)
    {

    $id=CustomHelpers::custom_decrypt($id);
         $fanchise_detail=User::where('id','=',$id)->first();
        $data=FanchiseRegistration::where('fanchise_id','=',$id)->first(); 
        $pdf = PDF::loadView('report.loi', compact('data','fanchise_detail'));
     
        return $pdf->download($fanchise_detail->name.'_LOI.pdf');
        // return view('report.loi', compact('data','fanchise_detail'));
    }
}

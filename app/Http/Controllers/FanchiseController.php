<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CentralSupplyChain;
use App\Models\CrockeryList;
use App\Models\LocalPurchaseList;
use App\Models\UtensilList;
use App\Models\User;
use App\Models\EquipmentList;
use App\Helpers\CustomHelpers;
use App\Models\FanchiseBookingAmount;
use App\Models\FanchiseDocuments;
use App\Models\FanchiseInitialChecklist;
use App\Models\FanchiseLaunch;
use App\Models\FanchisePreLunch;
use App\Models\FanchiseRegistrationStep;
use Validator;
use DataTables;
use Session;
use Sentinel;


class FanchiseController extends Controller
{

       public function fanchise_list()
    {
        return view('admin.fanchise.index');
    }
    public function fanchise_data(Request $request)
    {
         if ($request->ajax()) {
            $data = User::where('registration_level','=',1)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="'.url('Fanchise-Edit/'.$id).'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="'.url('Fanchise-Delete/'.$id).'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function add_fanchise()
    {
        $utensillists=UtensilList::all();
        $centralsupplychain=CentralSupplyChain::all();
        $crockerylist=CrockeryList::all();
        $localpurchaselist=LocalPurchaseList::all();
        $equipmentlists=EquipmentList::all();
        return view('admin.fanchise.create',compact('utensillists','centralsupplychain','crockerylist','localpurchaselist','equipmentlists'));
    }
    public function edit($id)
    {
     $id=CustomHelpers::custom_decrypt($id);
     Session::put('user_id',$id);
     $utensillists=UtensilList::all();
     $centralsupplychain=CentralSupplyChain::all();
     $crockerylist=CrockeryList::all();
     $localpurchaselist=LocalPurchaseList::all();
     $equipmentlists=EquipmentList::all();
        return view('admin.fanchise.create',compact('utensillists','centralsupplychain','crockerylist','localpurchaselist','equipmentlists'));
    }
    public function fanchise_register(Request $request)
    {
         $serial_id=$request->serial_id;
        if($serial_id==1):
         $validator = Validator::make($request->all(), 
              [ 
           'user_id'=>"required|unique:users",
           
          'password'=>'required',
           
             ]); 
           if($validator->fails()) 
            {          
           echo "The user id has already been taken.";            
            } 
            else
            {


        $userData['user_id']=$request->user_id;
        $userData['registration_level']=1;
        $userData['register_system_ip']=CustomHelpers::get_ip();
        $userData['password']=$request->password;
        $user=Sentinel::registerAndActivate($userData);
        $role=Sentinel::findRoleBySlug('fanchise');
        $role->users()->attach($user);  
        Session::put('user_id',$user->id);
        $registration_step=FanchiseRegistrationStep::where('user_id','=',$user->id)->first();
        if($registration_step==''):
          $registration_step=new FanchiseRegistrationStep; 
        endif;
        $registration_step->login_details=1;
        $registration_step->user_id=$user->id;
        $registration_step->system_ip=CustomHelpers::get_ip();
        $registration_step->save();
        echo "success";
         } 
        elseif($serial_id==2):
           $user_id=Session::get('user_id');
        $booking_data=FanchiseBookingAmount::where('user_id','=',$user_id)->first();
        if($booking_data==''):
        $booking_data=new FanchiseBookingAmount; 
        endif;
        $booking_data->booking_amount=$request->booking_amount;
        $booking_data->user_id=$user_id;
        $booking_data->gst=$request->gst;
        $booking_data->gst_percentage=$request->gst_percentage;
        $booking_data->gst_amount=$request->gst_amount;
        $booking_data->royality=$request->royality;
        $booking_data->royality_percentage=$request->royality_percentage;
        $booking_data->royality_amount=$request->royality_amount;
        $booking_data->total_booking_amount=$request->total_booking_amount;
        $booking_data->total_received_amount=$request->total_received_amount;
        $booking_data->total_pending_amount=$request->total_pending_amount;
        $booking_data->system_ip=CustomHelpers::get_ip();
        $booking_data->save();

        $registration_step=FanchiseRegistrationStep::where('user_id','=',$user_id)->first();
        if($registration_step==''):
          $registration_step=new FanchiseRegistrationStep; 
        endif;
        $registration_step->booking_amount=1;
        $registration_step->user_id=$user_id;
        $registration_step->system_ip=CustomHelpers::get_ip();
        $registration_step->save();
         echo "success";

        elseif($serial_id==3):
        $user_id=Session::get('user_id');
        $document_data=FanchiseDocuments::where('user_id','=',$user_id)->first();
        if($document_data==''):
        $document_data=new FanchiseDocuments; 
        endif;

        if($request->hasFile("loi")):
    $loi=$request->file("loi");
    $loi_name=rand(0, 99999).".".$loi->getClientOriginalExtension();
    $loi_path=public_path("/uploads/fanchise");
    $loi->move($loi_path,$loi_name);
    $document_data->loi=$loi_name;
        endif;
        if($request->hasFile("adhar_card")):
    $adhar_card=$request->file("adhar_card");
    $adhar_card_name=rand(0, 99999).".".$adhar_card->getClientOriginalExtension();
    $adhar_card_path=public_path("/uploads/fanchise");
    $adhar_card->move($adhar_card_path,$adhar_card_name);
    $document_data->adhar_card=$adhar_card_name;
        endif;
        if($request->hasFile("pan_card")):
    $pan_card=$request->file("pan_card");
    $pan_card_name=rand(0, 99999).".".$pan_card->getClientOriginalExtension();
    $pan_card_path=public_path("/uploads/fanchise");
    $pan_card->move($pan_card_path,$pan_card_name);
    $document_data->pan_card=$pan_card_name;
        endif;
        if($request->hasFile("gst_card")):
    $gst_card=$request->file("gst_card");
    $gst_card_name=rand(0, 99999).".".$gst_card->getClientOriginalExtension();
    $gst_card_path=public_path("/uploads/fanchise");
    $gst_card->move($gst_card_path,$gst_card_name);
    $document_data->gst_card=$gst_card_name;
        endif;
         $document_data->system_ip=CustomHelpers::get_ip();
         $document_data->user_id=$user_id;
        $document_data->save();
      $registration_step=FanchiseRegistrationStep::where('user_id','=',$user_id)->first();
        if($registration_step==''):
          $registration_step=new FanchiseRegistrationStep; 
        endif;
        $registration_step->document_uploads=1;
        $registration_step->user_id=$user_id;
        $registration_step->system_ip=CustomHelpers::get_ip();
        $registration_step->save();
         echo 'success';

        elseif($serial_id==4):
        
        $user_id=Session::get('user_id');
        $checklist_data=FanchiseInitialChecklist::where('user_id','=',$user_id)->first();
        if($checklist_data==''):
        $checklist_data=new FanchiseInitialChecklist; 
        endif;
        //1
        $utensillist_firststock=$request->utensillist_firststock;
        $utensillist_need=$request->utensillist_need;
        if($utensillist_need!=''):
        foreach($utensillist_need as $k=>$variable_name):
    $actual_utensillist[]=['utensillist_id'=>$k,'utensillist_stock'=>$utensillist_firststock[$k][0]];
       
        endforeach;
    else:
 $actual_utensillist[]=['utensillist_id'=>0,'utensillist_stock'=>0];
    endif;
        $utensil_list=serialize($actual_utensillist);
        $checklist_data->utensil_list=$utensil_list;
        //2
        $equipmentlist_firststock=$request->equipmentlist_firststock;
        $equipmentlist_need=$request->equipmentlist_need;
     if($equipmentlist_need!=''):
        foreach($equipmentlist_need as $k=>$variable_name):
    $actual_equipmentlist[]=['equipmentlist_id'=>$k,'equipmentlist_stock'=>$equipmentlist_firststock[$k][0]];
       
        endforeach;
         else:
 $actual_equipmentlist[]=['equipmentlist_id'=>0,'equipmentlist_stock'=>0];
    endif;
        $equipment_list=serialize($actual_equipmentlist);
        $checklist_data->equipment_list=$equipment_list;
        //3
        $crockerylist_firststock=$request->crockerylist_firststock;
        $crockerylist_need=$request->crockerylist_need;
     if($crockerylist_need!=''):
        foreach($crockerylist_need as $k=>$variable_name):
        $actual_crockerylist[]=['crockerylist_id'=>$k,'crockerylist_stock'=>$crockerylist_firststock[$k][0]];
       
        endforeach;
        else:
 $actual_crockerylist[]=['crockerylist_id'=>0,'crockerylist_stock'=>0];
    endif;
        $crockery_list=serialize($actual_crockerylist);
        $checklist_data->crockery_list=$crockery_list;
        //4
        $centralsupplychainlist_firststock=$request->centralsupplychain_firststock;
        $centralsupplychainlist_need=$request->centralsupplychainlist_need;
     if($centralsupplychainlist_need!=''):
        foreach($centralsupplychainlist_need as $k=>$variable_name):
    $actual_centralsupplychainlist[]=['centralsupplychainlist_id'=>$k,'centralsupplychainlist_stock'=>$centralsupplychainlist_firststock[$k][0]];
       
        endforeach;
        else:
 $actual_centralsupplychainlist[]=['centralsupplychainlist_id'=>0,'centralsupplychainlist_stock'=>0];
    endif;
        $central_supply_chain=serialize($actual_centralsupplychainlist);
        $checklist_data->central_supply_chain=$central_supply_chain;
        //5
        $localpurchaselist_firststock=$request->localpurchaselist_firststock;
        $localpurchaselist_need=$request->localpurchaselist_need;
     if($localpurchaselist_need!=''):
        foreach($localpurchaselist_need as $k=>$variable_name):
    $actual_localpurchaselist[]=['localpurchaselist_id'=>$k,'localpurchaselist_stock'=>$localpurchaselist_firststock[$k][0]];
       
        endforeach;
        else:
 $actual_localpurchaselist[]=['localpurchaselist_id'=>0,'localpurchaselist_stock'=>0];
    endif;
        $local_purchase_list=serialize($actual_localpurchaselist);
        $checklist_data->local_purchase_list=$local_purchase_list;
        $checklist_data->user_id=$user_id;
        $checklist_data->system_ip=CustomHelpers::get_ip();
        $checklist_data->save();
        $registration_step=FanchiseRegistrationStep::where('user_id','=',$user_id)->first();
        if($registration_step==''):
          $registration_step=new FanchiseRegistrationStep; 
        endif;
        $registration_step->initial_checklist=1;
        $registration_step->user_id=$user_id;
        $registration_step->system_ip=CustomHelpers::get_ip();
        $registration_step->save();
         echo "success";

        elseif($serial_id==5):

        $user_id=Session::get('user_id');
        $prelaunch_data=FanchisePreLunch::where('user_id','=',$user_id)->first();
        if($prelaunch_data==''):
        $prelaunch_data=new FanchisePreLunch; 
        endif;
        $prelaunch_data->registered_name_status=$request->registered_name_status;
        $prelaunch_data->firm_registered_name=$request->firm_registered_name;
        $prelaunch_data->shop_agreement_status=$request->shop_agreement_status;
        $prelaunch_data->shop_agreement_detail=$request->shop_agreement_detail;
        $prelaunch_data->outlet_address_status=$request->outlet_address_status;
        $prelaunch_data->outlet_address=$request->outlet_address;
        $prelaunch_data->mail_id_status=$request->mail_id_status;
        $prelaunch_data->mail_id_name=$request->mail_id_name;
        $prelaunch_data->outlet_mobile_status=$request->outlet_mobile_status;
        $prelaunch_data->outlet_mobile=$request->outlet_mobile;
        $prelaunch_data->gst_status=$request->gst_status;
        $prelaunch_data->gst_name=$request->gst_name;
        $prelaunch_data->fssai_status=$request->fssai_status;
        $prelaunch_data->electricity_load_status=$request->electricity_load_status;
        $prelaunch_data->current_bank_status=$request->current_bank_status;
        $prelaunch_data->current_bank_name=$request->current_bank_name;

        $prelaunch_data->official_mail_status=$request->official_mail_status;
        $prelaunch_data->official_mail_name=$request->official_mail_name;
        $prelaunch_data->google_list_status=$request->google_list_status;
        $prelaunch_data->google_link=$request->google_link;
        $prelaunch_data->fb_page_status=$request->fb_page_status;
        $prelaunch_data->fb_link=$request->fb_link;
        $prelaunch_data->insta_page_status=$request->insta_page_status;
        $prelaunch_data->insta_link=$request->insta_link;
        $prelaunch_data->interior_design_status=$request->interior_design_status;
         if($request->hasFile("interior_design")):
    $interior_design=$request->file("interior_design");
    $interior_design_name=rand(0, 99999).".".$interior_design->getClientOriginalExtension();
    $interior_design_path=public_path("/uploads/fanchise");
    $interior_design->move($interior_design_path,$interior_design_name);
    $prelaunch_data->interior_design=$interior_design_name;
        endif;
        
        $prelaunch_data->branding_status=$request->branding_status;
            if($request->hasFile("branding_design")):
    $branding_design=$request->file("branding_design");
    $branding_design_name=rand(0, 99999).".".$branding_design->getClientOriginalExtension();
    $branding_design_path=public_path("/uploads/fanchise");
    $branding_design->move($branding_design_path,$branding_design_name);
    $prelaunch_data->branding_design=$branding_design_name;
        endif;
       
        $prelaunch_data->menu_dine_status=$request->menu_dine_status;
          if($request->hasFile("menu_dine")):
    $menu_dine=$request->file("menu_dine");
    $menu_dine_name=rand(0, 99999).".".$menu_dine->getClientOriginalExtension();
    $menu_dine_path=public_path("/uploads/fanchise");
    $menu_dine->move($menu_dine_path,$menu_dine_name);
    $prelaunch_data->menu_dine=$menu_dine_name;
        endif;
    
        $prelaunch_data->menu_online_status=$request->menu_online_status;
        $prelaunch_data->menu_online=$request->menu_online;
        $prelaunch_data->zomato_onboarding_status=$request->zomato_onboarding_status;
        $prelaunch_data->swiggy_onboarding_status=$request->swiggy_onboarding_status;
        $prelaunch_data->npi_pamphlets_status=$request->npi_pamphlets_status;
          if($request->hasFile("npi_pamphlets")):
    $npi_pamphlets=$request->file("npi_pamphlets");
    $npi_pamphlets_name=rand(0, 99999).".".$npi_pamphlets->getClientOriginalExtension();
    $npi_pamphlets_path=public_path("/uploads/fanchise");
    $npi_pamphlets->move($npi_pamphlets_path,$npi_pamphlets_name);
    $prelaunch_data->npi_pamphlets=$npi_pamphlets_name;
        endif;
       
        $prelaunch_data->hoarding_design_status=$request->hoarding_design_status;
         if($request->hasFile("hoarding_design")):
    $hoarding_design=$request->file("hoarding_design");
    $hoarding_design_name=rand(0, 99999).".".$hoarding_design->getClientOriginalExtension();
    $hoarding_design_path=public_path("/uploads/fanchise");
    $hoarding_design->move($hoarding_design_path,$hoarding_design_name);
    $prelaunch_data->hoarding_design=$hoarding_design_name;
        endif;
       
        $prelaunch_data->banner_design_status=$request->banner_design_status;
         if($request->hasFile("banner_design")):
    $banner_design=$request->file("banner_design");
    $banner_design_name=rand(0, 99999).".".$banner_design->getClientOriginalExtension();
    $banner_design_path=public_path("/uploads/fanchise");
    $banner_design->move($banner_design_path,$banner_design_name);
    $prelaunch_data->banner_design=$banner_design_name;
        endif;
       
        $prelaunch_data->newspaper_ad_status=$request->newspaper_ad_status;
         if($request->hasFile("newspaper_ad")):
    $newspaper_ad=$request->file("newspaper_ad");
    $newspaper_ad_name=rand(0, 99999).".".$newspaper_ad->getClientOriginalExtension();
    $newspaper_ad_path=public_path("/uploads/fanchise");
    $newspaper_ad->move($newspaper_ad_path,$newspaper_ad_name);
    $prelaunch_data->newspaper_ad=$newspaper_ad_name;
        endif;
         $prelaunch_data->user_id=$user_id;
        $prelaunch_data->system_ip=CustomHelpers::get_ip();
        $prelaunch_data->save();
        $registration_step=FanchiseRegistrationStep::where('user_id','=',$user_id)->first();
        if($registration_step==''):
          $registration_step=new FanchiseRegistrationStep; 
        endif;
        $registration_step->prelaunch=1;
        $registration_step->user_id=$user_id;
        $registration_step->system_ip=CustomHelpers::get_ip();
        $registration_step->save();
         echo "success";


        elseif($serial_id==6):
              $user_id=Session::get('user_id');
        $launch_data=FanchiseLaunch::where('user_id','=',$user_id)->first();
        if($launch_data==''):
        $launch_data=new FanchiseLaunch; 
        endif;
          $launch_data->launch_date=$request->launch_date;
          $launch_data->aggrement_status=$request->aggrement_status;
          if($request->hasFile("aggrement_doc")):
    $aggrement_doc=$request->file("aggrement_doc");
    $aggrement_doc_name=rand(0, 99999).".".$aggrement_doc->getClientOriginalExtension();
    $aggrement_doc_path=public_path("/uploads/fanchise");
    $aggrement_doc->move($aggrement_doc_path,$aggrement_doc_name);
    $launch_data->aggrement_doc=$aggrement_doc_name;
        endif;
        
          $launch_data->manpower_hiring_status=$request->manpower_hiring_status;
          $launch_data->signage_status=$request->signage_status;
          $launch_data->menu_display_board_status=$request->menu_display_board_status;
          $launch_data->temple_status=$request->temple_status;
          $launch_data->edc_status=$request->edc_status;
          $launch_data->billing_software_status=$request->billing_software_status;
          $launch_data->coke_pepsi_status=$request->coke_pepsi_status;
          $launch_data->local_purchase_status=$request->local_purchase_status;
          $launch_data->chain_order_status=$request->chain_order_status;
          $launch_data->sop_status=$request->sop_status;
          $launch_data->uniforms_status=$request->uniforms_status;
          $launch_data->kitchen_equi_status=$request->kitchen_equi_status;
          $launch_data->cutlery_status=$request->cutlery_status;
          $launch_data->furnitures_status=$request->furnitures_status;
          $launch_data->gas_status=$request->gas_status;
          $launch_data->electricity_status=$request->electricity_status;
          $launch_data->water_drainage_status=$request->water_drainage_status;
          $launch_data->music_status=$request->music_status;
          $launch_data->ac_status=$request->ac_status;
          $launch_data->wifi_status=$request->wifi_status;
          $launch_data->cctv_status=$request->cctv_status;
          $launch_data->fire_status=$request->fire_status;
          $launch_data->stock_status=$request->stock_status;
          $launch_data->system_ip=CustomHelpers::get_ip();
            $launch_data->user_id=$user_id;
      
         $launch_data->save();
        $registration_step=FanchiseRegistrationStep::where('user_id','=',$user_id)->first();
        if($registration_step==''):
          $registration_step=new FanchiseRegistrationStep; 
        endif;
        $registration_step->launch=1;
        $registration_step->user_id=$user_id;
        $registration_step->system_ip=CustomHelpers::get_ip();
        $registration_step->save();
         echo "success";
       elseif($serial_id==0):
        echo "success";
        endif;
    
   
     // 
    }
    public function myNotification($type)
    {
        switch ($type) {
            case 'message':
                alert()->message('Sweet Alert with message.');
                break;
            case 'basic':
                alert()->basic('Sweet Alert with basic.','Basic');
                break;
            case 'info':
                alert()->info('Sweet Alert with info.');
                break;
            case 'success':
                alert()->success('Sweet Alert with success.','Welcome to ItSolutionStuff.com')->autoclose(3500);
                break;
            case 'error':
                alert()->error('Sweet Alert with error.');
                break;
            case 'warning':
                alert()->warning('Sweet Alert with warning.');
                break;
            default:
                # code...
                break;
        }


        return view('admin.fanchise.my-notification');
    }
    
}

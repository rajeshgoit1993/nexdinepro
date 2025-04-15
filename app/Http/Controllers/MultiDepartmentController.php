<?php

namespace App\Http\Controllers;
use App\Notifications\UserWelcomeNotification;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\User;
use App\Helpers\CustomHelpers;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\StoreDetails;
use App\Models\UserExtraDetails;
use Validator;
use Sentinel;
use DB;
use Activation;
use App\Models\Department;
use App\Models\Designation;
use App\Models\OfficeAddress;
use App\Models\HRMSShift;

class MultiDepartmentController extends Controller
{
   public function get_dist(Request $request)
   {
    $districts=District::where('state_id','=',$request->state_id)->get();
    $html='<option value="">--Select District--</option>';
    foreach($districts as $district):
$html.='<option value="'.$district->district_title.'" dist_id="'.$district->id.'">'.$district->district_title.'</option>';
    endforeach;
     echo $html;
   }
   public function get_city(Request $request)
   {
    $cities=City::where('districtid','=',$request->dist_id)->get();
    $html='<option value="">--Select City--</option>';
    foreach($cities as $city):
$html.='<option value="'.$city->name.'">'.$city->name.'</option>';
    endforeach;
     echo $html;
   }
   public function index()
    {
        $loged_user=Sentinel::getUser();
        $user = User::where([['registration_level','=',3],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
        $all_roles = Role::all();
        
       
        //dd($all_roles);
        return view('admin.multidepartmentuser.index',compact('user','all_roles'));
    }
      
    public function manage_vendor()
    {
        $loged_user=Sentinel::getUser();
        $user = User::where([['registration_level','=',5],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
        $all_roles = Role::all();
     
       
        //dd($all_roles);
        return view('admin.multidepartmentuser.index',compact('user','all_roles'));
    }
      public function manage_staff()
    {
        $loged_user=Sentinel::getUser();
        $user = User::where([['registration_level','=',7],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
        $all_roles = Role::all();
        //dd($all_roles);
        return view('admin.multidepartmentuser.index',compact('user','all_roles'));
    }
    //  public function manage_factory()
    // {
    //     $loged_user=Sentinel::getUser();
    //     $user = User::where([['registration_level','=',6],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
    //     $all_roles = Role::all();
     
       
    //     //dd($all_roles);
    //     return view('admin.multidepartmentuser.index',compact('user','all_roles'));
    // }
    public function create()
    {
         $all_roles = Role::whereNotIn('slug',['superadmin','fanchise','masterfanchise','store','vendor','factory','kitchen','waiter','cashier'])->get();
         $states=State::all();
         $department=Department::all();
         $designation=Designation::all();
         $shifts=HRMSShift::all();
        $ofce_locations=OfficeAddress::all();
         return view('admin.multidepartmentuser.create',compact('all_roles','states','department','designation','shifts','ofce_locations'));
    }
    
    public function add_vendor()
    {
         $all_roles = Role::whereIn('slug',['vendor'])->get();
         $states=State::all();
         return view('admin.multidepartmentuser.create',compact('all_roles','states'));
    }
     public function add_staff()
    {
         $all_roles = Role::whereIn('slug',['waiter','kitchen','cashier'])->get();

         $states=State::all();
         return view('admin.multidepartmentuser.create',compact('all_roles','states'));
    }
     public function add_factory()
    {
         $all_roles = Role::whereIn('slug',['factory'])->get();
         $states=State::all();
         return view('admin.multidepartmentuser.create',compact('all_roles','states'));
    }
    public function edit(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $uers_data=User::find($id);
        $all_roles = Role::whereNotIn('slug',['superadmin','fanchise','masterfanchise','store','vendor','factory','kitchen','waiter','cashier'])->get();
        $user_roles=DB::table('role_users')->where('user_id','=',$id)->get();
        $states=State::all(); 
       
        $department=Department::all();
         $designation=Designation::all();

        $shifts=HRMSShift::all();
        $ofce_locations=OfficeAddress::all();
        // dd($user_roles);
         return view('admin.multidepartmentuser.create',compact('uers_data','all_roles','user_roles','states','department','designation','shifts','ofce_locations'));


       
    }
    public function edit_store(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $uers_data=User::find($id);
        $all_roles = Role::whereIn('slug',['store'])->get();
        $user_roles=DB::table('role_users')->where('user_id','=',$id)->get();
        $states=State::all(); 
       

        // dd($user_roles);
         return view('admin.multidepartmentuser.create',compact('uers_data','all_roles','user_roles','states'));
       
    }
      public function edit_vendor(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $uers_data=User::find($id);
        $all_roles = Role::whereIn('slug',['vendor'])->get();
        $user_roles=DB::table('role_users')->where('user_id','=',$id)->get();
        $states=State::all(); 
       

        // dd($user_roles);
         return view('admin.multidepartmentuser.create',compact('uers_data','all_roles','user_roles','states'));
       
    }
    public function edit_staff(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $uers_data=User::find($id);
        $all_roles = Role::whereIn('slug',['waiter','kitchen','cashier'])->get();
        $user_roles=DB::table('role_users')->where('user_id','=',$id)->get();
        $states=State::all(); 
       

        // dd($user_roles);
         return view('admin.multidepartmentuser.create',compact('uers_data','all_roles','user_roles','states'));
       
    }
     public function edit_factory(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $uers_data=User::find($id);
        $all_roles = Role::whereIn('slug',['factory'])->get();
        $user_roles=DB::table('role_users')->where('user_id','=',$id)->get();
        $states=State::all(); 
       

        // dd($user_roles);
         return view('admin.multidepartmentuser.create',compact('uers_data','all_roles','user_roles','states'));
       
    }
    public function user_register_update(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
       if($request->input('password'))
       {
        $validator = Validator::make($request->all(), 
              [ 
            'email' => "required|email|unique:users,email,$id",
            'password'=>"required",
            'password_confirmation'=>"required|same:password"

           
             ]); 
           if($validator->fails()) 
            {          
           echo "The email id has already been taken or Password Not Matched";            
            } 
            else
            {
       $loged_user=Sentinel::getUser();
        $user = Sentinel::findById($id);
        $userData['user_id']=$request->email;
        $userData['email']=$request->email;
        $userData['password']=$request->input('password');
        $level=$request->level;
        if($level==1)
        {
        $userData['registration_level']=3;

        }
        elseif($level==2)
        {
        $userData['registration_level']=4;
      

        }
        elseif($level==3)
        {
        $userData['registration_level']=5;

        }
        elseif($level==4)
        {
        $userData['registration_level']=6;

        }
        elseif($level==5)
        {
        $userData['registration_level']=7;

        }
        $userData['name']=$request->name;
        $userData['mobile']=$request->mobile;
        $userData['birthday']=$request->birthday;
        $userData['state']=$request->state;
        $userData['dist']=$request->dist;
        $userData['city']=$request->city;
        $userData['address']=$request->address;
        $userData['parent_id']=$loged_user->parent_id;
        
        $user = Sentinel::update($user, $userData);

        // $user=Sentinel::registerAndActivate($userData);
         //
       $role=DB::table('role_users')
              
               ->where('user_id','=',$id)
               ->first();
        $role_id=$role->role_id;
        $role_main=DB::table('roles')
              
               ->where('id','=',$role_id)
               ->first();
       
       $role_pre = Sentinel::findRoleBySlug($role_main->slug); 
       $role_pre->users()->detach($id);
       //
        $role=Sentinel::findRoleBySlug($request->user_role);
        $role->users()->attach($user);  
        if($level==1)
        {
        $extra_details=UserExtraDetails::where('store_id','=',$user->id)->first();
        if($extra_details==''):
        $extra_details=new UserExtraDetails; 
        endif;

       
        $extra_details->store_id=$user->id;
        $extra_details->designation=$request->designation;
        $extra_details->userlevel=$request->userlevel;
        $extra_details->reporting_manager=$request->reporting_manager;
        $extra_details->department=$request->department;
        $extra_details->shift_id=$request->shift_id;
        $extra_details->office_location_id=$request->office_location_id;
        $extra_details->save();

        }
        echo "success";
         } 

       }
        else
        {
           
        $validator = Validator::make($request->all(), 
              [ 
            'email' => "required|email|unique:users,email,$id",
           
             ]); 
           if($validator->fails()) 
            {          
           echo "The email id has already been taken.";            
            } 
            else
            {
       $loged_user=Sentinel::getUser();
        $user = Sentinel::findById($id);
        $userData['user_id']=$request->email;
        $userData['email']=$request->email;
        $level=$request->level;
        if($level==1)
        {
        $userData['registration_level']=3;

        }
        elseif($level==2)
        {
        $userData['registration_level']=4;
      

        }
        elseif($level==3)
        {
        $userData['registration_level']=5;

        }
        elseif($level==4)
        {
        $userData['registration_level']=6;

        }
        elseif($level==5)
        {
        $userData['registration_level']=7;

        }
        $userData['name']=$request->name;
        $userData['mobile']=$request->mobile;
        $userData['birthday']=$request->birthday;
        $userData['state']=$request->state;
        $userData['dist']=$request->dist;
        $userData['city']=$request->city;
        $userData['address']=$request->address;
        $userData['parent_id']=$loged_user->parent_id;
        
        $user = Sentinel::update($user, $userData);

        // $user=Sentinel::registerAndActivate($userData);
         //
       $role=DB::table('role_users')
              
               ->where('user_id','=',$id)
               ->first();
        $role_id=$role->role_id;
        $role_main=DB::table('roles')
              
               ->where('id','=',$role_id)
               ->first();
       
       $role_pre = Sentinel::findRoleBySlug($role_main->slug); 
       $role_pre->users()->detach($id);
       //
        $role=Sentinel::findRoleBySlug($request->user_role);
        $role->users()->attach($user);  
        if($level==1)
        {
        $extra_details=UserExtraDetails::where('store_id','=',$user->id)->first();
        if($extra_details==''):
        $extra_details=new UserExtraDetails; 
        endif;

       
        $extra_details->store_id=$user->id;
        $extra_details->designation=$request->designation;
        $extra_details->userlevel=$request->userlevel;
        $extra_details->reporting_manager=$request->reporting_manager;
        $extra_details->department=$request->department;
        $extra_details->shift_id=$request->shift_id;
        $extra_details->office_location_id=$request->office_location_id;
        $extra_details->save();

        }
        echo "success";
         }  
        }
         
    }
    public function user_register(Request $request)
    {

         $validator = Validator::make($request->all(), 
              [ 
           'email'=>"required|unique:users",
           
          
           
             ]); 
           if($validator->fails()) 
            {          
           echo "The email id has already been taken.";            
            } 
            else
            {
        $loged_user=Sentinel::getUser();
        
        $userData['user_id']=$request->email;
        $userData['email']=$request->email;
        $level=$request->level;
         if($level==1)
        {
        $userData['registration_level']=3;

        }
        elseif($level==2)
        {
        $userData['registration_level']=4;
        
        
        }
        elseif($level==3)
        {
        $userData['registration_level']=5;

        }
        elseif($level==4)
        {
        $userData['registration_level']=6;

        }
        elseif($level==5)
        {
        $userData['registration_level']=7;

        }
        $userData['name']=$request->name;
        $userData['mobile']=$request->mobile;
        $userData['birthday']=$request->birthday;
        $userData['state']=$request->state;
        $userData['dist']=$request->dist;
        $userData['city']=$request->city;
        $userData['address']=$request->address;
        $userData['parent_id']=$loged_user->parent_id;
        $userData['password']='123456';
        $user=Sentinel::registerAndActivate($userData);
        $role=Sentinel::findRoleBySlug($request->user_role);
        $role->users()->attach($user);  
        if($level==1)
        {
        $extra_details=new UserExtraDetails;
        $extra_details->store_id=$user->id;
        $extra_details->designation=$request->designation;
        $extra_details->userlevel=$request->userlevel;
        $extra_details->reporting_manager=$request->reporting_manager;
        $extra_details->department=$request->department;
        $extra_details->shift_id=$request->shift_id;
        $extra_details->office_location_id=$request->office_location_id;
        $extra_details->save();

        }
        elseif($level==2)
        {
       
        $kyc_data=new StoreDetails;
        $kyc_data->store_id=$user->id;
        $kyc_data->save();
        
        }
        elseif($level==3)
        {
        $kyc_data=new StoreDetails;
        $kyc_data->store_id=$user->id;
        $kyc_data->save();

        }
        elseif($level==4)
        {
        $kyc_data=new StoreDetails;
        $kyc_data->store_id=$user->id;
        $kyc_data->save();

        }
        $user->notify(new UserWelcomeNotification());
        echo "success";
         } 
    }
     public function disable_user(Request $request)
     {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $sentinal_user=Sentinel::findById($id);
        Activation::remove($sentinal_user);

     }
     public function enable_user(Request $request)
     {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $sentinal_user=Sentinel::findById($id);
        $activation = Activation::create($sentinal_user);
        Activation::complete($sentinal_user, $activation->code);
        
     }
     public function delete_user(Request $request)
     {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $user=Sentinel::findById($id);
        $userData['status']=0;
        
        $user = Sentinel::update($user, $userData);
        $sentinal_user=Sentinel::findById($id);
        Activation::remove($sentinal_user);
        
     }
     public function user_account()
    {
        $id=Sentinel::getUser()->id;
        $fanchise_detail = User::find($id);
        $all_roles = Role::all();
      
       
        //dd($all_roles);
        return view('admin.multidepartmentuser.user_account',compact('fanchise_detail','all_roles'));
    }
    public function edit_user(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $uers_data=User::find($id);
        $all_roles = Role::whereNotIn('slug',['superadmin','fanchise','masterfanchise'])->get();
        $user_roles=DB::table('role_users')->where('user_id','=',$id)->get();
        $states=State::all(); 
       

        // dd($user_roles);
       


//         $get_data=CustomHelpers::callAPI('GET','https://portal.vasudevsms.in/api/mt/SendSMS?user=Kathination1221&password=S95DfBpcmw&senderid=KTNATN&channel=Promo&DCS=0&flashsms=0&number=919899583414&text=Kathi Nation March special 
// Any Roll+ Any quick bite +One coke 
// Non-veg-Rs 349/- Veg-Rs 299/-
// T&C applicable
// Offer valid Mar 1-7th&route=Promotional&DLTsenderid=1307164621470091290', false);
        // $send_message = json_decode($get_data, true);
        


         return view('admin.multidepartmentuser.edit_user',compact('uers_data','all_roles','user_roles','states'));
       
    }
    public function store_user_data(Request $request)
    {
    
       $level=$request->level;
     if($level==0):

     $checkdata=UserExtraDetails::where('store_id','=',Sentinel::getUser()->id)->first();
     if($checkdata==''):
     $data=new UserExtraDetails; 
     $data->store_id=Sentinel::getUser()->id;
     else:
       $data=UserExtraDetails::find($checkdata->id);  
     endif;
     
       $new_user = Sentinel::findById(Sentinel::getUser()->id);
     else:
      $checkdata=UserExtraDetails::where('store_id','=',$request->user_id)->first();
     if($checkdata==''):
     $data=new UserExtraDetails; 
     $data->store_id=$request->user_id;
     else:
       $data=UserExtraDetails::find($checkdata->id);  
     endif;
      //
       $new_user = Sentinel::findById($request->user_id);
    endif;
       $new_data['status']=2;
       Sentinel::update($new_user, $new_data);  
    
     //
    
        $data->objective=$request->objective;
        $data->exp=$request->exp;
        $data->primary_skil=serialize($request->primary_skil);
        $data->secondry_skil=serialize($request->secondry_skil);
        $data->last_degree=serialize($request->education);
        
        $data->certification=serialize($request->certification);
        $data->other_accomplishments=serialize($request->other_accomplishments);
        $data->first_name=$request->first_name;
        $data->last_name=$request->last_name;
        $data->nick_name=$request->nick_name;
        $data->fathers_name=$request->fathers_name;
        $data->email_id=$request->email_id;
        $data->mobile_no=$request->mobile_no;
        $data->contact_no=$request->contact_no;
        $data->passport_no=$request->passport_no;
        $data->language=serialize($request->language);
        $data->nationality=$request->nationality;
        $data->marital_status=$request->marital_status;
        $data->hobbies=serialize($request->hobbies);
        $data->softskills=serialize($request->softskills);
        $data->strengths=serialize($request->strengths);
        $data->address_line_first=$request->address_line_first;
        $data->address_line_second=$request->address_line_second;
        $data->city=$request->city;
        $data->state=$request->state;
        $data->pin_code=$request->pin_code;
        $data->experience=serialize($request->experience);
        $data->employment=serialize($request->employment);
     

       $data->account_name=$request->account_name;
       $data->account_no=$request->account_no;
       $data->bankname=$request->bankname;
       $data->ifsc=$request->ifsc;
       $data->account_type=$request->account_type;
       $data->aadhar_no=$request->aadhar_no;
       $data->pan_no=$request->pan_no;
       $data->dob=$request->dob;
       $data->blood_group=$request->blood_group;
       $data->goal_small=$request->goal_small;
       $data->goal_large=$request->goal_large;
       //
       $data->mother_name=$request->mother_name;
       $data->mother_email_id=$request->mother_email_id;
       $data->mother_contact_no=$request->mother_contact_no;
       $data->spouse_name=$request->spouse_name;
       $data->spouse_email_id=$request->spouse_email_id;
       $data->spouse_contact_no=$request->spouse_contact_no;
       if ($request->has('employement_status')) {
       $data->employement_status=$request->employement_status;
         }
       $data->un_no=$request->un_no;
       $data->esi_no=$request->esi_no;
       $data->dist=$request->dist;
       //
       if($request->hasFile("photograph")):
    $doc21=$request->file("photograph");
    $doc21_name=$request->first_name."_photograph_".rand().".".$doc21->getClientOriginalExtension();
    $doc21_path=public_path("/uploads/documents");
    $doc21->move($doc21_path,$doc21_name);
    $data->photograph=$doc21_name;
        endif;
         if($request->hasFile("doc_aadhar")):
    $doc1=$request->file("doc_aadhar");
    $doc1_name=$request->first_name."_aadhar_".rand().".".$doc1->getClientOriginalExtension();
    $doc1_path=public_path("/uploads/documents");
    $doc1->move($doc1_path,$doc1_name);
    $data->doc_aadhar=$doc1_name;
        endif;
        if($request->hasFile("doc_pan")):
    $doc2=$request->file("doc_pan");
    $doc2_name=$request->first_name."_pan_".rand().".".$doc2->getClientOriginalExtension();
    $doc2_path=public_path("/uploads/documents");
    $doc2->move($doc2_path,$doc2_name);
    $data->doc_pan=$doc2_name;
        endif;
        if($request->hasFile("doc_relieving")):
    $doc3=$request->file("doc_relieving");
    $doc3_name=$request->first_name."_doc_relieving_".rand().".".$doc3->getClientOriginalExtension();
    $doc3_path=public_path("/uploads/documents");
    $doc3->move($doc3_path,$doc3_name);
    $data->doc_relieving=$doc3_name;
        endif;
        if($request->hasFile("doc_cancel_cheque")):
    $doc4=$request->file("doc_cancel_cheque");
    $doc4_name=$request->first_name."_doc_cancel_cheque_".rand().".".$doc4->getClientOriginalExtension();
    $doc4_path=public_path("/uploads/documents");
    $doc4->move($doc4_path,$doc4_name);
    $data->doc_cancel_cheque=$doc4_name;
        endif;
        if($request->hasFile("doc_qualification")):
    $doc5=$request->file("doc_qualification");
    $doc5_name=$request->first_name."_doc_qualification_".rand().".".$doc5->getClientOriginalExtension();
    $doc5_path=public_path("/uploads/documents");
    $doc5->move($doc5_path,$doc5_name);
    $data->doc_qualification=$doc5_name;
        endif;
        if($request->hasFile("doc_certification")):
    $doc6=$request->file("doc_certification");
    $doc6_name=$request->first_name."_doc_certification_".rand().".".$doc6->getClientOriginalExtension();
    $doc6_path=public_path("/uploads/documents");
    $doc6->move($doc6_path,$doc6_name);
    $data->doc_certification=$doc6_name;

        endif;
        
        if($request->hasFile("address_proof")):
    $doc7=$request->file("address_proof");
    $doc7_name=$request->first_name."_address_proof_".rand().".".$doc7->getClientOriginalExtension();
    $doc7_path=public_path("/uploads/documents");
    $doc7->move($doc7_path,$doc7_name);
    $data->address_proof=$doc7_name;
        endif;
        if($request->hasFile("id_proof")):
    $doc8=$request->file("id_proof");
    $doc8_name=$request->first_name."_id_proof_".rand().".".$doc8->getClientOriginalExtension();
    $doc8_path=public_path("/uploads/documents");
    $doc8->move($doc8_path,$doc8_name);
    $data->id_proof=$doc8_name;
        endif;
        if($request->hasFile("payslip")):
    $doc9=$request->file("payslip");
    $doc9_name=$request->first_name."_payslip_".rand().".".$doc9->getClientOriginalExtension();
    $doc9_path=public_path("/uploads/documents");
    $doc9->move($doc9_path,$doc9_name);
    $data->payslip=$doc9_name;
        endif;
       //

       
        $data->save();
        $level=$request->level;
    if($level==0):
        return redirect()->route('user_account')->with("success","Your Details Updated Successfully");
    elseif($level==1):
        return redirect()->route('manage_dept_employee')->with("success","Details Updated Successfully");
    elseif($level==2):
        return redirect()->route('manage_vendor')->with("success","Details Updated Successfully");
    endif;
    }
    public function store_user_data_step(Request $request)
    {
      $checkdata=UserExtraDetails::where('store_id','=',$request->user_id)->first();
     if($checkdata==''):
     $data=new UserExtraDetails; 
     $data->store_id=$request->user_id;
     else:
       $data=UserExtraDetails::find($checkdata->id);  
     endif;
      //

     //
    
        $data->objective=$request->objective;
        $data->exp=$request->exp;
        $data->primary_skil=serialize($request->primary_skil);
        $data->secondry_skil=serialize($request->secondry_skil);
        $data->last_degree=serialize($request->education);
        
        $data->certification=serialize($request->certification);
        $data->other_accomplishments=serialize($request->other_accomplishments);
        $data->first_name=$request->first_name;
        $data->last_name=$request->last_name;
        $data->nick_name=$request->nick_name;
        $data->fathers_name=$request->fathers_name;
        $data->email_id=$request->email_id;
        $data->mobile_no=$request->mobile_no;
        $data->contact_no=$request->contact_no;
        $data->passport_no=$request->passport_no;
        $data->language=serialize($request->language);
        $data->nationality=$request->nationality;
        $data->marital_status=$request->marital_status;
        $data->hobbies=serialize($request->hobbies);
        $data->softskills=serialize($request->softskills);
        $data->strengths=serialize($request->strengths);
        $data->address_line_first=$request->address_line_first;
        $data->address_line_second=$request->address_line_second;
        $data->city=$request->city;
        $data->state=$request->state;
        $data->pin_code=$request->pin_code;
        $data->experience=serialize($request->experience);
        $data->employment=serialize($request->employment);
     

       $data->account_name=$request->account_name;
       $data->account_no=$request->account_no;
       $data->bankname=$request->bankname;
       $data->ifsc=$request->ifsc;
       $data->account_type=$request->account_type;
       $data->aadhar_no=$request->aadhar_no;
       $data->pan_no=$request->pan_no;
       $data->dob=$request->dob;
       $data->blood_group=$request->blood_group;
       $data->goal_small=$request->goal_small;
       $data->goal_large=$request->goal_large;
       //
        $data->mother_name=$request->mother_name;
       $data->mother_email_id=$request->mother_email_id;
       $data->mother_contact_no=$request->mother_contact_no;
       $data->spouse_name=$request->spouse_name;
       $data->spouse_email_id=$request->spouse_email_id;
       $data->spouse_contact_no=$request->spouse_contact_no;
       if ($request->has('employement_status')) {
       $data->employement_status=$request->employement_status;
         }

        
        $data->un_no=$request->un_no;
        $data->esi_no=$request->esi_no;
        $data->dist=$request->dist;
       //
       if($request->hasFile("photograph")):
    $doc21=$request->file("photograph");
    $doc21_name=$request->first_name."_photograph_".rand().".".$doc21->getClientOriginalExtension();
    $doc21_path=public_path("/uploads/documents");
    $doc21->move($doc21_path,$doc21_name);
    $data->photograph=$doc21_name;
        endif;
         if($request->hasFile("doc_aadhar")):
    $doc1=$request->file("doc_aadhar");
    $doc1_name=$request->first_name."_aadhar_".rand().".".$doc1->getClientOriginalExtension();
    $doc1_path=public_path("/uploads/documents");
    $doc1->move($doc1_path,$doc1_name);
    $data->doc_aadhar=$doc1_name;
        endif;
        if($request->hasFile("doc_pan")):
    $doc2=$request->file("doc_pan");
    $doc2_name=$request->first_name."_pan_".rand().".".$doc2->getClientOriginalExtension();
    $doc2_path=public_path("/uploads/documents");
    $doc2->move($doc2_path,$doc2_name);
    $data->doc_pan=$doc2_name;
        endif;
        if($request->hasFile("doc_relieving")):
    $doc3=$request->file("doc_relieving");
    $doc3_name=$request->first_name."_doc_relieving_".rand().".".$doc3->getClientOriginalExtension();
    $doc3_path=public_path("/uploads/documents");
    $doc3->move($doc3_path,$doc3_name);
    $data->doc_relieving=$doc3_name;
        endif;
        if($request->hasFile("doc_cancel_cheque")):
    $doc4=$request->file("doc_cancel_cheque");
    $doc4_name=$request->first_name."_doc_cancel_cheque_".rand().".".$doc4->getClientOriginalExtension();
    $doc4_path=public_path("/uploads/documents");
    $doc4->move($doc4_path,$doc4_name);
    $data->doc_cancel_cheque=$doc4_name;
        endif;
        if($request->hasFile("doc_qualification")):
    $doc5=$request->file("doc_qualification");
    $doc5_name=$request->first_name."_doc_qualification_".rand().".".$doc5->getClientOriginalExtension();
    $doc5_path=public_path("/uploads/documents");
    $doc5->move($doc5_path,$doc5_name);
    $data->doc_qualification=$doc5_name;
        endif;
        if($request->hasFile("doc_certification")):
    $doc6=$request->file("doc_certification");
    $doc6_name=$request->first_name."_doc_certification_".rand().".".$doc6->getClientOriginalExtension();
    $doc6_path=public_path("/uploads/documents");
    $doc6->move($doc6_path,$doc6_name);
    $data->doc_certification=$doc6_name;

        endif;
        
        if($request->hasFile("address_proof")):
    $doc7=$request->file("address_proof");
    $doc7_name=$request->first_name."_address_proof_".rand().".".$doc7->getClientOriginalExtension();
    $doc7_path=public_path("/uploads/documents");
    $doc7->move($doc7_path,$doc7_name);
    $data->address_proof=$doc7_name;
        endif;
        if($request->hasFile("id_proof")):
    $doc8=$request->file("id_proof");
    $doc8_name=$request->first_name."_id_proof_".rand().".".$doc8->getClientOriginalExtension();
    $doc8_path=public_path("/uploads/documents");
    $doc8->move($doc8_path,$doc8_name);
    $data->id_proof=$doc8_name;
        endif;
        if($request->hasFile("payslip")):
    $doc9=$request->file("payslip");
    $doc9_name=$request->first_name."_payslip_".rand().".".$doc9->getClientOriginalExtension();
    $doc9_path=public_path("/uploads/documents");
    $doc9->move($doc9_path,$doc9_name);
    $data->payslip=$doc9_name;
        endif;
       //

       
        $data->save();
       

    }
    // public function destroy($id,Request $request) {
        
    //     $user = Sentinel::findById($id);
    //     $user->delete();
    //     return redirect()->back()->with('success','User has been deleted successfully!');
    // }
}

<?php

namespace App\Http\Controllers;

use App\Models\PageAccess;
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
use App\Models\UtensilList;
use App\Models\FirstTimeStockCart;
use App\Models\ItemImages;
use Validator;
use Sentinel;
use DB;

class PageAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function get_page_access_data(Request $request)
    {
       $role_id=$request->id;      
       $role_id=CustomHelpers::custom_decrypt($role_id); 
       if($role_id==1 || $role_id==2 || $role_id==12):
        $output='NA';
       else:

       $output='<table class="table table-bordered">
 
    <tbody>
      <tr>
        <td>New Registration</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="new_registration"';
        if(CustomHelpers::get_page_access($role_id,'new_registration')==1):
 $output.='checked';
        endif;


              $output.='>
              <span class="slider round"></span>
              </label>
        </td>
        <td>Prelaunch Date</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="prelaunch_date"';
        if(CustomHelpers::get_page_access($role_id,'prelaunch_date')==1):
 $output.='checked';
        endif;


              $output.='>
              <span class="slider round"></span>
              </label>
        </td>
      
        <td>Fanchise Pre-Launch Data</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="fanchise_data"';
        if(CustomHelpers::get_page_access($role_id,'fanchise_data')==1):
 $output.='checked';
        endif;


              $output.='>
              <span class="slider round"></span>
              </label>
        </td>
        </tr>
       <tr>
        <td>Interior Work</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="architect"';
        if(CustomHelpers::get_page_access($role_id,'architect')==1):
 $output.='checked';
        endif;


              $output.='>
              <span class="slider round"></span>
              </label>
        </td>
      
        
        <td>Social</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="social"';
        if(CustomHelpers::get_page_access($role_id,'social')==1):
 $output.='checked';
        endif;


              $output.='>
              <span class="slider round"></span>
              </label>
        </td>
       <td>Procurement</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="procurement"';
        if(CustomHelpers::get_page_access($role_id,'procurement')==1):
 $output.='checked';
        endif;


              $output.='>
              <span class="slider round"></span>
              </label>
        </td>

      </tr>
       <tr>
       
        <td>Operations</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="operations"';
        if(CustomHelpers::get_page_access($role_id,'operations')==1):
 $output.='checked';
        endif;


              $output.='>
              <span class="slider round"></span>
              </label>
        </td>
       <td>Accounts</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="accounts"';
        if(CustomHelpers::get_page_access($role_id,'accounts')==1):
 $output.='checked';
        endif;


              $output.='>
              <span class="slider round"></span>
              </label>
        </td>

    
        
        <td>Pending Fee</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="balance"';
        if(CustomHelpers::get_page_access($role_id,'balance')==1):
 $output.='checked';
        endif;


              $output.='>
              <span class="slider round"></span>
              </label>
        </td>
        </tr>
       <tr>
        <td>Edit Registration</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="edit_part"';
        if(CustomHelpers::get_page_access($role_id,'edit_part')==1):
 $output.='checked';
        endif;

        $output.='>
              <span class="slider round"></span>
              </label>
        </td>
       
        <td>POS</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="billing"';
        if(CustomHelpers::get_page_access($role_id,'billing')==1):
 $output.='checked';
        endif;


        $output.='>
              <span class="slider round"></span>
              </label>
        </td>
        <td>Master Product</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="master_product"';
        if(CustomHelpers::get_page_access($role_id,'master_product')==1):
 $output.='checked';
        endif;

        $output.='>
              <span class="slider round"></span>
              </label>
        </td>
         </tr>
       <tr>
        <td>Setting</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="setting"';
        if(CustomHelpers::get_page_access($role_id,'setting')==1):
 $output.='checked';
        endif;


              $output.='>
              <span class="slider round"></span>
              </label>
        </td>

        <td>View Franchise Details</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="view_franchise_details"';
        if(CustomHelpers::get_page_access($role_id,'view_franchise_details')==1):
 $output.='checked';
        endif;


              $output.='>
              <span class="slider round"></span>
              </label>
        </td>
       <td>Area Manager Work</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="area_manager_work"';
        if(CustomHelpers::get_page_access($role_id,'area_manager_work')==1):
 $output.='checked';
        endif;


              $output.='>
              <span class="slider round"></span>
              </label>
        </td>
      </tr>
    </tbody>
  </table>
        ';
       endif;   
              echo $output;
    }

      public function save_page_access_data(Request $request)
    {
       $role_id=$request->id;      
       $role_id=CustomHelpers::custom_decrypt($role_id); 
       $data=PageAccess::where('role_id','=',$role_id)->first();
        if($data==''):
          $data=new PageAccess; 
        endif;
        $data->role_id=$role_id;
        if($request->has('new_registration')):
       
        $data->new_registration=$request->new_registration;
         else:
            $data->new_registration=0;  
         endif;
        if($request->has('prelaunch_date')):
        
        $data->prelaunch_date=$request->prelaunch_date;
        else:
            $data->prelaunch_date=0;  
        endif;
        if($request->has('fanchise_data')):
        
        $data->fanchise_data=$request->fanchise_data;
        else:
            $data->fanchise_data=0;  
        endif;
        if($request->has('architect')):
        
        $data->architect=$request->architect;
        else:
            $data->architect=0;  
        endif;
        if($request->has('social')):
        
        $data->social=$request->social;
        else:
            $data->social=0;  
        endif;
        if($request->has('procurement')):
        
        $data->procurement=$request->procurement;
        else:
            $data->procurement=0;  
        endif;
        if($request->has('operations')):
        
        $data->operations=$request->operations;
        else:
            $data->operations=0;  
        endif;
        if($request->has('accounts')):
        
        $data->accounts=$request->accounts;
        else:
            $data->accounts=0;  
        endif;
        if($request->has('balance')):
        
        $data->balance=$request->balance;
        else:
            $data->balance=0;  
        endif;
        if($request->has('edit_part')):
        
        $data->edit_part=$request->edit_part;
        else:
            $data->edit_part=0;  
        endif;
         if($request->has('billing')):
        
        $data->billing=$request->billing;
        else:
            $data->billing=0;  
        endif;
         if($request->has('master_product')):
        
        $data->master_product=$request->master_product;
        else:
            $data->master_product=0;  
        endif;
         if($request->has('setting')):
        
        $data->setting=$request->setting;
        else:
            $data->setting=0;  
        endif;

        if($request->has('view_franchise_details')):
        
        $data->view_franchise_details=$request->view_franchise_details;
        else:
            $data->view_franchise_details=0;  
        endif;
         if($request->has('area_manager_work')):
        
        $data->area_manager_work=$request->area_manager_work;
        else:
            $data->view_franchise_details=0;  
        endif;
        
        $data->Save();

        echo 'success';
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PageAccess  $pageAccess
     * @return \Illuminate\Http\Response
     */
    public function show(PageAccess $pageAccess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PageAccess  $pageAccess
     * @return \Illuminate\Http\Response
     */
    public function edit(PageAccess $pageAccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PageAccess  $pageAccess
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PageAccess $pageAccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PageAccess  $pageAccess
     * @return \Illuminate\Http\Response
     */
    public function destroy(PageAccess $pageAccess)
    {
        //
    }
}

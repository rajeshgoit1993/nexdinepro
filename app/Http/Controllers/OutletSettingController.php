<?php

namespace App\Http\Controllers;

use App\Models\OutletSetting;
use Illuminate\Http\Request;
use App\Models\FanchiseRegistration;
use App\Models\FanchiseRegistrationStep;
use App\Models\RegistrationActivityStatus;
use App\Notifications\UserWelcomeNotification;
use App\Models\Role;
use App\Models\User;
use App\Helpers\CustomHelpers;
use App\Helpers\POS_SettingHelpers;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\PreLaunch;
use App\Models\PreLaunchDoc;
use App\Models\UtensilList;
use App\Models\FirstTimeStockCart;
use App\Models\ItemImages;
use App\Models\AssignFoodMenuCategoryToBrands;
use App\Models\AssignFoodMenuIngredient;
use App\Models\AssignFoodMenuToBrands;
use App\Models\FoodMenuCategory;
use App\Models\MasterProduct;
use App\Models\FranchiseFoodMenuPrice;
use App\Models\MasterGst;
use Validator;
use Sentinel;
use DB;

class OutletSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function outlet_menu_enable(Request $request)
    {
        $menu_id=$request->menu_id;  
        $data=FranchiseFoodMenuPrice::find((int)$menu_id);
        $data->status=1;
        $data->save();
        $food_menu_category_ids=DB::table('franchise_food_menu_prices')->where([["outlet_id", $data->outlet_id],['status','=',1],['category_id','!=',0]])->get();
        echo count($food_menu_category_ids);
    }
    public function outlet_menu_disable(Request $request)
    {
        $menu_id=$request->menu_id;  
        $data=FranchiseFoodMenuPrice::find((int)$menu_id);
        $data->status=0;
        $data->save();
        $food_menu_category_ids=DB::table('franchise_food_menu_prices')->where([["outlet_id", $data->outlet_id],['status','=',1],['category_id','!=',0]])->get();
        echo count($food_menu_category_ids);
    }
    public function get_outlet_setting_data(Request $request)
    {
       $outlet_id=$request->id;      
       $outlet_id=CustomHelpers::custom_decrypt($outlet_id); 
       $data=OutletSetting::where('outlet_id',(int)$outlet_id)->first();
       //
     $outlet_brand_id=POS_SettingHelpers::get_brand_by_admin_id($outlet_id);
     $update_pre_pos_data = POS_SettingHelpers::update_pre_pos_data($outlet_id,$outlet_brand_id);
       
       //
       if($data==''):
        $new=new OutletSetting;
        $new->outlet_id=$outlet_id;
        $new->save();
       endif;

        $outlet_brand_id=POS_SettingHelpers::get_brand_by_admin_id($outlet_id);
      
       $update_menues = POS_SettingHelpers::update_outlet_menues($outlet_id,$outlet_brand_id);

       $food_menu_category_ids=DB::table('franchise_food_menu_prices')->where("outlet_id", $outlet_id)->groupBy('category_id')->get();


       $output='<table class="table table-bordered">
 
    <tbody>
      <tr>
        <td>Inventory Manage</td>
        <td><label class="switch">
              <input type="checkbox" value="1" name="inventory_manage"';
        if($data!='' && $data->inventory_manage==1):
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
        $output.='<table class="table table-bordered">
 
    <tbody><tr>';
    $a=1;
    $j=0;
    $k=1;
      foreach($food_menu_category_ids as $category_id):
       if($a%2==0):

        endif;
        if($category_id->category_id!='' && $category_id->category_id!=0):
        $category_name=CustomHelpers::get_master_table_data('food_menu_categories','id',$category_id->category_id,'category_name');
    $outlet_brand_id=POS_SettingHelpers::get_brand_by_admin_id($outlet_id);
        // $menues = DB::table('assign_food_menu_to_brands')
        //    ->join('franchise_food_menu_prices','franchise_food_menu_prices.food_menu_id' , '=', 'assign_food_menu_to_brands.menu_category_id')
        //    ->where([['assign_food_menu_to_brands.brand_id',$outlet_brand_id],['franchise_food_menu_prices.outlet_id',$outlet_id],['franchise_food_menu_prices.category_id','=',$category_id->category_id]])->get();

        $menues=DB::table('franchise_food_menu_prices')->where([['franchise_food_menu_prices.outlet_id','=',(int)$outlet_id],['franchise_food_menu_prices.category_id','=',$category_id->category_id]])
         ->join('food_menus','food_menus.id' , '=', 'franchise_food_menu_prices.food_menu_id')
         ->orderBy('food_menus.name') 
         ->select('franchise_food_menu_prices.*')  
        ->get();

       $output.='
        <td><b>'.$category_name.'</b>

    <table class="table table-bordered">
 
    <tbody>';
    $total_cate=0;
    $total_assign=0;
    foreach($menues as $menu):
        
        $menu_name=CustomHelpers::get_master_table_data('food_menus','id',$menu->food_menu_id,'name');
       

        if($menu_name!='NA'):
           $total_cate++;
      $output.='<tr>
        <td style="padding:2px">'.$k++.'.'.$menu_name.'</td>
        <td style="padding:2px"><label class="">
              <input type="checkbox" class="outlet_menu" value="'.$menu->id.'" name="outlet_menu[]"';
        
if($menu->status==1):
     $j++;
     $total_assign++;
 $output.='checked';
        endif;

              $output.='>
         
              </label>
        </td>
       
      </tr>';
     endif;
       endforeach;
       
      
    $output.='
    <tr>
    <td>Total menues in this category</td>
    <td>'.$total_cate.'</td>
    </tr>
     <tr>
    <td>Total assigned Menues in this category</td>
    <td>'.$total_assign.'</td>
    </tr>
    </tbody>
  </table>

        </td>
       
        ';
       else:
        // $menues = DB::table('assign_food_menu_to_brands')
        //    ->join('franchise_food_menu_prices','franchise_food_menu_prices.food_menu_id' , '=', 'assign_food_menu_to_brands.menu_category_id')
        //    ->where([['assign_food_menu_to_brands.brand_id',$outlet_brand_id],['franchise_food_menu_prices.outlet_id',$outlet_id],['franchise_food_menu_prices.category_id','=',0]])->get();
        
        // $menues=DB::table('franchise_food_menu_prices')->where([['outlet_id','=',(int)$outlet_id],['category_id','=',0]])->get();
        
         $menues=DB::table('franchise_food_menu_prices')->where([['franchise_food_menu_prices.outlet_id','=',(int)$outlet_id],['franchise_food_menu_prices.category_id','=',0]])
         ->join('food_menus','food_menus.id' , '=', 'franchise_food_menu_prices.food_menu_id')
         ->orderBy('food_menus.name') 
         ->select('franchise_food_menu_prices.*')  
        ->get();

     $output.='<td><b>Not Assigned Category</b> <table class="table table-bordered">
 
    <tbody>';
      $total_cate=0;
    $total_assign=0;
    foreach($menues as $menu):
        $menu_name=CustomHelpers::get_master_table_data('food_menus','id',$menu->food_menu_id,'name');
        
        
        if($menu_name!='NA'):
           $total_cate++;
      $output.='<tr>
        <td style="padding:2px">'.$k++.'.'.$menu_name.'</td>
        <td style="padding:2px"><label class="">
              <input class="outlet_menu" type="checkbox " value="'.$menu->id.'" name="outlet_menu[]"';
        
if($menu->status==1):
     $j++;
     $total_assign++;
 $output.='checked';
        endif;

              $output.='>
           
              </label>
        </td>
       
      </tr>';
       endif;
       endforeach;
       
      
    $output.='
  <tr>
    <td>Total menues in this category</td>
    <td>'.$total_cate.'</td>
    </tr>
     <tr>
    <td>Total assigned Menues in this category</td>
    <td>'.$total_assign.'</td>
    </tr>
    </tbody>
  </table>

        </td>
       
        ';
       endif;
      
    
        
        if($a%2==0):
$output.='</tr><tr>';
        endif;
        $a++;
       
      endforeach;
$output.='</tr>
<tr><td colspan="2">Total Menus: <span class="total_menues">'.$j.'</span></td></tr>
   </tbody>
  </table>';
              echo $output;
    }

    public function save_outlet_setting_form(Request $request)
    {
       $outlet_id=$request->id;      
       $outlet_id=CustomHelpers::custom_decrypt($outlet_id); 
       $data=OutletSetting::where('outlet_id','=',(int)$outlet_id)->first(); 
        if($data==''):
          $data=new OutletSetting; 
        endif;
        $data->outlet_id=$outlet_id;
        if($request->has('inventory_manage')):
       
        $data->inventory_manage=$request->inventory_manage;
         else:
            $data->inventory_manage=0;  
         endif;
        
       
        $data->Save();

        echo 'success';
    }
    

    public function index()
    {
        //
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
     * @param  \App\Models\OutletSetting  $outletSetting
     * @return \Illuminate\Http\Response
     */
    public function show(OutletSetting $outletSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OutletSetting  $outletSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(OutletSetting $outletSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OutletSetting  $outletSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OutletSetting $outletSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OutletSetting  $outletSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(OutletSetting $outletSetting)
    {
        //
    }
}

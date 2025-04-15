<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;
use App\Helpers\POS_SettingHelpers;
use App\Helpers\POSCommonHelpers;
use Image;
use App\Models\ItemImages;
use App\Models\MasterGst;
use App\Models\SupplyCart;
use App\Models\OrderPayment;
use App\Models\Brands;
use App\Models\Unit;
use App\Models\User;
use App\Models\Role;
use App\Models\StoreDetails;
use App\Models\Stores;
use App\Models\StoreAssignUser;
use App\Models\StoreProduct;
use App\Models\AssignProductFactoryVendor;
use App\Models\OrderItemDetails;
use App\Models\StoreSetting;
use App\Models\BrandWiseProduct;
use App\Models\FactoryIngredients;
use DB;
use Validator;
use App\Models\FoodMenuCategory;
use App\Models\FoodMenu;
use App\Models\AssignFoodMenuCategoryToBrands;
use App\Models\FranchiseCustomers;
use App\Models\FranchiseSale;
use App\Models\FranchiseFoodMenusModifiers;
use App\Models\FranchiseModifiers;
use App\Models\FranchiseNotificationBarKitchenPanel;
use App\Models\FranchiseNotification;
use App\Models\FranchisePaymentOption;
use App\Models\FranchiseSaleConsuptions;
use App\Models\FranchiseSaleConsuptionsOfMenu;
use App\Models\FranchiseSaleConsuptionsOfModifiersOfMenu;
use App\Models\FranchiseSaleDetailsModifier;
use App\Models\FranchiseSalesDetails;
use App\Models\FranchiseTableSetting;
use App\Models\PosOrderTables;
use App\Models\AssignFoodMenuIngredient;
use App\Models\FranchiseTempKot;
use App\Models\FranchiseTableHold;
use App\Models\FranchiseTableHoldDetails;
use App\Models\FranchiseTableHoldDetailsModifiers;
use App\Models\FranchiseHoldTable;
use App\Models\FranchiseStockStatus;
use App\Models\FranchiseFoodMenuPrice;
use App\Models\OutletSetting;
use App\Exports\ExportDsrRscMtd;
use App\Exports\AllRestaurantsSalesSummary;
use App\Exports\OutletCustomers;
use App\Exports\DiscountSummaryExport;
use App\Exports\DetailDiscountReport;
use App\Exports\ItemWiseTransectionRegister;
use App\Exports\ItemWiseSaleDetails;
use App\Exports\MenuMix;
use App\Exports\BillWiseReport;
use App\Exports\HourlyReport;
use App\Exports\VoidExport;
use App\Exports\InventoryValuation;
use App\Models\RegionSetting;
use Excel;
use PDF; 
use Carbon\CarbonPeriod;
use Carbon\Carbon;
 
class POSReportController extends Controller
{
    public function consumptionreport()
    {
    
       $data=User::whereIn('registration_level',[2,1])
            ->where('status','=',7)->get();

         $to = '2023-03-03';
         $from = '2023-02-02';
            
         //   $data = DB::table('franchise_sales')
         //    ->join('franchise_sale_consuptions_of_menus','franchise_sale_consuptions_of_menus.sales_id', '=','franchise_sales.id')
         //    ->join('master_products','master_products.id', '=','franchise_sale_consuptions_of_menus.ingredient_id')
         //    ->where([['franchise_sales.del_status', 'Live'],['franchise_sales.order_status', 3]])
         //    ->whereBetween('sale_date', [$from, $to])
         //    ->select('franchise_sale_consuptions_of_menus.*','ingredient_id','master_products.product_name as ingredient_name','master_products.initial_qty as ingredient_code','master_products.franchise_rate')
         //    ->get()->groupBy('ingredient_id');
       
         // dd($data);
  
        return view('report.pos.consumptionreport',compact('data'));
    }

    public function getconsumptionreport(Request $request)
    {
        if ($request->ajax()) {

          
             $from = $request->start_date;
             $to = $request->end_date;
             $outlet= $request->outlet;
             if($outlet=='NA'):
             $data = DB::table('franchise_sales')
            ->join('franchise_sale_consuptions_of_menus','franchise_sale_consuptions_of_menus.sales_id', '=','franchise_sales.id')
            ->join('master_products','master_products.id', '=','franchise_sale_consuptions_of_menus.ingredient_id')
            ->where([['franchise_sales.outlet_id',Sentinel::getUser()->parent_id],['franchise_sales.del_status', 'Live'],['franchise_sales.order_status', 3]])
            ->whereBetween('sale_date', [$from, $to])
            ->select('franchise_sale_consuptions_of_menus.*','ingredient_id','master_products.product_name as ingredient_name','master_products.initial_qty as ingredient_code','master_products.franchise_rate')
            ->get()->groupBy('ingredient_id');
            elseif($outlet==0):
              $data = DB::table('franchise_sales')
            ->join('franchise_sale_consuptions_of_menus','franchise_sale_consuptions_of_menus.sales_id', '=','franchise_sales.id')
            ->join('master_products','master_products.id', '=','franchise_sale_consuptions_of_menus.ingredient_id')
            ->where([['franchise_sales.del_status', 'Live'],['franchise_sales.order_status', 3]])
            ->whereBetween('sale_date', [$from, $to])
            ->select('franchise_sale_consuptions_of_menus.*','ingredient_id','master_products.product_name as ingredient_name','master_products.initial_qty as ingredient_code','master_products.franchise_rate')
            ->get()->groupBy('ingredient_id');
         else:
            $data = DB::table('franchise_sales')
            ->join('franchise_sale_consuptions_of_menus','franchise_sale_consuptions_of_menus.sales_id', '=','franchise_sales.id')
            ->join('master_products','master_products.id', '=','franchise_sale_consuptions_of_menus.ingredient_id')
            ->where([['franchise_sales.outlet_id',$outlet],['franchise_sales.del_status', 'Live'],['franchise_sales.order_status', 3]])
            ->whereBetween('sale_date', [$from, $to])
            ->select('franchise_sale_consuptions_of_menus.*','ingredient_id','master_products.product_name as ingredient_name','master_products.initial_qty as ingredient_code','master_products.franchise_rate')
            ->get()->groupBy('ingredient_id');
            endif;

            return Datatables::of($data)
                ->addIndexColumn()
                  ->addColumn('ingredient_name', function($row){
                  
                 
                   $ingredient_name=CustomHelpers::get_master_table_data('master_products','id',$row[0]->ingredient_id,'product_name');
                   return $ingredient_name;

                
                })

                ->addColumn('qty_rate', function($row){
                  
                 $consumption=0;
                    foreach($row as $col):
                       $consumption+=$col->consumption;
                    endforeach;

                  $qty_rate=$consumption.'/'.CustomHelpers::get_master_table_data('master_products','id',$row[0]->ingredient_id,'franchise_rate');
                
                return $qty_rate;

                })
                ->addColumn('total_cost', function($row){
                
                  
               $consumption=0;
                    foreach($row as $col):
                       $consumption+=$col->consumption;
                    endforeach;
                  $total_cost=(float)$consumption*(float)CustomHelpers::get_master_table_data('master_products','id',$row[0]->ingredient_id,'franchise_rate');
                  
                return round($total_cost,2);
                })
                
                ->rawColumns(['ingredient_name','qty_rate','total_cost'])
                ->make(true);
        }
    }
    //reports
    public function pos_reports()
    {
 
         $data=DB::table('users')
         ->join('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
         ->join('brands','brands.id' , '=', 'fanchise_registrations.brands')
         ->whereIn('users.registration_level',[2,1])
         ->where([['users.status','=',7],['users.active_status','=',1]])
         ->orderBy('brands.brand') 
         ->select('users.*','fanchise_registrations.brands')  
        ->get();
          
         $regions=RegionSetting::all(); 
         $cities=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->orderBy('dist')->get()->unique('dist')->pluck('dist');
      
       
        return view('report.pos.pos_reports',compact('data','cities','regions'));
    }
    public function hourly_reports()
    {
 
         $data=DB::table('users')
         ->join('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
         ->join('brands','brands.id' , '=', 'fanchise_registrations.brands')
         ->whereIn('users.registration_level',[2,1])
         ->where([['users.status','=',7],['users.active_status','=',1]])
         ->orderBy('brands.brand') 
         ->select('users.*','fanchise_registrations.brands')  
        ->get();
          
         $regions=RegionSetting::all(); 
         $cities=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->orderBy('dist')->get()->unique('dist')->pluck('dist');
      
       

        return view('report.pos.hourly_reports',compact('data','cities','regions'));
    }
    public function get_region_wise_data(Request $request)
    {
       $region=$request->region;
       if($region==0)
       {
        $data=DB::table('users')
         ->join('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
       
         ->whereIn('users.registration_level',[2,1])
        
        
         ->select('users.*')  
        ->get();

        $cities=User::whereIn('registration_level',[2,1])->orderBy('dist')->get()->unique('dist')->pluck('dist');


       }   
       else
       {
           $region_ids=POS_SettingHelpers::get_region_ids($region);
           $data=DB::table('users')
         ->join('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
        
         ->whereIn('users.id',$region_ids)
       
        
         ->select('users.*')  
        ->get();

        $cities=User::whereIn('registration_level',[2,1])
            ->whereIn('users.id',$region_ids)->orderBy('dist')->get()->unique('dist')->pluck('dist');



       }

       $output_city='<option value="0">All</option>';
        foreach($cities as $city):
     $output_city.='<option value="'.$city.'">'.$city.'</option>';
        endforeach;

      $output_outlet='';
        foreach($data as $datas):

     $check=DB::table('franchise_sales')->where('outlet_id',$datas->id)->get();
    if(count($check)>0):
    $style='style="background:green;color:white"'; 
   else:
    $style='';
    endif;
     $output_outlet.='<option value="'.$datas->id.'" '.$style.'>'.$datas->name.'&nbsp;('.$datas->city.')&nbsp;</option>';
     endforeach;
   $output=['output_city'=>$output_city,'output_outlet'=>$output_outlet];

      return $output;
    }
    public function get_city_wise_outlet(Request $request)
    {
       $city=$request->city;
       $region=$request->region;
        if($region==0 && $city==0) 
        {
        $data=DB::table('users')
         ->join('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
        
         ->whereIn('users.registration_level',[2,1])
         
         ->select('users.*')  
        ->get();

        }
        elseif($region==0 && $city!=0)
        {
        $data=DB::table('users')
         ->join('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
         
         ->whereIn('users.registration_level',[2,1])
         ->where('users.dist','=',$city)
         
         ->select('users.*')  
        ->get();
        }
        elseif($region!=0 && $city==0)
        {
        $region_ids=POS_SettingHelpers::get_region_ids($region);

           $data=DB::table('users')
         ->join('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
         
         ->whereIn('users.id',$region_ids)
         
         ->select('users.*')  
        ->get();
        }
        elseif($region!=0 && $city!=0)
        {
          $region_ids=POS_SettingHelpers::get_region_ids($region);

           $data=DB::table('users')
         ->join('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
         
         ->whereIn('users.registration_level',[2,1])
         ->whereIn('users.id',$region_ids)
         ->where('users.dist','=',$city)
        
         ->select('users.*')  
        ->get();
        }
    
  $output='';
        foreach($data as $datas):

     $check=DB::table('franchise_sales')->where('outlet_id',$datas->id)->get();
    if(count($check)>0):
    $style='style="background:green;color:white"'; 
   else:
    $style='';
    endif;
     $output.='<option value="'.$datas->id.'" '.$style.'>'.$datas->name.'&nbsp;('.$datas->city.')&nbsp;</option>';
     endforeach;

     echo $output;
    }
    //dsr_mtd
    public function dsr_mtd()
    {
    
      

       $data=User::whereIn('registration_level',[2,1])
            ->where('status','=',7)->get();

       
        return view('report.pos.dsr_mtd',compact('data'));
    }
    public function get_hourly_data(Request $request)
    {
     $date = $request->date;
     $start_time = $request->start_time;
     $end_time = $request->end_time;
  
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
         $outlet_id= $request->outlet;
         $city= $request->city;
         $region= $request->region;
        if($region==0 && $city==0 && $outlet_id==0): 
        $ids=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 
       
       $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        $options = view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'))->render();


       echo $options;
         
        elseif($region!=0 && $city==0 && $outlet_id==0):
           
         $region_ids=POS_SettingHelpers::get_region_ids($region);  
         $ids=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$region_ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$region_ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$region_ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$region_ids;   

        $options = view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'))->render();


       echo $options;

        
           
        elseif($region==0 && $city!=0 && $outlet_id==0):

             $ids=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1],['dist','=',$city]])->get()->pluck('id'); 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        $options = view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'))->render();


       echo $options;


        elseif($region==0 && $city==0 && $outlet_id!=0):

            $ids=[$outlet_id]; 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        $options = view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'))->render();


       echo $options;

        
        elseif($region!=0 && $city!=0 && $outlet_id==0):

            $region_ids=POS_SettingHelpers::get_region_ids($region);  
             $ids=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1],['dist','=',$city]])->whereIn('id',$region_ids)->get()->pluck('id'); 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        $options = view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'))->render();


       echo $options;


            
           
         
        

        elseif($region!=0 && $city==0 && $outlet_id!=0):

            
             $ids=[$outlet_id]; 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        $options = view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'))->render();


       echo $options;



        elseif($region==0 && $city!=0 && $outlet_id!=0):

             $ids=[$outlet_id]; 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        $options = view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'))->render();


       echo $options;

           
        elseif($region!=0 && $city!=0 && $outlet_id!=0):

             $ids=[$outlet_id]; 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        $options = view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'))->render();


       echo $options;

        endif;

          
   
    else:
        $outlet_id= Sentinel::getUser()->parent_id;
   $ids=[$outlet_id]; 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        $options = view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'))->render();


       echo $options;       
    endif;
       
  
       
    }
  public function getdsr_mtd(Request $request)
    {
     $from = $request->start_date;
     $to = $request->end_date;

  
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
         $outlet_id= $request->outlet;
         $city= $request->city;
         $region= $request->region;
        if($region==0 && $city==0 && $outlet_id==0): 
        $ids=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 
       $data = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();  
  
        $void = DB::table('franchise_sales')
                  ->where([['del_status', 'Del'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();
        $heading='All region & all cities & all outlet between dates';
        $ids_second=$ids;
        $pdf=PDF::loadView('report.pos.combine.getdsr_mtd',compact('data','from','to','void','heading','ids_second'));
        return $pdf->stream('combime_DSR_MTD.pdf'); 

        elseif($region!=0 && $city==0 && $outlet_id==0):
          $region_ids=POS_SettingHelpers::get_region_ids($region);  
         $ids=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 
       $data = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->whereIn('outlet_id',$region_ids)
                 ->get();  
            
        $void = DB::table('franchise_sales')
                  ->where([['del_status', 'Del'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->whereIn('outlet_id',$region_ids)
                 ->get();
        $heading='All cities & all outlet between dates & selected region';
        $ids_second=$region_ids;
        $pdf=PDF::loadView('report.pos.combine.getdsr_mtd',compact('data','from','to','void','heading','ids_second'));
        return $pdf->stream('combime_DSR_MTD.pdf'); 
           
        elseif($region==0 && $city!=0 && $outlet_id==0):

            $ids=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1],['dist','=',$city]])->get()->pluck('id'); 

         $data = DB::table('franchise_sales')
                 ->where([['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereIn('outlet_id',$ids)
                  
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();  
            
          $void = DB::table('franchise_sales')
                 ->where([['del_status', 'Del'],['franchise_sales.order_status',3]]) 
                 ->whereIn('outlet_id',$ids)
                  
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();
             $ids_second=$ids;   
        $heading=$city.' city & all outlet between dates';
        $pdf=PDF::loadView('report.pos.combine.getdsr_mtd',compact('data','from','to','void','heading','ids_second'));
        return $pdf->stream('combime_DSR_MTD.pdf'); 

        elseif($region==0 && $city==0 && $outlet_id!=0):
            $data = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();  
            

         $void = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Del'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();
        $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);        
        $pdf=PDF::loadView('report.pos.individual.getdsr_mtd',compact('data','from','to','outlet_id','void'));
        return $pdf->stream($outlet_details->firm_name.'DSR_MTD.pdf'); 

        elseif($region!=0 && $city!=0 && $outlet_id==0):

            $region_ids=POS_SettingHelpers::get_region_ids($region);  
             $ids=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1],['dist','=',$city]])->whereIn('id',$region_ids)->get()->pluck('id'); 
           
         
           
         $data = DB::table('franchise_sales')
                 ->where([['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereIn('outlet_id',$ids)
                  
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();  
            
          $void = DB::table('franchise_sales')
                 ->where([['del_status', 'Del'],['franchise_sales.order_status',3]]) 
                 ->whereIn('outlet_id',$ids)
                  
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();
             $ids_second=$ids;   
        $heading=$city.' city & all outlet between dates';
        $pdf=PDF::loadView('report.pos.combine.getdsr_mtd',compact('data','from','to','void','heading','ids_second'));
        return $pdf->stream('combime_DSR_MTD.pdf'); 

        elseif($region!=0 && $city==0 && $outlet_id!=0):
            $data = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();  
            

         $void = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Del'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();
        $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);        
        $pdf=PDF::loadView('report.pos.individual.getdsr_mtd',compact('data','from','to','outlet_id','void'));
        return $pdf->stream($outlet_details->firm_name.'DSR_MTD.pdf'); 

        elseif($region==0 && $city!=0 && $outlet_id!=0):
            $data = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();  
            

         $void = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Del'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();
        $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);        
        $pdf=PDF::loadView('report.pos.individual.getdsr_mtd',compact('data','from','to','outlet_id','void'));
        return $pdf->stream($outlet_details->firm_name.'DSR_MTD.pdf'); 
        elseif($region!=0 && $city!=0 && $outlet_id!=0):

            $data = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();  
            

         $void = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Del'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('franchise_sales.sale_date', [$from, $to])
                 ->get();
        $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);        
        $pdf=PDF::loadView('report.pos.individual.getdsr_mtd',compact('data','from','to','outlet_id','void'));
        return $pdf->stream($outlet_details->firm_name.'DSR_MTD.pdf'); 

        endif;

          
   
    else:
        $outlet_id= Sentinel::getUser()->parent_id;
   $data = DB::table('franchise_sales')
                ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                ->whereBetween('franchise_sales.sale_date', [$from, $to])
                ->get();  
    $void = DB::table('franchise_sales')
                ->where([['outlet_id',$outlet_id],['del_status', 'Del'],['franchise_sales.order_status',3]]) 
                ->whereBetween('franchise_sales.sale_date', [$from, $to])
                ->get();             
    
    $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);        
    $pdf=PDF::loadView('report.pos.individual.getdsr_mtd',compact('data','from','to','outlet_id','void'));
      return $pdf->stream($outlet_details->firm_name.'DSR_MTD.pdf');           
    endif;
       
     // $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
     // return view('report.pos.getdsr_mtd',compact('data','from','to','outlet_id','void'));
   //  $pdf=PDF::loadView('report.pos.getdsr_mtd',compact('data','from','to','outlet_id','void'));
   // return $pdf->stream($outlet_details->firm_name.'DSR_MTD.pdf');
    // $path = public_path('uploads/get_sale_report/');
    //     $fileName =  time().'.'. 'pdf' ;
    //     $pdf->save($path . '/' . $fileName);

    //     $pdf = public_path('uploads/get_sale_report/'.$fileName);
    //     return response()->download($pdf);
       
    }
    //dsr_rsc_mtd
    public function dsr_rsc_mtd()
    {
    
       $data=User::whereIn('registration_level',[2,1])
            ->where('status','=',7)->get();

         $to = '2022-10-31';
         $from = '2022-10-31';

       
        return view('report.pos.dsr_rsc_mtd',compact('data'));
    }
    public function download_hourly_report(Request $request)
    {
     $date = $request->date;
     $start_time = $request->start_time;
     $end_time = $request->end_time;
     $city= $request->city;
     $region= $request->region;
     if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
        $outlet_id= $request->outlet;
       

        if($region==0 && $city==0 && $outlet_id==0): 
         return Excel::download(new HourlyReport($region,$date,$start_time,$end_time,$outlet_id,$city), 'Combine_hourly_date_'.$date.'_time_'.$start_time.'_to_'.$end_time.'_'.'.xlsx');
        elseif($region!=0 && $city==0 && $outlet_id==0):
            return Excel::download(new HourlyReport($region,$date,$start_time,$end_time,$outlet_id,$city), 'Combine_hourly_date_'.$date.'_time_'.$start_time.'_to_'.$end_time.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id==0):
            return Excel::download(new HourlyReport($region,$date,$start_time,$end_time,$outlet_id,$city), 'Combine_hourly_date_'.$date.'_time_'.$start_time.'_to_'.$end_time.'_'.'.xlsx');
        elseif($region==0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new HourlyReport($region,$date,$start_time,$end_time,$outlet_id,$city), $outlet_details->firm_name.'_hourly_date_'.$date.'_time_'.$start_time.'_to_'.$end_time.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id==0):
            return Excel::download(new HourlyReport($region,$date,$start_time,$end_time,$outlet_id,$city), 'Combine_hourly_date_'.$date.'_time_'.$start_time.'_to_'.$end_time.'_'.'.xlsx');
        elseif($region!=0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new HourlyReport($region,$date,$start_time,$end_time,$outlet_id,$city), $outlet_details->firm_name.'_hourly_date_'.$date.'_time_'.$start_time.'_to_'.$end_time.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new HourlyReport($region,$date,$start_time,$end_time,$outlet_id,$city), $outlet_details->firm_name.'_hourly_date_'.$date.'_time_'.$start_time.'_to_'.$end_time.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new HourlyReport($region,$date,$start_time,$end_time,$outlet_id,$city), $outlet_details->firm_name.'_hourly_date_'.$date.'_time_'.$start_time.'_to_'.$end_time.'_'.'.xlsx');
        endif;

   
     else:
      $outlet_id= Sentinel::getUser()->parent_id;       
      $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new HourlyReport($region,$date,$start_time,$end_time,$outlet_id,$city), $outlet_details->firm_name.'_hourly_date_'.$date.'_time_'.$start_time.'_to_'.$end_time.'_'.'.xlsx');
     endif;
       
  
       
    }

    public function getdsr_rsc_mtd(Request $request)
    {
     $from = $request->start_date;
     $to = $request->end_date;
    $city= $request->city;
    $region= $request->region;
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
        $outlet_id= $request->outlet;
       

        if($region==0 && $city==0 && $outlet_id==0): 

         return Excel::download(new ExportDsrRscMtd($region,$from,$to,$outlet_id,$city), 'Combine_DSR_RSC_MTD_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city==0 && $outlet_id==0):
            return Excel::download(new ExportDsrRscMtd($region,$from,$to,$outlet_id,$city), 'Combine_DSR_RSC_MTD_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id==0):
            return Excel::download(new ExportDsrRscMtd($region,$from,$to,$outlet_id,$city), 'Combine_DSR_RSC_MTD_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ExportDsrRscMtd($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'DSR_RSC_MTD_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id==0):
            return Excel::download(new ExportDsrRscMtd($region,$from,$to,$outlet_id,$city), 'Combine_DSR_RSC_MTD_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ExportDsrRscMtd($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'DSR_RSC_MTD_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ExportDsrRscMtd($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'DSR_RSC_MTD_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ExportDsrRscMtd($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'DSR_RSC_MTD_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        endif;


        
     else:
      $outlet_id= Sentinel::getUser()->parent_id;       
      $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ExportDsrRscMtd($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'DSR_RSC_MTD_from_'.$from.'_to_'.$to.'_'.'.xlsx');
     endif;
   
    
       
    }
     public function get_item_wise_sale_details(Request $request)
    {
     $from = $request->start_date;
     $to = $request->end_date;
    $city= $request->city;
    $region= $request->region;
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
        $outlet_id= $request->outlet;
       

        if($region==0 && $city==0 && $outlet_id==0): 
         return Excel::download(new ItemWiseSaleDetails($region,$from,$to,$outlet_id,$city), 'Combine_item_wise_sale_details_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city==0 && $outlet_id==0):
            return Excel::download(new ItemWiseSaleDetails($region,$from,$to,$outlet_id,$city), 'Combine_item_wise_sale_details_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id==0):
            return Excel::download(new ItemWiseSaleDetails($region,$from,$to,$outlet_id,$city), 'Combine_item_wise_sale_details_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ItemWiseSaleDetails($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_item_wise_sale_details_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id==0):
            return Excel::download(new ItemWiseSaleDetails($region,$from,$to,$outlet_id,$city), 'Combine_item_wise_sale_details_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ItemWiseSaleDetails($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_item_wise_sale_details_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ItemWiseSaleDetails($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_item_wise_sale_details_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ItemWiseSaleDetails($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_item_wise_sale_details_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        endif;

   
     else:
      $outlet_id= Sentinel::getUser()->parent_id;       
      $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ItemWiseSaleDetails($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_item_wise_sale_details_from_'.$from.'_to_'.$to.'_'.'.xlsx');
     endif;
   
    
       
    }
    public function get_menu_mix(Request $request)
    {
     $from = $request->start_date;
     $to = $request->end_date;
    $city= $request->city;
    $region= $request->region;
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
        $outlet_id= $request->outlet;
       

        if($region==0 && $city==0 && $outlet_id==0): 
         return Excel::download(new MenuMix($region,$from,$to,$outlet_id,$city), 'Combine_menu_mix_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city==0 && $outlet_id==0):
            return Excel::download(new MenuMix($region,$from,$to,$outlet_id,$city), 'Combine_menu_mix_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id==0):
            return Excel::download(new MenuMix($region,$from,$to,$outlet_id,$city), 'Combine_menu_mix_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new MenuMix($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_menu_mix_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id==0):
            return Excel::download(new MenuMix($region,$from,$to,$outlet_id,$city), 'Combine_menu_mix_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new MenuMix($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_menu_mix_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new MenuMix($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_menu_mix_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new MenuMix($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_menu_mix_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        endif;

   
     else:
      $outlet_id= Sentinel::getUser()->parent_id;       
      $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new MenuMix($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_menu_mix_from_'.$from.'_to_'.$to.'_'.'.xlsx');
     endif;
   
    
       
    }
    public function get_item_wise_transection(Request $request)
    {
     $from = $request->start_date;
     $to = $request->end_date;
    $city= $request->city;
    $region= $request->region;
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
        $outlet_id= $request->outlet;
       

        if($region==0 && $city==0 && $outlet_id==0): 
         return Excel::download(new ItemWiseTransectionRegister($region,$from,$to,$outlet_id,$city), 'Combine_item_wise_transection_register_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city==0 && $outlet_id==0):
            return Excel::download(new ItemWiseTransectionRegister($region,$from,$to,$outlet_id,$city), 'Combine_item_wise_transection_register_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id==0):
            return Excel::download(new ItemWiseTransectionRegister($region,$from,$to,$outlet_id,$city), 'Combine_item_wise_transection_register_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ItemWiseTransectionRegister($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_item_wise_transection_register_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id==0):
            return Excel::download(new ItemWiseTransectionRegister($region,$from,$to,$outlet_id,$city), 'Combine_item_wise_transection_register_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ItemWiseTransectionRegister($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_item_wise_transection_register_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ItemWiseTransectionRegister($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_item_wise_transection_register_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ItemWiseTransectionRegister($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_item_wise_transection_register_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        endif;

   
     else:
      $outlet_id= Sentinel::getUser()->parent_id;       
      $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new ItemWiseTransectionRegister($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_item_wise_transection_register_from_'.$from.'_to_'.$to.'_'.'.xlsx');
     endif;
   
    
       
    }
    public function getall_restaurants_sales_summary(Request $request)
    {
     $from = $request->start_date;
     $to = $request->end_date;
     $city= $request->city;
     $region= $request->region;
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
        $outlet_id= $request->outlet;
      
    return Excel::download(new AllRestaurantsSalesSummary($region,$from,$to,$outlet_id,$city), 'AllRestaurantsSalesSummary'.$from.'_to_'.$to.'_'.'.xlsx');
     
     endif;
   
    }
    public function getoutlet_customers(Request $request)
    {
     $from = $request->start_date;
     $to = $request->end_date;
    $city= $request->city;
    $region= $request->region;
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
        $outlet_id= $request->outlet;


         if($region==0 && $city==0 && $outlet_id==0): 
          return Excel::download(new OutletCustomers($region,$from,$to,$outlet_id,$city), 'Combine_outlet_customer_'.$from.'_to_'.$to.'_'.'.xlsx'); 
        elseif($region!=0 && $city==0 && $outlet_id==0):
            return Excel::download(new OutletCustomers($region,$from,$to,$outlet_id,$city), 'Combine_outlet_customer_'.$from.'_to_'.$to.'_'.'.xlsx'); 
        elseif($region==0 && $city!=0 && $outlet_id==0):
            return Excel::download(new OutletCustomers($region,$from,$to,$outlet_id,$city), 'Combine_outlet_customer_'.$from.'_to_'.$to.'_'.'.xlsx'); 
        elseif($region==0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new OutletCustomers($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_customer_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id==0):
            return Excel::download(new OutletCustomers($region,$from,$to,$outlet_id,$city), 'Combine_outlet_customer_'.$from.'_to_'.$to.'_'.'.xlsx'); 
        elseif($region!=0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new OutletCustomers($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_customer_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new OutletCustomers($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_customer_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new OutletCustomers($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_customer_'.$from.'_to_'.$to.'_'.'.xlsx');
        endif;


     else:
      $outlet_id= Sentinel::getUser()->parent_id;       
      $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new OutletCustomers($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_customer_'.$from.'_to_'.$to.'_'.'.xlsx');
     endif;
   
    
       
    }
     public function get_bill_wise_report(Request $request)
    {
     $from = $request->start_date;
     $to = $request->end_date;
    $city= $request->city;
    $region= $request->region;
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
        $outlet_id= $request->outlet;


         if($region==0 && $city==0 && $outlet_id==0): 
          return Excel::download(new BillWiseReport($region,$from,$to,$outlet_id,$city), 'Combine_outlet_bill_wise_'.$from.'_to_'.$to.'_'.'.xlsx'); 
        elseif($region!=0 && $city==0 && $outlet_id==0):
            return Excel::download(new BillWiseReport($region,$from,$to,$outlet_id,$city), 'Combine_outlet_bill_wise_'.$from.'_to_'.$to.'_'.'.xlsx'); 
        elseif($region==0 && $city!=0 && $outlet_id==0):
            return Excel::download(new BillWiseReport($region,$from,$to,$outlet_id,$city), 'Combine_outlet_bill_wise_'.$from.'_to_'.$to.'_'.'.xlsx'); 
        elseif($region==0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new BillWiseReport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_bill_wise_report_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id==0):
            return Excel::download(new BillWiseReport($region,$from,$to,$outlet_id,$city), 'Combine_outlet_bill_wise_'.$from.'_to_'.$to.'_'.'.xlsx'); 
        elseif($region!=0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new BillWiseReport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_bill_wise_report_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new BillWiseReport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_bill_wise_report_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new BillWiseReport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_bill_wise_report_'.$from.'_to_'.$to.'_'.'.xlsx');
        endif;


     else:
      $outlet_id= Sentinel::getUser()->parent_id;       
      $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new BillWiseReport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_bill_wise_report_'.$from.'_to_'.$to.'_'.'.xlsx');
     endif;
   
    
       
    }
   public function get_void_report(Request $request)
    {
     $from = $request->start_date;
     $to = $request->end_date;
    $city= $request->city;
    $region= $request->region;
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
        $outlet_id= $request->outlet;


         if($region==0 && $city==0 && $outlet_id==0): 
          return Excel::download(new VoidExport($region,$from,$to,$outlet_id,$city), 'Combine_outlet_void_report_'.$from.'_to_'.$to.'_'.'.xlsx'); 
        elseif($region!=0 && $city==0 && $outlet_id==0):
            return Excel::download(new VoidExport($region,$from,$to,$outlet_id,$city), 'Combine_outlet_void_report_'.$from.'_to_'.$to.'_'.'.xlsx'); 
        elseif($region==0 && $city!=0 && $outlet_id==0):
            return Excel::download(new VoidExport($region,$from,$to,$outlet_id,$city), 'Combine_outlet_void_report_'.$from.'_to_'.$to.'_'.'.xlsx'); 
        elseif($region==0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new VoidExport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_bill_void_report_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id==0):
            return Excel::download(new VoidExport($region,$from,$to,$outlet_id,$city), 'Combine_outlet_void_report_'.$from.'_to_'.$to.'_'.'.xlsx'); 
        elseif($region!=0 && $city==0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new VoidExport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_bill_void_report_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new VoidExport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_bill_void_report_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id!=0):
            $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new VoidExport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_bill_void_report_'.$from.'_to_'.$to.'_'.'.xlsx');
        endif;


     else:
      $outlet_id= Sentinel::getUser()->parent_id;       
      $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new VoidExport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_bill_void_report_'.$from.'_to_'.$to.'_'.'.xlsx');
     endif;
   
    
       
    }

   public function get_inventory_valuation(Request $request)
    {
     $from = $request->start_date;
     $to = $request->end_date;
    $city= $request->city;
    $region= $request->region;
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
        $outlet_id= $request->outlet;

     $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
     return Excel::download(new InventoryValuation($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_inventory_valuation_report_'.$from.'_to_'.$to.'_'.'.xlsx');

     else:
      $outlet_id= Sentinel::getUser()->parent_id;       
      $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new InventoryValuation($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'_inventory_valuation_report_'.$from.'_to_'.$to.'_'.'.xlsx');
     endif;
   
    
       
    }
    
    public function get_discount_summary(Request $request)
    {
     $from = $request->start_date;
     $to = $request->end_date;
    $city= $request->city;
     $region= $request->region; 
     
  
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
        $outlet_id= $request->outlet;
      
    return Excel::download(new DiscountSummaryExport($region,$from,$to,$outlet_id,$city), 'Combine_discount_summary_'.$from.'_to_'.$to.'_'.'.xlsx');
     
     endif;

       
    }
    public function get_detail_discount(Request $request)
    {
     $from = $request->start_date;
     $to = $request->end_date;
    $city= $request->city;
    $region= $request->region; 
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
        $outlet_id= $request->outlet;


         if($region==0 && $city==0 && $outlet_id==0): 

        return Excel::download(new DetailDiscountReport($region,$from,$to,$outlet_id,$city), 'Combine_Detail_discount_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city==0 && $outlet_id==0):

        return Excel::download(new DetailDiscountReport($region,$from,$to,$outlet_id,$city), 'Combine_Detail_discount_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id==0):

        return Excel::download(new DetailDiscountReport($region,$from,$to,$outlet_id,$city), 'Combine_Detail_discount_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city==0 && $outlet_id!=0):

        $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new DetailDiscountReport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'Detail_discount_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id==0):
        return Excel::download(new DetailDiscountReport($region,$from,$to,$outlet_id,$city), 'Combine_Detail_discount_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city==0 && $outlet_id!=0):
             $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
         return Excel::download(new DetailDiscountReport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'Detail_discount_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region==0 && $city!=0 && $outlet_id!=0):

             $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
         return Excel::download(new DetailDiscountReport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'Detail_discount_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        elseif($region!=0 && $city!=0 && $outlet_id!=0):
             $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
         return Excel::download(new DetailDiscountReport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'Detail_discount_from_'.$from.'_to_'.$to.'_'.'.xlsx');
        endif;

        
     else:
      $outlet_id= Sentinel::getUser()->parent_id;       
      $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
    return Excel::download(new DetailDiscountReport($region,$from,$to,$outlet_id,$city), $outlet_details->firm_name.'Detail_discount_from_'.$from.'_to_'.$to.'_'.'.xlsx');
     endif;
   
    
       
    }
    public function get_sale_report(Request $request)
    {
    // $data=JobVaccency::find($id);
    // return view('user.apply.cv',compact('data'));
    $from = $request->start_date;
    $to = $request->end_date;

    // $data = DB::table('franchise_sales_details')
    //         ->leftJoin('franchise_sales','franchise_sales.id', '=','franchise_sales_details.sales_id')
    //         ->leftJoin('food_menus','food_menus.id', '=','franchise_sales_details.food_menu_id')
    //         ->where([['franchise_sales_details.outlet_id',Sentinel::getUser()->parent_id],['franchise_sales_details.del_status', 'Live']])
    //         ->whereBetween('sale_date', [$from, $to])
    //         ->select('food_menu_id','menu_name','code','sale_date')
    //         ->get()->groupBy('food_menu_id'); 
    if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
         $outlet_id= $request->outlet;
        $data = DB::table('franchise_sales_details')
            ->leftJoin('franchise_sales','franchise_sales.id', '=','franchise_sales_details.sales_id')
            ->leftJoin('food_menus','food_menus.id', '=','franchise_sales_details.food_menu_id')
            ->where([['franchise_sales_details.outlet_id',$outlet_id],['franchise_sales_details.del_status', 'Live'],['franchise_sales.del_status', 'Live'],['franchise_sales.order_status',3]])
                 
            ->whereBetween('franchise_sales.sale_date', [$from, $to])
           
            ->select('food_menu_id','menu_name','code','sale_date','franchise_sales.id as sale_id','franchise_sales_details.id as franchise_sales_details_id','franchise_sales_details.qty as qty')
            ->get()->groupBy('food_menu_id'); 


    else:
        $outlet_id= Sentinel::getUser()->parent_id;
    $data = DB::table('franchise_sales_details')
            ->leftJoin('franchise_sales','franchise_sales.id', '=','franchise_sales_details.sales_id')
            ->leftJoin('food_menus','food_menus.id', '=','franchise_sales_details.food_menu_id')
            ->where([['franchise_sales_details.outlet_id',$outlet_id],['franchise_sales_details.del_status', 'Live'],['franchise_sales.del_status', 'Live'],['franchise_sales.order_status',3]])
            ->whereBetween('franchise_sales.sale_date', [$from, $to])
           
            ->select('food_menu_id','menu_name','code','sale_date','franchise_sales.id as sale_id','franchise_sales_details.id as franchise_sales_details_id','franchise_sales_details.qty as qty')
            ->get()->groupBy('food_menu_id'); 
    endif;
       
            
     // return view('report.pos.get_sale_report',compact('data','from','to','outlet_id'));
    $pdf=PDF::loadView('report.pos.get_sale_report',compact('data','from','to','outlet_id'));

    $path = public_path('uploads/get_sale_report/');
        $fileName =  time().'.'. 'pdf' ;
        $pdf->save($path . '/' . $fileName);

        $pdf = public_path('uploads/get_sale_report/'.$fileName);
        return response()->download($pdf);
    }
    //foodmenusales 
    public function foodmenusales()
    {
    
       $data=User::whereIn('registration_level',[2,1])
            ->where('status','=',7)->get();

         $to = '2022-10-31';
         $from = '2022-10-31';

        //  $data2 = DB::table('franchise_sales_details')
        //     ->leftJoin('franchise_sales','franchise_sales.id', '=','franchise_sales_details.sales_id')
        //     ->leftJoin('food_menus','food_menus.id', '=','franchise_sales_details.food_menu_id')
        //     ->where([['franchise_sales_details.outlet_id',Sentinel::getUser()->parent_id],['franchise_sales_details.del_status', 'Live']])
        //     ->whereBetween('sale_date', [$from, $to])
        //     ->select('food_menu_id','menu_name','code','sale_date')
        //     ->get()->groupBy('food_menu_id');   
        // dd($data2);
           // $data = DB::table('franchise_sales_details')
           //  ->leftJoin('franchise_sales','franchise_sales.id', '=','franchise_sales_details.sales_id')
           //  ->leftJoin('food_menus','food_menus.id', '=','franchise_sales_details.food_menu_id')
           //  ->where([['franchise_sales_details.outlet_id',Sentinel::getUser()->parent_id],['franchise_sales_details.del_status', 'Live']])
           //  ->whereBetween('franchise_sales.sale_date', [$from, $to])

           //  ->select('food_menu_id','menu_name','code','sale_date','franchise_sales.id as sale_id','franchise_sales_details.id as franchise_sales_details_id','franchise_sales_details.qty as qty')
           //  ->get()->groupBy('food_menu_id'); 
           //  return view('report.pos.get_sale_report',compact('data','from','to'));
// dd($data);
        return view('report.pos.foodmenusales',compact('data'));
    }
   public function getfoodmenusales(Request $request)
    {
        if ($request->ajax()) {

          
             $from = $request->start_date;
             $to = $request->end_date;
             $outlet= $request->outlet;
             if($outlet=='NA'):
                $data = DB::table('franchise_sales_details')
            ->leftJoin('franchise_sales','franchise_sales.id', '=','franchise_sales_details.sales_id')
            ->leftJoin('food_menus','food_menus.id', '=','franchise_sales_details.food_menu_id')
            ->where([['franchise_sales_details.outlet_id',Sentinel::getUser()->parent_id],['franchise_sales_details.del_status', 'Live'],['franchise_sales.del_status', 'Live'],['franchise_sales.order_status',3]])
            ->whereBetween('sale_date', [$from, $to])
            ->select('food_menu_id','menu_name','code','sale_date','franchise_sales.id as sale_id','franchise_sales_details.id as franchise_sales_details_id','franchise_sales_details.qty as qty')
            
            ->get()->groupBy('food_menu_id');  

             
            elseif($outlet==0):
                $data = DB::table('franchise_sales_details')
            ->leftJoin('franchise_sales','franchise_sales.id', '=','franchise_sales_details.sales_id')
            ->leftJoin('food_menus','food_menus.id', '=','franchise_sales_details.food_menu_id')
            ->where([['franchise_sales_details.del_status', 'Live'],['franchise_sales.del_status', 'Live'],['franchise_sales.order_status',3]])
            ->whereBetween('sale_date', [$from, $to])
            ->select('food_menu_id','menu_name','code','sale_date','franchise_sales.id as sale_id','franchise_sales_details.id as franchise_sales_details_id','franchise_sales_details.qty as qty')
            ->get()->groupBy('food_menu_id'); 

            
         else:
              $data = DB::table('franchise_sales_details')
            ->leftJoin('franchise_sales','franchise_sales.id', '=','franchise_sales_details.sales_id')
            ->leftJoin('food_menus','food_menus.id', '=','franchise_sales_details.food_menu_id')
            ->where([['franchise_sales_details.outlet_id',$outlet],['franchise_sales_details.del_status', 'Live'],['franchise_sales.del_status', 'Live'],['franchise_sales.order_status',3]])
            ->whereBetween('sale_date', [$from, $to])
            ->select('food_menu_id','menu_name','code','sale_date','franchise_sales.id as sale_id','franchise_sales_details.id as franchise_sales_details_id','franchise_sales_details.qty as qty')
            ->get()->groupBy('food_menu_id'); 

            
            endif;

            return Datatables::of($data)
                ->addIndexColumn()
                  ->addColumn('code', function($row){
                   $code=$row[0]->code;
                   return $code;

                
                })

                ->addColumn('food_menu', function($row){
                     $food_menu=$row[0]->menu_name;
                
                return $food_menu;
                })
                ->addColumn('qty', function($row){
                  $qty=0;
                  foreach($row as $c)
                   {
                   $qty=(int)$qty+(int)$c->qty;
                   }
                  
                return $qty;
                })
                
                ->rawColumns(['code','food_menu','qty'])
                ->make(true);
        }
    }
    
    public function outlet_menu_price()
    {
    
       $data=User::whereIn('registration_level',[2,1])
            ->where('status','=',7)->get();

        return view('report.pos.individual_outlet_menu_price',compact('data'));
    }
    public function getoutletmenuprice(Request $request)
    {
        
        $outlet_id= $request->outlet;
        $outlet_brand_id=POS_SettingHelpers::get_brand_by_admin_id($outlet_id);
       

        $outlet_brand_id=POS_SettingHelpers::get_brand_by_admin_id($outlet_id);
        $update_pre_pos_data = POS_SettingHelpers::update_pre_pos_data($outlet_id,$outlet_brand_id);


       
   $update_menues = POS_SettingHelpers::update_outlet_menues($outlet_id,$outlet_brand_id);         
$data=DB::table('franchise_food_menu_prices')->where("outlet_id", $outlet_id)->get()->groupBy('category_id');

           

           

            return Datatables::of($data)
                ->addIndexColumn()
                  ->addColumn('category', function($row){
                   $category_id=$row[0]->category_id;


                   if($category_id!='' && $category_id!=0):
$category_name=CustomHelpers::get_master_table_data('food_menu_categories','id',$category_id,'category_name');
                   else:
           $category_name='Not Assigned Category';     
                   endif;
                   return $category_name;

                
                })
->addColumn('outlet_details', function($row){
                   $outlet_id=$row[0]->outlet_id;
$rows_data=User::find($outlet_id);
$outlet_details="<b>ID:</b> $rows_data->email
                 <hr>
                 <b>Name:</b> $rows_data->name
                 <hr>
                 <b>Mobile:</b> $rows_data->mobile
                 <hr>
                <b>State:</b> $rows_data->state
                             <hr>
                             <b>City:</b> $rows_data->city";

                return $outlet_details;
                })
                ->addColumn('price', function($row){
                    $category_id=$row[0]->category_id;
                    $output='<table class="table table-bordered">
 <thead>
    <tr>
      <th>Menu Name</th>

      <th>Brand Sale Price</th>
      <th>Brand GST</th>
      
      <th>Outlet Sale Price</th>
      <th>Outlet GST</th>
    </tr>
  </thead>
    <tbody>';
     $j=0;
                     if($category_id!='' && $category_id!=0):

// $menues=DB::table('franchise_food_menu_prices')->where([['outlet_id','=',(int)$row[0]->outlet_id],['category_id','=',$category_id]])->get();
$outlet_brand_id=POS_SettingHelpers::get_brand_by_admin_id((int)$row[0]->outlet_id);

$menues=DB::table('franchise_food_menu_prices')->where([['outlet_id','=',(int)$row[0]->outlet_id],['category_id','=',$category_id]])->get();

   foreach($menues as $menu):
  
        $menu_name=CustomHelpers::get_master_table_data('food_menus','id',$menu->food_menu_id,'name');
        $menu_sale_price=CustomHelpers::get_master_table_data('food_menus','id',$menu->food_menu_id,'sale_price');
        $menu_tax=CustomHelpers::get_master_table_data('food_menus','id',$menu->food_menu_id,'tax_information');
        $outlet_id =$menu->outlet_id;
                $tax=POS_SettingHelpers::get_franchise_tax($menu->food_menu_id,$outlet_id);
                if($tax==0)
                {
               
                $gst=0;                
               }
                else
                {
                $gst_data=json_decode($tax);
                $gst_id=$gst_data[0]->tax_field_id;  
                $gst_data=MasterGst::find($gst_id);
               if($gst_data!='')
               {
               $gst=$gst_data->gst_name;
               }
               else
               {
               $gst='Not Updated';
               }
         }
         if($menu_tax==0 || $menu_tax=='')
                {
               
                $menu_gst=0;                
               }
                else
                {
                $menu_gst_data=json_decode($menu_tax);

                if(is_array($menu_gst_data)):
                $menu_gst_id=$menu_gst_data[0]->tax_field_id;  
                $menu_gst_data=MasterGst::find(3);
               if($menu_gst_data!='')
               {
               $menu_gst=$menu_gst_data->gst_name;
               }
               else
               {
               $menu_gst='Not Updated';
               }
           else:
            $menu_gst=0;     
           endif;
         }

          if($menu_name!='NA'):
            $j++;
            if($gst!=$menu_gst):
                $gst_backgroundcolor='#8b8b3d';
                $gst_color='white';
            else:
                $gst_backgroundcolor='white';
                $gst_color='black';
            endif;
            if($menu->sale_price!=$menu_sale_price):
                $menu_backgroundcolor='#f3f380';
                $menu_color='black';
            else:
                $menu_backgroundcolor='white';
                $menu_color='black';
            endif;
      $output.='<tr style="">
        <td style="padding:1px">'.$j.'.'.$menu_name.'</td>
       
      
        
        <td style="padding:1px;">
            '.$menu_sale_price.'
        </td>
       <td style="padding:1px;">
            '.$menu_gst.'
        </td>
         <td style="padding:1px;background:'.$menu_backgroundcolor.';color:'.$menu_color.'">
            '.$menu->sale_price.'
        </td>
         <td style="padding:1px;background:'.$gst_backgroundcolor.';color:'.$gst_color.'">
            '.$gst.'
        </td>
      </tr>';
       endif;
       endforeach;

                   else:
           
$outlet_brand_id=POS_SettingHelpers::get_brand_by_admin_id((int)$row[0]->outlet_id);
 $menues=DB::table('franchise_food_menu_prices')->where([['outlet_id','=',(int)$row[0]->outlet_id],['category_id','=',$category_id]])->get();
   foreach($menues as $menu):
   
        $menu_name=CustomHelpers::get_master_table_data('food_menus','id',$menu->food_menu_id,'name');
      $menu_sale_price=CustomHelpers::get_master_table_data('food_menus','id',$menu->food_menu_id,'sale_price');
        $menu_tax=CustomHelpers::get_master_table_data('food_menus','id',$menu->food_menu_id,'tax_information');

        $outlet_id =$menu->outlet_id;
                $tax=POS_SettingHelpers::get_franchise_tax($menu->food_menu_id,$outlet_id);
                if($tax==0)
                {
               
                $gst=0;                
               }
                else
                {
                $gst_data=json_decode($menu_tax);
                $gst_id=$gst_data[0]->tax_field_id;  
                $gst_data=MasterGst::find($gst_id);
               if($gst_data!='')
               {
               $gst=$gst_data->gst_name;
               }
               else
               {
               $gst='Not Updated';
               }
         }
         if($menu_tax==0 || $menu_tax=='')
                {
               
                $menu_gst=0;                
               }
                else
                {
                $menu_gst_data=json_decode($menu_tax);

                if(is_array($menu_gst_data)):
                $menu_gst_id=$menu_gst_data[0]->tax_field_id;  
                $menu_gst_data=MasterGst::find(3);
               if($menu_gst_data!='')
               {
               $menu_gst=$menu_gst_data->gst_name;
               }
               else
               {
               $menu_gst='Not Updated';
               }
           else:
            $menu_gst=0;     
           endif;
         }
         if($menu_name!='NA'):
            $j++;
     if($gst!=$menu_gst):
                $gst_backgroundcolor='#8b8b3d';
                $gst_color='white';
            else:
                $gst_backgroundcolor='white';
                $gst_color='black';
            endif;
            if($menu->sale_price!=$menu_sale_price):
                $menu_backgroundcolor='#f3f380';
                $menu_color='black';
            else:
                $menu_backgroundcolor='white';
                $menu_color='black';
            endif;
      $output.='<tr style="">
        <td style="padding:1px">'.$j.'.'.$menu_name.'</td>
       
      
        
        <td style="padding:1px;">
            '.$menu_sale_price.'
        </td>
       <td style="padding:1px;">
            '.$menu_gst.'
        </td>
         <td style="padding:1px;background:'.$menu_backgroundcolor.';color:'.$menu_color.'">
            '.$menu->sale_price.'
        </td>
         <td style="padding:1px;background:'.$gst_backgroundcolor.';color:'.$gst_color.'">
            '.$gst.'
        </td>
      </tr>';
       endif;
       endforeach;
                   endif;
                $output.='</tbody>
  </table>
 
        ';
                return $output;
                })
             
                
                ->rawColumns(['category','price','outlet_details'])
                ->make(true);
    }
} 

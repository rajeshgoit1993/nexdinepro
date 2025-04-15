<?php

namespace App\Http\Controllers;

use App\Models\Waste;
use App\Models\WasteIngredient;
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
use App\Models\AssignFoodMenuToBrands;
use Carbon\Carbon;
use Redirect;
use App\Models\DailyPurchase;
use App\Models\DailyPurchaseIngredients;
use App\Models\FranchiseStockSalePrice;


class WasteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

     // $outlet_id_by_stocks=DB::table('franchise_stock_sale_prices')->distinct()->pluck('outlet_id');
     // foreach($outlet_id_by_stocks as $outlet_ids)
     // {
     //  $outlets_products=DB::table('franchise_stock_sale_prices')->where('outlet_id',$outlet_ids)->get();
     //  foreach($outlets_products as $products)
     //  {
     //    $product_id=$products->product_id;

     //    $consuption_sum=DB::table('franchise_sale_consuptions_of_menus')
     //     ->where([['outlet_id',(int)$outlet_ids],['ingredient_id',(int)$product_id],['sync_status',0]])->sum('consumption');
          
     //   $waste_sum=DB::table('waste_ingredients')
         
     //       ->where([['outlet_id',(int)$outlet_ids],['ingredient_id',(int)$product_id],['sync_status',0]])->sum('waste_amount');
     //   $total_waste=(float)$consuption_sum+(float)$waste_sum;


     //   $outlet_stock = FranchiseStockSalePrice::where([['outlet_id','=',(int)$outlet_ids],['product_id',$product_id]])->first();
     //     if($outlet_stock!='')
     //     {
     //     if($outlet_stock->available_qty!='')
     //     {
     //      $available_qty=$outlet_stock->available_qty;
     //     }
     //     else
     //     {
     //       $available_qty=0;
     //     }
         
     //     $sum=(float)$available_qty-(float)$total_waste;
     //     $outlet_stock->available_qty=$sum;
     //     $outlet_stock->save();
     //     }
         
     //   FranchiseSaleConsuptionsOfMenu::where([['outlet_id',(int)$outlet_ids],['ingredient_id',(int)$product_id],['sync_status',0]])->update(['sync_status' => 1]);
     //   WasteIngredient::where([['outlet_id',(int)$outlet_ids],['ingredient_id',(int)$product_id],['sync_status',0]])->update(['sync_status' => 1]);

     //  }
      
     // }
     
    return view('outlet.waste.index'); 
    }
  public function add_food_menu_waste()
    {
    $outlet_id =Sentinel::getUser()->parent_id;
    //
    $data_food_menu =  POS_SettingHelpers::getAllFoodMenus();
    return view('outlet.waste.add_food_menu_waste',compact('data_food_menu'));   
    }
    public function store_food_menu_waste(Request $request)
    {
    $purchase_ingredients=$request->ingredient_id;
    if($purchase_ingredients=='')
    {
     return Redirect::back()->with('error', 'Pls select Food Menu');     
    }
      $outlet_id =Sentinel::getUser()->parent_id;
     
       try
        {
     DB::beginTransaction();
     $data['date'] = $request->date;
     $data['remarks'] = $request->remarks;
     $data['outlet_id'] =$outlet_id;
     $data['loss_type'] =1;
    
     $query=Waste::create($data);
    
     
      $loss_amt=0;
     
        $purchase_ingredients=$request->ingredient_id;
       foreach ($purchase_ingredients as $row => $ingredient_id):

           $qty=$request->quantity_amount[$row];
           $food_menu_id=$request->ingredient_id[$row]; 
           $assigned_ingredients=DB::table('assign_food_menu_ingredients')->where('food_menu_id',$food_menu_id)->get();
           foreach($assigned_ingredients as $assigned_ingredient)
           {

           $new_data['ingredient_id'] = $assigned_ingredient->ingredient_id; 
           $new_data['waste_id'] = $query->id; 
           $new_data['outlet_id'] = $outlet_id;
           $new_data['food_menu_id'] = $food_menu_id;
           $new_data['waste_amount'] = (float)$qty*(float)$assigned_ingredient->consumption; 
           $new_data['food_menu_qty'] = (float)$qty;
           $daily_purchase_data=DailyPurchaseIngredients::where('ingredient_id',$assigned_ingredient->ingredient_id)->get();
          
           $last_price=0;
           $last_avg=0;
           if(count($daily_purchase_data)>0 && count($daily_purchase_data)<2)
           {

           $daily_purchase_last_data=DailyPurchaseIngredients::where('ingredient_id',$assigned_ingredient->ingredient_id)->orderBy('created_at', 'desc')->first();
           $last_price=$daily_purchase_last_data->unit_price;
           $last_avg=$daily_purchase_last_data->unit_price;    
           } 
           elseif(count($daily_purchase_data)>=2)
           {
         $daily_purchase_last_data=DailyPurchaseIngredients::where('ingredient_id',$assigned_ingredient->ingredient_id)->orderBy('created_at', 'desc')->first();
         $daily_purchase_sec_last_data=DailyPurchaseIngredients::where('ingredient_id',$assigned_ingredient->ingredient_id)->orderBy('created_at', 'desc')->skip(1)->first();

         $last_price=$daily_purchase_last_data->unit_price;
         $last_avg=((float)$daily_purchase_last_data->unit_price+(float)$daily_purchase_sec_last_data->unit_price)/2; 
           }
           else
           {
          $last_price=CustomHelpers::get_master_table_data('master_products','id',$assigned_ingredient->ingredient_id,'franchise_rate');
          $last_avg=CustomHelpers::get_master_table_data('master_products','id',$assigned_ingredient->ingredient_id,'franchise_rate');

           }  

           $new_data['last_purchase_price'] = $last_price; 
           $new_data['last_purchase_price_avg'] = $last_avg; 
           $new_data['loss_amount'] = (float)$qty*(float)$assigned_ingredient->consumption*(float)$last_avg; 
         
          $query_second=WasteIngredient::create($new_data);
           $loss=(float)$qty*(float)$assigned_ingredient->consumption*(float)$last_avg;
           $loss_amt=(float)$loss_amt+(float)$loss;
           }
        endforeach;
       $data_sec['total_loss'] = $loss_amt; 
       Waste::where('id',$query->id)->update($data_sec);
     DB::commit();
     return redirect('/Waste')->with('success', 'Successfully Added');    
      }
        catch(Exception $e)
        {
            DB::rollBack();

        }

    }
    public function edit_food_menu_waste($id,Request $request)
    {
    $outlet_id =Sentinel::getUser()->parent_id; 
    $data_food_menu =  POS_SettingHelpers::getAllFoodMenus();
    $id=CustomHelpers::custom_decrypt($id);
    $data=Waste::find($id);
    $food_menus=WasteIngredient::where('waste_id',$data->id)->groupBy('food_menu_id')->get();
  
    return view('outlet.waste.edit_food_menu_waste',compact('data_food_menu','data','food_menus'));   

    }
    public function update_food_menu_waste($id,Request $request)
    {
    $purchase_ingredients=$request->ingredient_id;
    if($purchase_ingredients=='')
    {
     return Redirect::back()->with('error', 'Pls select Food Menu');     
    }
    $id=CustomHelpers::custom_decrypt($id);
    $outlet_id =Sentinel::getUser()->parent_id;
    
    $check=DB::table('waste_ingredients')
->join('wastes','wastes.id' , '=', 'waste_ingredients.waste_id')
->where('wastes.id',$id)->select('waste_ingredients.*')->first(); 

    if($check->sync_status==1)
    {
     return Redirect::back()->with('error', 'Data Already Synched. You can not edit this');      
    }
     
       try
        {
     DB::beginTransaction();
     $data['date'] = $request->date;
     $data['remarks'] = $request->remarks;
     $data['outlet_id'] =$outlet_id;
     $data['loss_type'] =1;
   
  
    $query=Waste::where('id',$id)->update($data);
 
      $loss_amt=0; 
     
        $purchase_ingredients=$request->ingredient_id;
        WasteIngredient::where('waste_id',(int)$id)->delete();
       foreach ($purchase_ingredients as $row => $ingredient_id):

           $qty=$request->quantity_amount[$row];
           $food_menu_id=$request->ingredient_id[$row]; 
           $assigned_ingredients=DB::table('assign_food_menu_ingredients')->where('food_menu_id',$food_menu_id)->get();
           foreach($assigned_ingredients as $assigned_ingredient)
           {

           $new_data['ingredient_id'] = $assigned_ingredient->ingredient_id; 
           $new_data['waste_id'] = $id; 
           $new_data['outlet_id'] = $outlet_id;
           $new_data['food_menu_id'] = $food_menu_id;
           $new_data['waste_amount'] = (float)$qty*(float)$assigned_ingredient->consumption; 
           $new_data['food_menu_qty'] = (float)$qty;
           $daily_purchase_data=DailyPurchaseIngredients::where('ingredient_id',$assigned_ingredient->ingredient_id)->get();
          
           $last_price=0;
           $last_avg=0;
           if(count($daily_purchase_data)>0 && count($daily_purchase_data)<2)
           {

           $daily_purchase_last_data=DailyPurchaseIngredients::where('ingredient_id',$assigned_ingredient->ingredient_id)->orderBy('created_at', 'desc')->first();
           $last_price=$daily_purchase_last_data->unit_price;
           $last_avg=$daily_purchase_last_data->unit_price;    
           } 
           elseif(count($daily_purchase_data)>=2)
           {
         $daily_purchase_last_data=DailyPurchaseIngredients::where('ingredient_id',$assigned_ingredient->ingredient_id)->orderBy('created_at', 'desc')->first();
         $daily_purchase_sec_last_data=DailyPurchaseIngredients::where('ingredient_id',$assigned_ingredient->ingredient_id)->orderBy('created_at', 'desc')->skip(1)->first();

         $last_price=$daily_purchase_last_data->unit_price;
         $last_avg=((float)$daily_purchase_last_data->unit_price+(float)$daily_purchase_sec_last_data->unit_price)/2; 
           }
           else
           {
          $last_price=CustomHelpers::get_master_table_data('master_products','id',$assigned_ingredient->ingredient_id,'franchise_rate');
          $last_avg=CustomHelpers::get_master_table_data('master_products','id',$assigned_ingredient->ingredient_id,'franchise_rate');

           }  

           $new_data['last_purchase_price'] = $last_price; 
           $new_data['last_purchase_price_avg'] = $last_avg; 
           $new_data['loss_amount'] = (float)$qty*(float)$assigned_ingredient->consumption*(float)$last_avg; 
         
          $query_second=WasteIngredient::create($new_data);
           $loss=(float)$qty*(float)$assigned_ingredient->consumption*(float)$last_avg;
           $loss_amt=(float)$loss_amt+(float)$loss;
           }
        endforeach;
       $data_sec['total_loss'] = $loss_amt; 
       Waste::where('id',$id)->update($data_sec);
     DB::commit();
     return redirect('/Waste')->with('success', 'Successfully Updated');    
      }
        catch(Exception $e)
        {
            DB::rollBack();

        }

    }
    public function add_ingredients_waste()
    {
    $outlet_id =Sentinel::getUser()->parent_id;
    //
     $ingredients=CustomHelpers::get_outlet_products($outlet_id);

    return view('outlet.waste.add_ingredients_waste',compact('ingredients'));   
    }
   public function store_ingredients_waste(Request $request)
    {
    $purchase_ingredients=$request->ingredient_id;
    if($purchase_ingredients=='')
    {
     return Redirect::back()->with('error', 'Pls select Ingredients');     
    }
      $outlet_id =Sentinel::getUser()->parent_id;
     
       try
        {
     DB::beginTransaction();
     $data['date'] = $request->date;
     $data['remarks'] = $request->remarks;
     $data['outlet_id'] =$outlet_id;
     $data['loss_type'] =0;
    
     $query=Waste::create($data);
    
     
      $loss_amt=0;
     
        $purchase_ingredients=$request->ingredient_id;
       foreach ($purchase_ingredients as $row => $ingredient_id):

       
           $qty=$request->quantity_amount[$row];
           $new_data['ingredient_id'] = $request->ingredient_id[$row];
           $new_data['waste_id'] = $query->id; 
           $new_data['outlet_id'] = $outlet_id;
           $new_data['food_menu_id'] = CustomHelpers::get_master_table_data('assign_food_menu_ingredients','ingredient_id',$request->ingredient_id[$row],'food_menu_id');

           $new_data['waste_amount'] = (float)$qty; 
           $new_data['food_menu_qty'] = 0;
           $daily_purchase_data=DailyPurchaseIngredients::where('ingredient_id',$request->ingredient_id[$row])->get();
          
           $last_price=0;
           $last_avg=0;
           if(count($daily_purchase_data)>0 && count($daily_purchase_data)<2)
           {

           $daily_purchase_last_data=DailyPurchaseIngredients::where('ingredient_id',$request->ingredient_id[$row])->orderBy('created_at', 'desc')->first();
           $last_price=$daily_purchase_last_data->unit_price;
           $last_avg=$daily_purchase_last_data->unit_price;    
           } 
           elseif(count($daily_purchase_data)>=2)
           {
         $daily_purchase_last_data=DailyPurchaseIngredients::where('ingredient_id',$request->ingredient_id[$row])->orderBy('created_at', 'desc')->first();
         $daily_purchase_sec_last_data=DailyPurchaseIngredients::where('ingredient_id',$request->ingredient_id[$row])->orderBy('created_at', 'desc')->skip(1)->first();

         $last_price=$daily_purchase_last_data->unit_price;
         $last_avg=((float)$daily_purchase_last_data->unit_price+(float)$daily_purchase_sec_last_data->unit_price)/2; 
           }
           else
           {
          $last_price=CustomHelpers::get_master_table_data('master_products','id',$request->ingredient_id[$row],'franchise_rate');
          $last_avg=CustomHelpers::get_master_table_data('master_products','id',$request->ingredient_id[$row],'franchise_rate');

           }  

           $new_data['last_purchase_price'] = $last_price; 
           $new_data['last_purchase_price_avg'] = $last_avg; 
           $new_data['loss_amount'] = (float)$qty*(float)$last_avg; 
         
          $query_second=WasteIngredient::create($new_data);
           $loss=(float)$qty*(float)$last_avg;
           $loss_amt=(float)$loss_amt+(float)$loss;
        
        endforeach;
       $data_sec['total_loss'] = $loss_amt; 
       Waste::where('id',$query->id)->update($data_sec);
     DB::commit();
     return redirect('/Waste')->with('success', 'Successfully Added');    
      }
        catch(Exception $e)
        {
            DB::rollBack();

        }

    }
    public function edit_ingredients_waste($id,Request $request)
    {
     $outlet_id =Sentinel::getUser()->parent_id;
    //
     $ingredients=CustomHelpers::get_outlet_products($outlet_id);
    $id=CustomHelpers::custom_decrypt($id);
    $data=Waste::find($id);
    $ingredients_saved=WasteIngredient::where('waste_id',$data->id)->get();
    return view('outlet.waste.edit_ingredients_waste',compact('ingredients','ingredients_saved','data'));   
    }
    public function update_ingredients_waste($id,Request $request)
    {
    $purchase_ingredients=$request->ingredient_id;
    if($purchase_ingredients=='')
    {
     return Redirect::back()->with('error', 'Pls select Ingredients');     
    }
      $outlet_id =Sentinel::getUser()->parent_id;
      $id=CustomHelpers::custom_decrypt($id);
     $check_sync=DB::table('waste_ingredients')
->join('wastes','wastes.id' , '=', 'waste_ingredients.waste_id')
->where('wastes.id',$id)->select('waste_ingredients.*')->first(); 
    if($check_sync->sync_status==1)
    {
     return Redirect::back()->with('error', 'Data Already Synched. You can not edit this');      
    }

       try
        {
     DB::beginTransaction();
     $data['date'] = $request->date;
     $data['outlet_id'] =$outlet_id;
     $data['loss_type'] =0;
     $data['remarks'] = $request->remarks;
     $query=Waste::where('id',$id)->update($data);
    
     
      $loss_amt=0;
     
        $purchase_ingredients=$request->ingredient_id;
        WasteIngredient::where('waste_id',(int)$id)->delete();
       foreach ($purchase_ingredients as $row => $ingredient_id):

       
           $qty=$request->quantity_amount[$row];
           $new_data['ingredient_id'] = $request->ingredient_id[$row];
           $new_data['waste_id'] = $id; 
           $new_data['outlet_id'] = $outlet_id;
           $new_data['food_menu_id'] = CustomHelpers::get_master_table_data('assign_food_menu_ingredients','ingredient_id',$request->ingredient_id[$row],'food_menu_id');

           $new_data['waste_amount'] = (float)$qty; 
           $new_data['food_menu_qty'] = 0;
           $daily_purchase_data=DailyPurchaseIngredients::where('ingredient_id',$request->ingredient_id[$row])->get();
          
           $last_price=0;
           $last_avg=0;
           if(count($daily_purchase_data)>0 && count($daily_purchase_data)<2)
           {

           $daily_purchase_last_data=DailyPurchaseIngredients::where('ingredient_id',$request->ingredient_id[$row])->orderBy('created_at', 'desc')->first();
           $last_price=$daily_purchase_last_data->unit_price;
           $last_avg=$daily_purchase_last_data->unit_price;    
           } 
           elseif(count($daily_purchase_data)>=2)
           {
         $daily_purchase_last_data=DailyPurchaseIngredients::where('ingredient_id',$request->ingredient_id[$row])->orderBy('created_at', 'desc')->first();
         $daily_purchase_sec_last_data=DailyPurchaseIngredients::where('ingredient_id',$request->ingredient_id[$row])->orderBy('created_at', 'desc')->skip(1)->first();

         $last_price=$daily_purchase_last_data->unit_price;
         $last_avg=((float)$daily_purchase_last_data->unit_price+(float)$daily_purchase_sec_last_data->unit_price)/2; 
           }
           else
           {
          $last_price=CustomHelpers::get_master_table_data('master_products','id',$request->ingredient_id[$row],'franchise_rate');
          $last_avg=CustomHelpers::get_master_table_data('master_products','id',$request->ingredient_id[$row],'franchise_rate');

           }  

           $new_data['last_purchase_price'] = $last_price; 
           $new_data['last_purchase_price_avg'] = $last_avg; 
           $new_data['loss_amount'] = (float)$qty*(float)$last_avg; 
         
          $query_second=WasteIngredient::create($new_data);
           $loss=(float)$qty*(float)$last_avg;
           $loss_amt=(float)$loss_amt+(float)$loss;
        
        endforeach;
       $data_sec['total_loss'] = $loss_amt; 
       Waste::where('id',$id)->update($data_sec);
     DB::commit();
     return redirect('/Waste')->with('success', 'Successfully Updated');    
      }
        catch(Exception $e)
        {
            DB::rollBack();

        }

    }
    public function delete_waste_purchase(Request $request)
    {
    $id=CustomHelpers::custom_decrypt($request->id);
 
    $check_sync=DB::table('waste_ingredients')
->join('wastes','wastes.id' , '=', 'waste_ingredients.waste_id')
->where('wastes.id',$id)->select('waste_ingredients.*')->first(); 

    if($check_sync->sync_status==1)
      {
        echo 'You Cannot delete this because data already synched'; 
      
      }
      else
      {
    $outlet_id =Sentinel::getUser()->parent_id;
     
     $id=CustomHelpers::custom_decrypt($request->id);

     $data=Waste::find((int)$id);

     $purchase_ingredients=WasteIngredient::where('waste_id',$data->id)->delete();
     Waste::destroy($id);
     echo 'success'; 
      }
   
       
    }
    public function view_waste_purchase(Request $request)
    {
       $id=CustomHelpers::custom_decrypt($request->id);
       $data=Waste::find($id);
       
       $options = view("outlet.waste.view_waste_purchase",compact('data'))->render();


       echo $options;

    }

    public function get_waste_list(Request $request)
    {
        if ($request->ajax()) {
        $outlet_id =Sentinel::getUser()->parent_id;
      
            $data = Waste::where('outlet_id','=',(int)$outlet_id)->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
            
             
                ->addColumn('date', function($row){
                   return date('d-m-Y', strtotime($row->date));
                    
                })
                ->addColumn('loss_type', function($row){
                  
                   if($row->loss_type==0)
                   {
           return 'Ingredient Wise';
                   }
                   else
                   {
            return 'Food Menu Wise';        
                   }
                   
                    
                }) 
                
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);
$check_sync=DB::table('waste_ingredients')
->join('wastes','wastes.id' , '=', 'waste_ingredients.waste_id')
->where('wastes.id',$row->id)->select('waste_ingredients.*','wastes.loss_type')->first();                  

$actionBtn = '<div class="button_flex">
                    <a href="#" class="view button_left" id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary"><span class="fa fa-eye"></span> </button></a>';
if($check_sync!='' && $check_sync->sync_status==0)
{
    if($check_sync->loss_type==0)
    {
$actionBtn.= '<a href="'.url("Edit-Ingredient-Waste/".$id).'" class="button_left"  id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-success"><span class="fa fa-edit"></span> </button>   </a>'; 
    }
    else
    {
  $actionBtn.= '<a href="'.url("Edit-Food-Menu-Waste/".$id).'" class="button_left"  id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-success"><span class="fa fa-edit"></span> </button>   </a>';       
    }


$actionBtn.= '<a href="#" class="button_left" id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-danger delete" id="'.$id.'" ><span class="fa fa-archive"></span> </button></a>';    
}
                     

                     $actionBtn.='</div>';
                   
                     
                     
                    
                    return $actionBtn;
                })
                ->rawColumns(['date','action','loss_type'])
                ->make(true);
        }

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
     * @param  \App\Models\Waste  $waste
     * @return \Illuminate\Http\Response
     */
    public function show(Waste $waste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Waste  $waste
     * @return \Illuminate\Http\Response
     */
    public function edit(Waste $waste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Waste  $waste
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Waste $waste)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Waste  $waste
     * @return \Illuminate\Http\Response
     */
    public function destroy(Waste $waste)
    {
        //
    }
}

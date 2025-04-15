<?php

namespace App\Http\Controllers;

use App\Models\FactoryIngredients;
use Illuminate\Http\Request;
use App\Models\Stores;
use App\Models\StoreAssignUser;
use App\Models\StoreProduct;
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
use App\Models\StoreDetails;
use App\Models\ItemImages;
use Validator;
use App\Models\PageAccess;
use App\Models\Brands;
use App\Models\Unit;
use App\Models\MasterGst;
use Sentinel;
use DB;
use DataTables;
use App\Models\SupplyItemList;
use App\Models\AssignProductFactoryVendor;
use App\Models\ProductWithIngredients;
use App\Models\WharehouseCart;
use App\Models\FactoryCart;
class FactoryIngredientsController extends Controller
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
    public function factory_ingredients()
    {
       $datas=Stores::where('type','=',2)->whereIn('status',[1,2])->get();
       return view('admin.factory.factory_ingredients',compact('datas')); 
    }
     public function get_factory_ingredients_data(Request $request)
    {

     if ($request->ajax()) {
            $store_id=$request->store;
             
            $data = FactoryIngredients::where('factory_id','=',$store_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
            
              
                 ->addColumn('unit', function($row){
                  
                 $unit=Unit::find($row->unit);
                 return $unit->unit;

                  
                })
              ->addColumn('avl_qty', function($row){
                  
                  $output=$row->avl_qty;
                  
                  if($row->avl_qty=='' || $row->avl_qty<=$row->threshold_qty)
                  {
                    $output.="<p style='background:#dd4b39;color:white;padding:2px 5px;text-align:center'>Low QTY</p>";
                  }
                 return $output;
                  
                })
                ->addColumn('action', function($row){
                    $id=$row->id;
                  
                    $actionBtn = ' <a href="#" style="display:inline-block;margin-top:5px;width:100%" id="'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit </a> 

                    <a href="#" id="'.$row->id.'" style="display:inline-block;margin-top:5px;width:100%" class="order btn btn-danger btn-sm"><i class="fas fa-times"></i> Delete</a>';

                     $cart_check=FactoryCart::where([['factory_id','=',$row->factory_id],['factory_product_id','=',$row->id]])->first();
              if($cart_check==''):
                    $actionBtn .= '
                    <button style="display:inline-block;margin-top:5px;width:100%" item_id="'.$row->id.'" store_id="'.$row->factory_id.'" class="add_to_cart btn btn-info btn-sm"  style="display:inline-block;margin-top:5px;width:100%"> <i class="fas fa-shopping-cart"></i> Add </button>';
                else:
                     $actionBtn .= '
                    <button item_id="'.$row->id.'" store_id="'.$row->factory_id.'" class="btn btn-info btn-sm"  style="display:inline-block;margin-top:5px;width:100%">  Added </button>'; 
                endif;

                    return $actionBtn;
                })
                ->rawColumns(['unit','action','avl_qty'])
                ->make(true);
        }

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_factory_ingredients(Request $request)
    {
         $gsts=MasterGst::all();
         $brands=Brands::all();
         $units=Unit::all();
         $id=CustomHelpers::custom_encrypt($request->id); 
         $loged_user=Sentinel::getUser();
         $vendors = User::where([['registration_level','=',5],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
         $options = view('admin.factory.create_factory_ingredients',compact('gsts','brands','units','id','vendors'))->render();
          echo $options;
    }
    public function add_factory_ingredients(Request $request)
    {
        
        $id=CustomHelpers::custom_decrypt($request->factory_id); 
        $data=new FactoryIngredients;
        $data->factory_id=$id;
        $data->gst_id=$request->gst_id;
        
        $data->product_name=$request->product_name;
        $data->unit=$request->unit;
        
        $data->rate_margin=$request->rate_margin;
        $data->rate_fanchise=$request->rate_fanchise;
        $data->initial_qty=$request->initial_qty;
        $data->threshold_qty=$request->threshold_qty;
        $data->description=$request->description;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
           if($data->save())
        {
            
    
       
        if ($request->has('vendor')){
         $vendors=$request->vendor;
         if(count($vendors)>0)
         {
            foreach($vendors as $vendor)
            {
              $vendor_data=new AssignProductFactoryVendor;
              $vendor_data->factory_vendor_id=$vendor;
              $vendor_data->product_id=$data->id;
              $vendor_data->type='vendor_second';
              $vendor_data->save();
            }
         }
           }
         //
          
         
        }
        
        
      echo 'success';
       
   
       
    }
    public function edit_factory_ingredients(Request $request)
    {
         $gsts=MasterGst::all();
         $brands=Brands::all();
         $units=Unit::all();
         // $id=CustomHelpers::custom_encrypt($request->id); 
         $loged_user=Sentinel::getUser();
         $vendors = User::where([['registration_level','=',5],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();

         $data=FactoryIngredients::find($request->id);
         $options = view('admin.factory.edit_factory_ingredients',compact('gsts','brands','units','data','vendors'))->render();
          echo $options;
    }
    public function update_factory_ingredients(Request $request)
    {
        
        
        $data=FactoryIngredients::find($request->id);
      
        $data->gst_id=$request->gst_id;
        
        $data->product_name=$request->product_name;
        $data->unit=$request->unit;
        
        $data->rate_margin=$request->rate_margin;
        $data->rate_fanchise=$request->rate_fanchise;
        $data->initial_qty=$request->initial_qty;
        $data->threshold_qty=$request->threshold_qty;
        $data->avl_qty=$request->avl_qty;
        $data->description=$request->description;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
          if($data->save())
        {
            
         $previous_datas=AssignProductFactoryVendor::where('product_id','=',$data->id)->whereIn('type',['vendor_second'])->get();
         foreach($previous_datas as $previous_data)
         {
           AssignProductFactoryVendor::destroy($previous_data->id);
         }
       
        if ($request->has('vendor')){
         $vendors=$request->vendor;
         if(count($vendors)>0)
         {
            
            foreach($vendors as $vendor)
            {

              $vendor_data=new AssignProductFactoryVendor;
              $vendor_data->factory_vendor_id=$vendor;
              $vendor_data->product_id=$data->id;
              $vendor_data->type='vendor_second';
              $vendor_data->save();


            }
         }
           }
        
        

        }
        
        
      echo 'success';
       
   
       
    }
    public function add_edit_product_ingredients(Request $request)
    {
        $product_id=$request->id;
        $factory_id=$request->factory_id;
        $data=ProductWithIngredients::where('product_id',$product_id)->get();
        $ingredients=FactoryIngredients::all();
        $options = view('admin.factory.add_edit_product_ingredients',compact('data','product_id','ingredients','factory_id'))->render();
          echo $options;
    }
    public function get_ingredients_list(Request $request)
    {
        $output='<option value="" >--Select Ingredients--</option>';
        $ingredients=FactoryIngredients::all();
         foreach($ingredients as $ingredient):
  $output.='<option value="'.$ingredient->id.'">'.$ingredient->product_name.' ('.CustomHelpers::get_master_table_data("units","id",$ingredient->unit,"unit").' )</option>';
          endforeach;

          echo $output;
    }
    public function add_product_ingredients(Request $request)
    {
        $factory_id=$request->factory_id;
        $product_id=$request->product_id;
        $previous_data=ProductWithIngredients::where([['factory_id','=',$factory_id],['product_id','=',$product_id]])->delete();
        //
        $ingredients=$request->ingredients;
        foreach($ingredients as $row=>$col)
        {
            if($col['id']!='' && $col['qty']!=''):
            $check_previous=ProductWithIngredients::where([['ingredients_id','=',$col['id']],['product_id','=',$product_id],['factory_id','=',$factory_id]])->first();
            if($check_previous=='')
            {
                $data=new ProductWithIngredients;
                $data->factory_id=$factory_id;
                $data->product_id=$product_id;
                $data->ingredients_id=$col['id'];
                $data->qty=$col['qty'];
                $data->save();
                 echo 'success';
            }
          endif;
        }
    }
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
     * @param  \App\Models\FactoryIngredients  $factoryIngredients
     * @return \Illuminate\Http\Response
     */
    public function show(FactoryIngredients $factoryIngredients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FactoryIngredients  $factoryIngredients
     * @return \Illuminate\Http\Response
     */
    public function edit(FactoryIngredients $factoryIngredients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FactoryIngredients  $factoryIngredients
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FactoryIngredients $factoryIngredients)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FactoryIngredients  $factoryIngredients
     * @return \Illuminate\Http\Response
     */
    public function destroy(FactoryIngredients $factoryIngredients)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\FoodMenu;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;
use App\Helpers\POS_SettingHelpers;
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
use App\Models\AssignFoodMenuCategoryToBrands;
use App\Models\AssignFoodMenuIngredient;
use App\Models\AssignFoodMenuToBrands;
use App\Models\FoodMenuCategory;
use App\Models\MasterProduct;
use App\Models\FranchiseFoodMenuPrice;
use App\Exports\FoodMenuRecipeExport;
use App\Imports\RecipeImport;
use App\Models\RegionSetting;
use Excel;
use PDF;

class FoodMenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

        $data=DB::table('users')
         ->join('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
        
         ->whereIn('users.registration_level',[2,1])
        
         ->select('users.*')  
        ->get();
          
         $regions=RegionSetting::all(); 
         $cities=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->orderBy('dist')->get()->unique('dist')->pluck('dist');
      //   $data = FoodMenu::latest()->get();
      //   foreach($data as $row)
      //   {
      //      $cp_without_gst=POS_SettingHelpers::get_food_menu_cp($row->id,'cp_without_gst');
      //           $cp_gst=POS_SettingHelpers::get_food_menu_cp($row->id,'cp_gst');
      //           $cp_total=POS_SettingHelpers::get_food_menu_cp($row->id,'cp_total');
      //        echo  $cp_total.'<br>'; 
      //   }
      // dd($data);
      
        
       return view('admin.pos.foodmenu.index',compact('data','regions','cities'));
    }
     public function get_export_recipe(Request $request)
    {
    $food_menu_id=$request->id;
    $data=FoodMenu::find((int)$food_menu_id);
    return Excel::download(new FoodMenuRecipeExport((int)$food_menu_id), $data->name.'Recipes'.'.xlsx');
       
    }
    public function store_recipes_by_excel(Request $request)
    {
    
    if($request->hasFile('recipe')){
        $food_menu_id=$request->food_menu_id;
            Excel::import(new RecipeImport((int)$food_menu_id), $request->file('recipe'));

           echo 'success';
        }else{
            echo 'error';
        }
       
    }
     public function franchise_food_menu()
    {
      $outlet_id =Sentinel::getUser()->parent_id;
      $outlet_brand_id=POS_SettingHelpers::get_brand_id();
      $update_pre_pos_data = POS_SettingHelpers::update_pre_pos_data($outlet_id,$outlet_brand_id);
       
      $gsts=MasterGst::all();
       $update_menues = POS_SettingHelpers::update_outlet_menues($outlet_id,$outlet_brand_id); 
      // $data = DB::table('assign_food_menu_to_brands')
      //          ->join('food_menus','assign_food_menu_to_brands.menu_category_id' , '=', 'food_menus.id')       
      //         ->select('food_menus.*')
      //        ->where('assign_food_menu_to_brands.brand_id', '=', (int)$outlet_brand_id)
      //        ->get()->groupBy('category_id');
         
            $outlet_id =Sentinel::getUser()->parent_id;
    $data = DB::table('franchise_food_menu_prices')->where([['outlet_id',$outlet_id],['status','=',1]])->get()->groupBy('category_id');
           

       return view('outlet.foodmenu.index',compact('data','gsts'));
    }
     public function get_franchise_food_menu(Request $request)
    {
        if ($request->ajax()) {
            $outlet_id =Sentinel::getUser()->parent_id;
            $outlet_brand_id=POS_SettingHelpers::get_brand_id();
            $item_type=$request->item_type;
            $outlet_brand_id=POS_SettingHelpers::get_brand_id();
             $assign_food_menu_ids = DB::table('franchise_food_menu_prices')->where([['outlet_id',$outlet_id],['status',1]])->pluck('food_menu_id');

            

       

            if($item_type=='NA')
            {

        $data = FoodMenu::whereIn('id',$assign_food_menu_ids)->get();

                
            }
            else
            {
            $data = FoodMenu::whereIn('id',$assign_food_menu_ids)->where('category_id',$item_type)->get();
              
            }
            
            return Datatables::of($data)
                ->addIndexColumn()
                
               
                ->addColumn('category_name', function($row){
                
           return POS_SettingHelpers::get_food_category_name($row->category_id);
                    
                })
                ->addColumn('price', function($row){
              $outlet_id =Sentinel::getUser()->parent_id;
                return POS_SettingHelpers::get_franchise_food_price($row->id,$outlet_id);

                 
                    
                })
                 ->addColumn('gst', function($row){
               $outlet_id =Sentinel::getUser()->parent_id;
                $tax=POS_SettingHelpers::get_franchise_tax($row->id,$outlet_id);
                if($tax==0)
                {
               
                return $tax;
                }
                else
                {
                $gst_data=json_decode($tax);
                $gst_id=$gst_data[0]->tax_field_id;  
                $gst_data=MasterGst::find($gst_id);
               if($gst_data!='')
               {
               return $gst_data->gst_name;
               }
               else
               {
               return 'Not Updated';
               }

                
                }
                
                    
                })  
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '
                    <a href="#" style="display:inline-block;margin-top:5px;width:100%" id="'.$id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit Price</a> 
                  ';
                    return $actionBtn;
                })
                ->rawColumns(['action','category_name','price','gst'])
                ->make(true);
        }
    }
public function edit_foodmenu_price(Request $request)
   {

    $id=CustomHelpers::custom_decrypt($request->id);
    $outlet_id =Sentinel::getUser()->parent_id;
    
    $data=FranchiseFoodMenuPrice::where([['outlet_id','=',(int)$outlet_id],['food_menu_id','=',(int)$id]])->first(); 
    $gsts=MasterGst::all();
    $options = view('outlet.foodmenu.edit',compact('data','gsts'))->render();
    echo $options;


   }
    public function update_bulk_gst(Request $request)
   {


    $outlet_id =Sentinel::getUser()->parent_id;
    $datas=FranchiseFoodMenuPrice::where('outlet_id',$outlet_id)->get(); 
   
     foreach($datas as $data):
     $gst_data=MasterGst::find($request->tax_information);
     $tax_information = array();
          if($gst_data!='')
          {
           $gst=$gst_data->gst_name;
          }
          else
          {
            $gst=0;
          }
        
         $single_info = array(
                        'tax_field_id' => $request->tax_information,
                        'tax_field_company_id' => 1,
                        'tax_field_name' => 'GST',
                        'tax_field_percentage' =>$gst
                    );
         array_push($tax_information,$single_info);
        $tax_information = json_encode($tax_information);
        $new_data=FranchiseFoodMenuPrice::find($data->id);
       $new_data->tax_information=$tax_information; 
     
      $new_data->save();
      
   endforeach;
     echo 'success';


   }
   public function update_franchise_foodmenuprice(Request $request)
   {

    $id=CustomHelpers::custom_decrypt($request->id);
    $loged_user=Sentinel::getUser();
   
     $data=FranchiseFoodMenuPrice::find($id); 
     $gst_data=MasterGst::find($request->tax_information);
     $tax_information = array();
          if($gst_data!='')
          {
           $gst=$gst_data->gst_name;
          }
          else
          {
            $gst=0;
          }
        
         $single_info = array(
                        'tax_field_id' => $request->tax_information,
                        'tax_field_company_id' => 1,
                        'tax_field_name' => 'GST',
                        'tax_field_percentage' =>$gst
                    );
         array_push($tax_information,$single_info);
        $tax_information = json_encode($tax_information);
       $data->tax_information=$tax_information; 
      $data->sale_price=$request->sale_price;
      $data->save();
     echo 'success';


   }
   public function get_food_menu(Request $request)
    {
        if ($request->ajax()) {
            $outlet_id=$request->outlet_id;
            $data = FoodMenu::where('outlet_id',$outlet_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                  
         
          if($row->photo!=''):
            $path=url('public/uploads/food_menu/'.$row->photo);
                    $image = '<img src="'.$path.'" width="100px">';
          else:
           $image = 'NA';
          endif;
                    return $image;
                })
                 ->addColumn('category', function($row){
                 if($row->category_id!=''):
          $category=FoodMenuCategory::find($row->category_id);
          if($category!=''):
                 return $category->category_name;
                 else:
             return 'category deleted';
             endif;
             else:
                return 'Not Updated';
             endif;
                    
                })
                 ->addColumn('cp', function($row){

                // $price=POS_SettingHelpers::get_food_menu_cp($row->id);
                if($row->cp_data!='')
                {
                $price=unserialize($row->cp_data);
                $output='Cost: <b>'.$price['cp_without_gst'].'</b><hr style="margin:0px;padding:0px">';
                $output.='GST: <b>'.$price['cp_gst'].'</b><hr style="margin:0px;padding:0px">';
                $output.='Total: <b>'.$price['cp_total'].'</b>';  
                }
                else
                {
               $output='Not Sync Yet';
                }
                
                return $output;
                    
                })
                 ->addColumn('cp_percentage', function($row){
                // $price=POS_SettingHelpers::get_food_menu_cp($row->id);
                $sale_price=POS_SettingHelpers::get_food_menu_sp($row->id);
                if($row->cp_data!='')
                {
                   $price=unserialize($row->cp_data); 
                if($price['cp_without_gst']!='' && $sale_price['cp_without_gst']!='0'):
               $cp_percentage= round($price['cp_without_gst']/$sale_price['cp_without_gst']*100,2).'% <hr style="margin:0px;padding:0px">';
               $cp_percentage.='<span style="font-size:13px"><i><b>Sync:</b><br>'.$price['sync'].'</i></span>';
                else:
               $cp_percentage= 0;
                endif; 
               }
                else
                {
               $cp_percentage='Not Sync Yet';
                }
                return $cp_percentage;
                })
                ->addColumn('sp', function($row){

                $sale_price=POS_SettingHelpers::get_food_menu_sp($row->id);
            
                $output='Base: <b>'.$sale_price['cp_without_gst'].'</b><hr style="margin:0px;padding:0px">';
                $output.='GST: <b>'.$sale_price['cp_gst'].'</b><hr style="margin:0px;padding:0px">';
                $output.='Total: <b>'.$sale_price['cp_total'].'</b>';
                return $output;
                    
                })
                ->addColumn('action', function($row){
                    
                    $actionBtn = '<div class="button_flex"><a href="#"  id="'.$row->id.'" class="import_recipe btn btn-primary btn-sm button_left"><i class="fas fa-file-import"></i> Import Recipe</a> <a href="#"  id="'.$row->id.'" class="export_recipe  btn btn-default btn-sm button_left"><i class="fas fa-file-export"></i> Export Recipe</a>';
                 
              

                    $actionBtn.= '<a href="#"  id="'.$row->id.'" class="edit btn btn-success btn-sm button_left"><i class="fas fa-edit"></i> Edit</a> <a href="#"  id="'.$row->id.'" class="delete remove btn btn-danger btn-sm button_left"><i class="far fa-trash-alt"></i> Delete</a><div>';
                    return $actionBtn;
                })
                ->rawColumns(['image','category','action','cp','cp_percentage','sp'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $outlet_id=$request->outlet_id;
        
        $category=FoodMenuCategory::where('outlet_id',$outlet_id)->get();
        $gsts=MasterGst::all();

       
        $ingredients=MasterProduct::whereIn('item_type',['Frozen','Masala','Grocery','Vegetable','Syrup','Sauce','Bakery','Crush','Dairy','Disposable'])->where('outlet_id',$outlet_id)->get();
      
      

        $options = view("admin.pos.foodmenu.create",compact('outlet_id','category','gsts','ingredients'))->render();
        echo $options;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), 
              [ 
           'name' => "required",
        
             ]); 
        if($validator->fails()) 
            {          
           echo "Please Enter Category Name";            
            } 
            else
            {
        $data=new FoodMenu;
        $data->name=$request->name;
        $data->code=$request->code;
        $data->outlet_id=$request->outlet_id;
        $data->category_id=$request->category_id;
        $data->sale_price=$request->sale_price;

        if($request->hasFile('photo')):
         $images = $request->file('photo');

       //
        $destinationPath_thumb = public_path('/uploads/food_menu');
        $thumb_name = rand().'.'.$images->getClientOriginalExtension();
        $img = Image::make($images->getRealPath());
        $img->resize(400, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath_thumb.'/'.$thumb_name);
      
        $data->photo=$thumb_name;
        else:
           $data->photo='no_image.jpg'; 
        endif;
        
        $data->veg_item=$request->veg_item;
        $data->non_veg_item=$request->non_veg_item;
        $data->beverage_item=$request->beverage_item;
          $tax_information = array();

          if($request->tax_information!=''):
          $gst_data=MasterGst::find($request->tax_information);
          if($gst_data!='')
          {
           $gst=$gst_data->gst_name;
          }
          else
          {
            $gst=0;
          }
         endif;
         $single_info = array(
                        'tax_field_id' => $request->tax_information,
                        'tax_field_company_id' => 1,
                        'tax_field_name' => 'GST',
                        'tax_field_percentage' =>$gst
                    );
         array_push($tax_information,$single_info);
        $tax_information = json_encode($tax_information);
        $data->tax_information=$tax_information;
        $data->description=$request->description;
        $data->making_time_in_min=$request->making_time_in_min;
        $data->create_by_id=Sentinel::getUser()->id;
        $data->save();
        //assign_ingr
      
        $food_menu_id=$data->id;
        if($request->has('ingredients'))
        {
              $previous_data=AssignFoodMenuIngredient::where('food_menu_id','=',$food_menu_id)->delete();
        //
        $ingredients=$request->ingredients;
        foreach($ingredients as $row=>$col)
        {
            if($col['id']!='' && $col['qty']!=''):
            $check_previous=AssignFoodMenuIngredient::where([['ingredient_id','=',$col['id']],['food_menu_id','=',$food_menu_id]])->first();
            if($check_previous=='')
            {
                $data_ing=new AssignFoodMenuIngredient;
                $data_ing->create_by_id=Sentinel::getUser()->id;
                $data_ing->food_menu_id=$food_menu_id;
                $data_ing->ingredient_id=$col['id'];
                $data_ing->consumption=$col['qty'];
                $data_ing->ingredient_code=CustomHelpers::get_master_table_data('master_products','id',$col['id'],'item_code');
                $data_ing->use_for=$col['use_for'];
                $data_ing->save();
                
            }
          endif;
        }   
        }
   

      
       
        echo 'success';

            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FoodMenu  $foodMenu
     * @return \Illuminate\Http\Response
     */
    public function show(FoodMenu $foodMenu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FoodMenu  $foodMenu
     * @return \Illuminate\Http\Response
     */
     public function edit(Request $request)
    {
        $id=$request->id;
        $data=FoodMenu::find($id);
        
        $outlet_id=$data->outlet_id;
        
        $category=FoodMenuCategory::where('outlet_id',$outlet_id)->get();
        $gsts=MasterGst::all();

       
        $ingredients=MasterProduct::whereIn('item_type',['Frozen','Masala','Grocery','Vegetable','Syrup','Sauce','Bakery','Crush','Dairy','Disposable'])->where('outlet_id',$outlet_id)->get();
     
       $previous_ingredients=AssignFoodMenuIngredient::where('food_menu_id','=',$id)->get();

        $options = view("admin.pos.foodmenu.edit",compact('data','outlet_id','category','gsts','ingredients','previous_ingredients'))->render();
        echo $options;

       
    }
   public function get_ingredients_list_food_menu(Request $request)
    {
        $output='<option value="" >--Select Ingredients--</option>';
        $ingredients=MasterProduct::whereIn('item_type',['Frozen','Masala','Grocery','Vegetable','Syrup','Sauce','Bakery','Crush','Dairy','Disposable'])->get();
         foreach($ingredients as $ingredient):
  $output.='<option value="'.$ingredient->id.'">'.$ingredient->product_name.' ('.CustomHelpers::get_master_table_data("units","id",$ingredient->unit,"unit").' )</option>';
          endforeach;

          echo $output;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FoodMenu  $foodMenu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FoodMenu $foodMenu)
    {
        $validator = Validator::make($request->all(), 
              [ 
           'name' => "required",
        
             ]); 
        if($validator->fails()) 
            {          
           echo "Please Enter Category Name";            
            } 
            else
            {
        $id=$request->id;
        $data=FoodMenu::find($id);
        $data->name=$request->name;
        $data->code=$request->code;
        $data->category_id=$request->category_id;
        $data->sale_price=$request->sale_price;

        if($request->hasFile('photo')):
         $images = $request->file('photo');

       //
        $destinationPath_thumb = public_path('/uploads/food_menu');
        $thumb_name = rand().'.'.$images->getClientOriginalExtension();
        $img = Image::make($images->getRealPath());
        $img->resize(400, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath_thumb.'/'.$thumb_name);
      
        $data->photo=$thumb_name;
        
        endif;
        
        $data->veg_item=$request->veg_item;
        $data->non_veg_item=$request->non_veg_item;
        $data->beverage_item=$request->beverage_item;
        $tax_information = array();

          if($request->tax_information!=''):
          $gst_data=MasterGst::find($request->tax_information);
          if($gst_data!='')
          {
           $gst=$gst_data->gst_name;
          }
          else
          {
            $gst=0;
          }
         endif;
         $single_info = array(
                        'tax_field_id' => $request->tax_information,
                        'tax_field_company_id' => 1,
                        'tax_field_name' => 'GST',
                        'tax_field_percentage' =>$gst
                    );
         array_push($tax_information,$single_info);
        $tax_information = json_encode($tax_information);
        $data->tax_information=$tax_information;
        $data->description=$request->description;
        $data->making_time_in_min=$request->making_time_in_min;
        $data->create_by_id=Sentinel::getUser()->id;
        $data->save();
        //assign_ingr
      
        $food_menu_id=$data->id;
         if($request->has('ingredients'))
        {
  $previous_data=AssignFoodMenuIngredient::where('food_menu_id','=',$food_menu_id)->delete();
        //
        $ingredients=$request->ingredients;
        foreach($ingredients as $row=>$col)
        {
            if($col['id']!='' && $col['qty']!=''):
            $check_previous=AssignFoodMenuIngredient::where([['ingredient_id','=',$col['id']],['food_menu_id','=',$food_menu_id]])->first();
            if($check_previous=='')
            {
                $data_ing=new AssignFoodMenuIngredient;
                $data_ing->create_by_id=Sentinel::getUser()->id;
                $data_ing->food_menu_id=$food_menu_id;
                $data_ing->ingredient_id=$col['id'];
                $data_ing->consumption=$col['qty'];
                $data_ing->ingredient_code=CustomHelpers::get_master_table_data('master_products','id',$col['id'],'item_code');
                $data_ing->use_for=$col['use_for'];
                $data_ing->save();
                
            }
          endif;
        }
        }
      

       
        echo 'success';

            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FoodMenu  $foodMenu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
         FoodMenu::destroy($id);
         echo 'success';
    }
}

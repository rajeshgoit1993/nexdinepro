<?php

namespace App\Http\Controllers;

use App\Models\MasterProduct;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;
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
use App\Models\PhysicalEntry;
use App\Models\RegionSetting;
use App\Models\FactoryIngredients;
use App\Exports\MasterProductExport;
use App\Imports\FranchiseStockImport;
use Excel;
use PDF;
use DB;
use Validator;

class MasterProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function get_import_stock_form(Request $request)
    {
       $outlet_id=$request->outlet_id;
       $options = view("admin.product.form_field",compact('outlet_id'))->render();
        echo $options; 
    }
     public function store_stock_by_excel(Request $request)
    {
     $validator = Validator::make($request->all(), 
              [ 
            "stock"=>"required|file|mimetypes:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/excel",
           
             ]); 
           if($validator->fails()) 
            { 
                $a='';
            $messages = $validator->messages();
             foreach ($messages->all(':message') as $message)
            {
                $a= $message;
            }
              
           echo $a;            
            } 
            else
            {

            
    if($request->hasFile('stock')){
        
        $outlet_id =CustomHelpers::custom_decrypt($request->outlet_id);
        $date=date('Y-m-d');
        $check_data=PhysicalEntry::where('outlet_id',$outlet_id)->whereDate('date',$date)->first();
           if($check_data!='' && $check_data->sync_status==1)
           {
             echo 'You cannot change today data because its already synched';
           }
           else
           {
           Excel::import(new FranchiseStockImport($outlet_id),$request->file('stock'));

           echo 'success';  
           }
            
        }else{
            echo 'error';
        }
       }
    }
    public function edit_stock_list(Request $request)
   {

    $id=CustomHelpers::custom_decrypt($request->id);
    $loged_user=Sentinel::getUser();
   
    
    $data=MasterProduct::find($id); 
    
    


    $options = view('admin.product.edit_qty',compact('data'))->render();
    echo $options;


   }
   public function update_stock_list(Request $request)
   {

    $id=CustomHelpers::custom_decrypt($request->id);
    $loged_user=Sentinel::getUser();
   
     $data=MasterProduct::find($id); 
     $outlet_id =$data->outlet_id;
     
    $consuption_sum=DB::table('franchise_sale_consuptions_of_menus')
         ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$data->item_code],['sync_status',0]])->sum('consumption');
          
    $waste_sum=DB::table('waste_ingredients')
         
           ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$data->item_code],['sync_status',0]])->sum('waste_amount');
    $total_waste=(float)$consuption_sum+(float)$waste_sum;

      
      $date=date('Y-m-d');
      $check_data=PhysicalEntry::where('outlet_id',$outlet_id)->whereDate('date',$date)->first();

           if($check_data!='' && $check_data->sync_status==1)
           {
             echo 'You cannot change today data because its already synched';
           }
           else
           {
           $ingredient_id=$data->item_code;
           $find_data=PhysicalEntry::where([['outlet_id',$outlet_id],['ingredient_id',$ingredient_id]])->whereDate('date',$date)->first();
           if($find_data=='')
           {
          $find_data=new PhysicalEntry;
           }
           $find_data->date=$date;
           $find_data->outlet_id=$outlet_id;
           $find_data->ingredient_id=$ingredient_id;
           $find_data->auto_data=(float)$data->available_qty-(float)$total_waste;
           $find_data->physical_data=$request->physical_data;
          
           $find_data->save();
           echo 'success';  
           }

     


   }

    public function index()
    {
       
     //    $csv=url("public/uploads/utensil_lists.csv");
     //     $rows=array();
     //     $rows=file($csv);
     //     $data_size=sizeof($rows);
      
     //   foreach($rows as $row):
     // $data_array=explode(",",$row);
     //  if($data_array['0']!=''):

   //       $data=new FactoryIngredients;
   

   // $data->product_name=$data_array['0'];
   // $data->unit=$data_array['1'];
   // $data->rate_margin=$data_array['2'];
   // $data->threshold_qty=$data_array['3'];
   //    $data->factory_id=3;
   
   // $data->save();

       //  $product_data=MasterProduct::where('product_name','=',$data_array['0'])->first();
       //   $data_find=BrandWiseProduct::where([['product_id','=',$product_data->id],['brand_id','=',$data_array['2']]])->first();
       //   if($data_find!=''):
       // $data=BrandWiseProduct::find($data_find->id);
       
       //  $data->threshold_qty=$data_array['1'];

        
       
       //  $data->save();

      // endif;
        // $data=MasterProduct::find($product_data->id);
        //   if($data_array['6']=='5%'):
        //  $data->gst_id=3;
        // elseif($data_array['6']=='12%'):
        // $data->gst_id=5;
        //  elseif($data_array['6']=='18%'):
        //  $data->gst_id=4;
        //  endif;
        //  $data->save();
        //    $product_data=MasterProduct::where('product_name','=',$data_array['0'])->first();
        // $data=new BrandWiseProduct;
        // $data->product_id=$product_data->id;
        // $data->brand_id=$data_array['7'];
        // $data->initial_qty=$data_array['1'];
       
        // $data->save();

   // $data=new MasterProduct;
   // $data->id=$data_array['0'];
   // $data->status=$data_array['1'];
   // $data->supply_for=$data_array['2'];
   
   // $data->product_name=$data_array['3'];
   // $data->initial_qty=$data_array['4'];
   // $data->initial_qty=$data_array['5'];
   
  
   // $data->unit=$data_array['6'];
   // $data->item_type=$data_array['7'];
   // $data->company_rate=$data_array['8'];
   // $data->franchise_rate=$data_array['9'];

   // $data->gst_id=$data_array['10'];
   
   // $data->save();
  //  //
  //   $factory_data=new AssignProductFactoryVendor;
  //   $factory_data->factory_vendor_id=3;
  //   $factory_data->product_id=$data->id;
  //   $factory_data->type='factory';
  //   $factory_data->save();
  //  //
  //   $store_product=new StoreProduct;
  //   $store_product->store_id=4;
  //   $store_product->product_id=$data->id;
  //   $store_product->threshold_qty=$data->threshold_qty;
   
  //   $store_product->save(); 
   // endif;


   //   endforeach;
   //  echo "hi";
   //    dd($rows);
        // $data=MasterProduct::all();
        // $a=1;
        // foreach($data as $d)
        // {
        //  $new_data=MasterProduct::find($d->id);
        //  $new_data->item_code='R'.str_pad($a, 6, '0', STR_PAD_LEFT);
        //  $new_data->save();
        //  $a++;
        // }

         $data=DB::table('users')
         ->join('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
        
         ->whereIn('users.registration_level',[2,1])
        
         ->select('users.*')  
        ->get();
          
         $regions=RegionSetting::all(); 
         $cities=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->orderBy('dist')->get()->unique('dist')->pluck('dist');

       return view('admin.product.index',compact('data','regions','cities'));
    }
   public function export_master_product(Request $request)
    {
     
   $outlet_id=$request->outlet_id;
    return Excel::download(new MasterProductExport($outlet_id), 'MasterProduct'.'.xlsx');
       
    }



    
    public function first_time_stock()
    {
       
      
         $brands=Brands::all();
       return view('admin.first_time_stock.index',compact('brands'));
    }
    public function supplyitem_list()
    {
      
   

      $brands=Brands::all();
      return view('admin.supply_list.index',compact('brands'));
    }

     public function get_product(Request $request)
    {
        if ($request->ajax()) {
           $outlet_id=$request->outlet_id;
            $item_type=$request->item_type;
            if($item_type=='NA')
            {
                $data = MasterProduct::where('outlet_id',$outlet_id)->latest()->get();
            }
            else
            {
               $data = MasterProduct::where([['item_type','=',$item_type],['outlet_id',$outlet_id]])->get();
            }
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                  
          $image_data=ItemImages::where([['item_id','=',$row->id],['default','=',1]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="100px">';
          else:
           $image = 'NA';
          endif;
                    return $image;
                })
                ->addColumn('gst', function($row){
                  
             if($row->gst_id!=''):
          $gst_data=MasterGst::find($row->gst_id);
          if($gst_data!='')
          {
            return $gst_data->gst_name;
          }
          else
          {
            return 'Not Updated';
          }
                 
             else:
                return 'Not Updated';
             endif;
                })
                ->addColumn('unit', function($row){
                 if($row->unit!=''):
          $unit=Unit::find($row->unit);
                 return $unit->unit;
             else:
                return 'Not Updated';
             endif;
                    
                })
                   ->addColumn('rate', function($row){
             
                 $a='  Rs. '.$row->franchise_rate;

                 return $a;
                    
                })
                   ->addColumn('code', function($row){
             
                 $a=$row->item_code;

                 return $a;
                    
                })
                  
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="#" style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary btn-sm uploads" id="'.$id.'"><i class="fas fa-edit"></i>  Uploads</a> 
                    <a href="#" style="display:inline-block;margin-top:5px;width:100%" id="'.$id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> 
                    <a href="'.url('Product-Delete/'.$id).'" style="display:inline-block;margin-top:5px;width:100%" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                     $actionBtn.= '
                    <a href="#" style="display:inline-block;margin-top:5px;width:100%" id="'.$id.'" class="edit_qty btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit QTY</a> 
                   ';
                    return $actionBtn;
                })
                ->rawColumns(['action','image','gst','unit','rate','code'])
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
         $loged_user=Sentinel::getUser();
        $gsts=MasterGst::all();
        
        $units=Unit::all();
       
        $options = view('admin.product.create',compact('gsts','units','outlet_id'))->render();
        echo $options;
    }

    public function edit_product_list(Request $request)
   {

    $id=CustomHelpers::custom_decrypt($request->id);
    $loged_user=Sentinel::getUser();
    $gsts=MasterGst::all();
    $vendors = User::where([['registration_level','=',5],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
    $brands=Brands::all();
    $units=Unit::all();
    $factories=Stores::where('type','=',2)->whereIn('status',[1,2])->get(); 
     $data=MasterProduct::find($id); 

     $brand_wise_data=BrandWiseProduct::where('product_id','=',$id)->get();
    $options = view('admin.product.edit',compact('data','gsts','vendors','brands','units','factories','brand_wise_data'))->render();
    echo $options;


   }
    public function get_brand_list(Request $request)
    {
        $output='<option value="" >--Select Brands--</option>';
        $brands=Brands::all();
         foreach($brands as $brand):
  $output.='<option value="'.$brand->id.'">'.$brand->brand.'</option>';
          endforeach;

          echo $output;
    }
    public function update_product_list(Request $request)
    {
      $id=CustomHelpers::custom_decrypt($request->id);   
       
        $validator = Validator::make($request->all(), 
              [ 
          "product_name"=>"required",
           'item_code'=>"required|unique:master_products,item_code,$id",  
           
             ]); 
           if($validator->fails()) 
            {          
              $a='';
            $messages = $validator->messages();
             foreach ($messages->all(':message') as $message)
            {
                $a= $message;
            }
              
           echo $a;       
            } 
       else
       {
        if (MasterProduct::where('id', $id)->exists()) 
        {
         $data=MasterProduct::find($id);
          $data->outlet_id=$request->outlet_id;
        $data->item_type=$request->item_type;
        $data->item_code=$request->item_code;

        $data->product_name=$request->product_name;
        $data->unit=$request->unit;

       
        $data->threshold_qty=$request->threshold_qty;  
        
        
       
        $data->franchise_rate=$request->franchise_rate;
        
        $data->gst_id=$request->gst_id;
        $data->description=$request->description;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();

        $data->save();

         echo 'success';
        }
        else
        {
       echo 'error';
        }
    }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

  $outlet_id=$request->outlet_id;   
       
        $validator = Validator::make($request->all(), 
              [ 
          "product_name"=>"required",
           'item_code'=>"required|unique:master_products",
           
             ]); 
           if($validator->fails()) 
            {          
              $a='';
            $messages = $validator->messages();
             foreach ($messages->all(':message') as $message)
            {
                $a= $message;
            }
              
           echo $a;       
            } 
       else
       {
        $data=new MasterProduct;
        $data->outlet_id=$request->outlet_id;
        $data->item_type=$request->item_type;
        $data->item_code=$request->item_code;

        $data->product_name=$request->product_name;
        $data->unit=$request->unit;
        $data->available_qty=$request->available_qty;
       
        $data->threshold_qty=$request->threshold_qty;  
        
        
       
        $data->franchise_rate=$request->franchise_rate;
        
        $data->gst_id=$request->gst_id;
        $data->description=$request->description;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        echo 'success';

       }



    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterProduct  $masterProduct
     * @return \Illuminate\Http\Response
     */
    public function show(MasterProduct $masterProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterProduct  $masterProduct
     * @return \Illuminate\Http\Response
     */
    public function edit(MasterProduct $masterProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterProduct  $masterProduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MasterProduct $masterProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterProduct  $masterProduct
     * @return \Illuminate\Http\Response
     */
  
       public function destroy($id,MasterProduct $masterProduct)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (MasterProduct::where('id', $id)->exists()) 
        {
          MasterProduct::destroy($id);
         return redirect()->route('all_products')->with('success',"List Successfully Deleted");
        }
        else
        {
       return redirect()->route("all_products")->with("success","No Data Found");
        }
    }
    public function first_stock(Request $request)
    {
        if ($request->ajax()) {
            $brand=$request->brand;
            $item_type=$request->item_type;
           //  $product_id=DB::table('brand_wise_products')->where('brand_id',$brand)->pluck('product_id');
           //  if($item_type=='NA')
           //  {
           // $data = MasterProduct::whereIn('id',$product_id)->get();
           //  }
           //  else
           //  {
           // $data = MasterProduct::whereIn('id',$product_id)->where('item_type','=',$item_type)->get();
           //  }
            
           
            if($item_type=='NA')
            {
           $data = DB::table('brand_wise_products')
            ->join('master_products', 'master_products.id', '=', 'brand_wise_products.product_id')
            ->where('brand_wise_products.brand_id','=',(int)$brand)
            ->select('master_products.*', 'brand_wise_products.initial_qty', 'brand_wise_products.brand_id')
            ->get();
            }
            else
            {
            $data = DB::table('brand_wise_products')
            ->join('master_products', 'master_products.id', '=', 'brand_wise_products.product_id')
             ->where([['brand_wise_products.brand_id','=',(int)$brand],['master_products.item_type','=',$item_type]])
            ->select('master_products.*', 'brand_wise_products.initial_qty', 'brand_wise_products.brand_id')
            ->get();
           
            }


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                  
          $image_data=ItemImages::where([['item_id','=',$row->id],['default','=',1]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="100px">';
          else:
           $image = 'NA';
          endif;
                    return $image;
                })
                  ->addColumn('gst', function($row){
                 if($row->gst_id!=''):
                       $gst_data=MasterGst::find($row->gst_id);
          if($gst_data!='')
          {
            return $gst_data->gst_name;
          }
          else
          {
            return 'Not Updated';
          }
             else:
                return 'Not Updated';
             endif;
                    
                })
                  ->addColumn('unit', function($row){
                 if($row->unit!=''):
          $unit=Unit::find($row->unit);
                 return $unit->unit;
             else:
                return 'Not Updated';
             endif;
                    
                })
                  ->addColumn('thumb', function($row){
                
               
              
                $thumb=Brands::find($row->brand_id);
                $output='<p>'.$thumb->brand.'</p>';
               
          
                 return $output;
            
             
                    
                })
                // ->addColumn('action', function($row){
                //     $id=CustomHelpers::custom_encrypt($row->id);

                //     $actionBtn = '<a href="#" style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary btn-sm uploads" id="'.$id.'">
                //     <i class="fas fa-edit"></i> Uploads </a> 
                //     <a href="#" style="display:inline-block;margin-top:5px;width:100%" id="'.$id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> 
                //     <a href="'.url('UtensilList-Delete/'.$id).'" style="display:inline-block;margin-top:5px;width:100%" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                //     return $actionBtn;
                // })
                ->rawColumns(['image','gst','unit','thumb'])
                ->make(true);
        }
    }
    public function supplylist(Request $request)
    {
        if ($request->ajax()) {
            $brand=$request->brand;
            $item_type=$request->item_type;
           //  $product_id=DB::table('brand_wise_products')->where('brand_id',$brand)->pluck('product_id');
           //  if($item_type=='NA')
           //  {
           // $data = MasterProduct::whereIn('id',$product_id)->get();
           //  }
           //  else
           //  {
           // $data = MasterProduct::whereIn('id',$product_id)->where('item_type','=',$item_type)->get();
           //  }
            
           
            if($item_type=='NA')
            {
           $data = DB::table('brand_wise_products')
            ->join('master_products', 'master_products.id', '=', 'brand_wise_products.product_id')
            ->where([['brand_wise_products.brand_id','=',(int)$brand],['master_products.supply_for','=',1]])
            ->select('master_products.*', 'brand_wise_products.threshold_qty', 'brand_wise_products.brand_id')
            ->get();
            }
            else
            {
            $data = DB::table('brand_wise_products')
            ->join('master_products', 'master_products.id', '=', 'brand_wise_products.product_id')
             ->where([['brand_wise_products.brand_id','=',(int)$brand],['master_products.item_type','=',$item_type],['master_products.supply_for','=',1]])
            ->select('master_products.*', 'brand_wise_products.threshold_qty', 'brand_wise_products.brand_id')
            ->get();
           
            }


            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                  
          $image_data=ItemImages::where([['item_id','=',$row->id],['default','=',1]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="100px">';
          else:
           $image = 'NA';
          endif;
                    return $image;
                })
                  ->addColumn('gst', function($row){
                 if($row->gst_id!=''):
                       $gst_data=MasterGst::find($row->gst_id);
          if($gst_data!='')
          {
            return $gst_data->gst_name;
          }
          else
          {
            return 'Not Updated';
          }
             else:
                return 'Not Updated';
             endif;
                    
                })
                  ->addColumn('unit', function($row){
                 if($row->unit!=''):
          $unit=Unit::find($row->unit);
                 return $unit->unit;
             else:
                return 'Not Updated';
             endif;
                    
                })
                  ->addColumn('thumb', function($row){
                
               $thumb=Brands::find($row->brand_id);
                $output='<p>'.$thumb->brand.'</p>';
            
              return $output;
                    
                })
                 
                // ->addColumn('action', function($row){
                //     $id=CustomHelpers::custom_encrypt($row->id);

                //     $actionBtn = '<a href="#" style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary btn-sm uploads" id="'.$id.'">
                //     <i class="fas fa-edit"></i> Uploads </a> 
                //     <a href="#" style="display:inline-block;margin-top:5px;width:100%" id="'.$id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> 
                //     <a href="'.url('UtensilList-Delete/'.$id).'" style="display:inline-block;margin-top:5px;width:100%" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                //     return $actionBtn;
                // })
                ->rawColumns(['image','gst','unit','thumb'])
                ->make(true);
        }
    }
}

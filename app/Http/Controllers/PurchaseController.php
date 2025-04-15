<?php

namespace App\Http\Controllers;
use App\Models\DailyPurchase;
use App\Models\DailyPurchaseIngredients;
use App\Models\FranchiseStockSalePrice;
use App\Helpers\CustomHelpers;
use Illuminate\Http\Request;
use App\Models\FranchiseStockStatus;
use App\Models\FanchiseRegistration;
use App\Models\ItemImages;
use App\Models\Unit;
use App\Models\MasterGst;
use App\Models\LocalSupplier;
use App\Models\RegionWiseOutlet;
use App\Models\RegionSetting;
use App\Models\User;
use Sentinel;
use DB;
use DataTables;
use Redirect;
class PurchaseController extends Controller
{
    //new_purchase_request
    public function new_purchase_request()
    {
    $val=0;
    return view('outlet.purchase.index_admin',compact('val')); 
    }
    public function ongoing_purchase_request()
    {
    $val=1;
    return view('outlet.purchase.index_admin',compact('val')); 
    }
    public function completed_purchase_request()
    {
    $val=2;
    return view('outlet.purchase.index_admin',compact('val')); 
    }
    public function new_pushbacked_request()
    {
    $val=3;
    return view('outlet.purchase.index_admin',compact('val')); 
    }
    public function new_replied_request()
    {
    $val=4;
    return view('outlet.purchase.index_admin',compact('val')); 
    }
    // 
    public function index()
    {
    $val=0;
    return view('outlet.purchase.index',compact('val')); 
    }
    public function purchase_pushbacked()
    {
    $val=3;
    return view('outlet.purchase.index',compact('val')); 
    }
    public function purchase_replied()
    {
    $val=4;
    return view('outlet.purchase.index',compact('val')); 
    }
    public function approved_purchase()
    {
    $val=1;
    return view('outlet.purchase.index',compact('val')); 
    }
    public function completed_purchase()
    {
    $val=2;
    return view('outlet.purchase.index',compact('val')); 
    }

   public function add_purchase()
    {
    $outlet_id =Sentinel::getUser()->parent_id;
    //
 $stock_update=CustomHelpers::get_update_outlet_stock($outlet_id);
    //
    // $check_area_manager=RegionWiseOutlet::where('outlet_id',$outlet_id)->first();
    // if($check_area_manager=='')
    // {
    //   return Redirect::back()->with('error', 'Not assigned any area manager');  
    // }
    // else
    // {
    //   $ingredients=CustomHelpers::get_outlet_products($outlet_id);
    //  $last=DailyPurchase::where('outlet_id',$outlet_id)->latest()->first(); 
    
    //  if($last=='')
    //  {
    //  $ref_no=1;
    //  }
    //  else
    //  {
    // $ref_no=(int)$last->reference_no+1;
    //  }
    //  $refcode = str_pad($ref_no, 6, '0', STR_PAD_LEFT);
    //  $gsts=MasterGst::all();
    //  $suppliers=LocalSupplier::where('outlet_id',$outlet_id)->get();
    // return view('outlet.purchase.add_purchase',compact('ingredients','refcode','gsts','suppliers'));   
    // }
    
    $ingredients=CustomHelpers::get_outlet_products($outlet_id);
     $last=DailyPurchase::where('outlet_id',$outlet_id)->latest()->first(); 
    
     if($last=='')
     {
     $ref_no=1;
     }
     else
     {
    $ref_no=(int)$last->reference_no+1;
     }
     $refcode = str_pad($ref_no, 6, '0', STR_PAD_LEFT);
     $gsts=MasterGst::all();
     $suppliers=LocalSupplier::where('outlet_id',$outlet_id)->get();
    return view('outlet.purchase.add_purchase',compact('ingredients','refcode','gsts','suppliers')); 

    
    }
   public function store_purchase(Request $request)
    {
    $purchase_ingredients=$request->ingredient_id;
    if($purchase_ingredients=='')
    {
     return Redirect::back()->with('error', 'Pls select ingredients');     
    }
      $outlet_id =Sentinel::getUser()->parent_id;
      $ingredients=CustomHelpers::get_outlet_products($outlet_id);
      $last=DailyPurchase::where('outlet_id')->latest()->first(); 
     if($last=='')
     {
     $ref_no=1;
     }
     else
     {
    $ref_no=(int)$last->reference_no+1;
     }
     $refcode = str_pad($ref_no, 6, '0', STR_PAD_LEFT);
      
      $data=new DailyPurchase;
      $data->reference_no=$refcode;
      $data->date=$request->date;
      $data->subtotal=$request->subtotal;  
      $data->grand_total=$request->grand_total;  
      $data->paid=$request->paid; 
      $data->due=$request->due;  
      $data->supplier=$request->supplier;  
      $data->invoice_no=$request->invoice_no;  
      $data->total_gst=$request->total_gst_s;  
      $data->total_with_gst=$request->total_with_gst_s;  
      $data->user_id=Sentinel::getUser()->id;    
      $data->outlet_id=$outlet_id;  
      $data->del_status='Live'; 

      if($data->save())
      {
        $purchase_ingredients=$request->ingredient_id;
       foreach ($purchase_ingredients as $row => $ingredient_id):
           $new_data=new DailyPurchaseIngredients;
           $new_data->ingredient_id=$request->ingredient_id[$row]; 
           $new_data->unit_price=$request->unit_price[$row]; 
           $new_data->quantity_amount=$request->quantity_amount[$row]; 
           $new_data->total=$request->total[$row]; 
           $new_data->gst_id=CustomHelpers::get_master_table_data('master_gsts','gst_value',$request->gst_percentage[$row],'id'); 
           $new_data->gst_percentage=$request->gst_percentage[$row]; 
           $new_data->total_gst=$request->total_gst[$row]; 
           $new_data->total_with_gst=$request->total_with_gst[$row]; 
           $new_data->purchase_id=$data->id; 
           $new_data->outlet_id=$outlet_id; 
           $new_data->del_status='Live';
           $new_data->save();
        endforeach;
      }
       
     return redirect('/Purchase');     
    }
    public function edit_daily_purchase($id,Request $request)
    {
     $outlet_id =Sentinel::getUser()->parent_id;
     //
   $stock_update=CustomHelpers::get_update_outlet_stock($outlet_id);
    //
     $ingredients=CustomHelpers::get_outlet_products($outlet_id);
     $last=DailyPurchase::where('outlet_id',$outlet_id)->latest()->first(); 

     if($last=='')
     {
     $ref_no=1;
     }
     else
     {
    $ref_no=(int)$last->reference_no+1;
     }
     $refcode = str_pad($ref_no, 6, '0', STR_PAD_LEFT);
     $id=CustomHelpers::custom_decrypt($id);
     $data=DailyPurchase::find($id);
     $purchase_ingredients=DailyPurchaseIngredients::where('purchase_id',$data->id)->get();
     $gsts=MasterGst::all();
     $suppliers=LocalSupplier::where('outlet_id',$outlet_id)->get();
    return view('outlet.purchase.edit_purchase',compact('ingredients','refcode','data','purchase_ingredients','gsts','suppliers')); 
       
    }
    public function enter_daily_purchase($id,Request $request)
    {
     $outlet_id =Sentinel::getUser()->parent_id;
     $ingredients=CustomHelpers::get_outlet_products($outlet_id);
     $last=DailyPurchase::where('outlet_id',$outlet_id)->latest()->first(); 

     if($last=='')
     {
     $ref_no=1;
     }
     else
     {
    $ref_no=(int)$last->reference_no+1;
     }
     $refcode = str_pad($ref_no, 6, '0', STR_PAD_LEFT);
     $id=CustomHelpers::custom_decrypt($id);
     $data=DailyPurchase::find($id);
     $purchase_ingredients=DailyPurchaseIngredients::where('purchase_id',$data->id)->get();
     $gsts=MasterGst::all();
     $suppliers=LocalSupplier::where('outlet_id',$outlet_id)->get();
    return view('outlet.purchase.enter_daily_purchase',compact('ingredients','refcode','data','purchase_ingredients','gsts','suppliers')); 
       
    }
    public function update_daily_purchase($id,Request $request)
    {
        $purchase_ingredients=$request->ingredient_id;
    if($purchase_ingredients=='')
    {
     return Redirect::back()->with('error', 'Pls select ingredients');     
    }

      $outlet_id =Sentinel::getUser()->parent_id;
      $ingredients=CustomHelpers::get_outlet_products($outlet_id);

     $last=DailyPurchase::where('outlet_id')->latest()->first(); 
     if($last=='')
     {
     $ref_no=1;
     }
     else
     {
    $ref_no=(int)$last->reference_no+1;
     }
     $refcode = str_pad($ref_no, 6, '0', STR_PAD_LEFT);
      $id=CustomHelpers::custom_decrypt($id);
      $data=DailyPurchase::find($id);
      
      if($data->status!=0)
      {
        return Redirect::route('approved_purchase')->with('error', 'You Cannot edit this because area manager complete his/her action');  
      }
      else
      {
      // $data->reference_no=$refcode;
      $data->date=$request->date;
      $data->subtotal=$request->subtotal;  
      $data->grand_total=$request->grand_total;  
      $data->paid=$request->paid; 
      $data->due=$request->due;  
      $data->supplier=$request->supplier;  
      $data->invoice_no=$request->invoice_no;  
      $data->total_gst=$request->total_gst_s;  
      $data->total_with_gst=$request->total_with_gst_s;  
      $data->user_id=Sentinel::getUser()->id;    
      $data->outlet_id=$outlet_id;  
      $data->del_status='Live'; 
      
      if($data->save())
      {
        DailyPurchaseIngredients::where('purchase_id',$data->id)->delete();
        $purchase_ingredients=$request->ingredient_id;
       foreach ($purchase_ingredients as $row => $ingredient_id):
           $new_data=new DailyPurchaseIngredients;
           $new_data->ingredient_id=$request->ingredient_id[$row]; 
           $new_data->unit_price=$request->unit_price[$row]; 
           $new_data->quantity_amount=$request->quantity_amount[$row]; 
           $new_data->total=$request->total[$row]; 
           $new_data->purchase_id=$data->id; 
           $new_data->outlet_id=$outlet_id; 
           $new_data->del_status='Live';
           $new_data->gst_id=CustomHelpers::get_master_table_data('master_gsts','gst_value',$request->gst_percentage[$row],'id'); 
           $new_data->gst_percentage=$request->gst_percentage[$row]; 
           $new_data->total_gst=$request->total_gst[$row]; 
           $new_data->total_with_gst=$request->total_with_gst[$row]; 
           $new_data->save();
        endforeach;
      }
       
     return redirect('/Purchase');   
     }  
    }
    public function update_pushbacked_purchase($id,Request $request)
    {
        $purchase_ingredients=$request->ingredient_id;
    if($purchase_ingredients=='')
    {
     return Redirect::back()->with('error', 'Pls select ingredients');     
    }

      $outlet_id =Sentinel::getUser()->parent_id;
      $ingredients=CustomHelpers::get_outlet_products($outlet_id);

     $last=DailyPurchase::where('outlet_id')->latest()->first(); 
     if($last=='')
     {
     $ref_no=1;
     }
     else
     {
    $ref_no=(int)$last->reference_no+1;
     }
     $refcode = str_pad($ref_no, 6, '0', STR_PAD_LEFT);
      $id=CustomHelpers::custom_decrypt($id);
      $data=DailyPurchase::find($id);
      
      if($data->status!=3)
      {
        return Redirect::route('approved_purchase')->with('error', 'You Cannot edit this because area manager complete his/her action');  
      }
      else
      {
      // $data->reference_no=$refcode;
      $data->date=$request->date;
      $data->subtotal=$request->subtotal;  
      $data->grand_total=$request->grand_total;  
      $data->paid=$request->paid; 
      $data->due=$request->due;  
      $data->supplier=$request->supplier;  
      $data->invoice_no=$request->invoice_no;  
      $data->total_gst=$request->total_gst_s;  
      $data->total_with_gst=$request->total_with_gst_s;  
      $data->user_id=Sentinel::getUser()->id;    
      $data->outlet_id=$outlet_id; 
      $data->status=4;   
      $data->del_status='Live'; 
      
      if($data->save())
      {
        DailyPurchaseIngredients::where('purchase_id',$data->id)->delete();
        $purchase_ingredients=$request->ingredient_id;
       foreach ($purchase_ingredients as $row => $ingredient_id):
           $new_data=new DailyPurchaseIngredients;
           $new_data->ingredient_id=$request->ingredient_id[$row]; 
           $new_data->unit_price=$request->unit_price[$row]; 
           $new_data->quantity_amount=$request->quantity_amount[$row]; 
           $new_data->total=$request->total[$row]; 
           $new_data->purchase_id=$data->id; 
           $new_data->outlet_id=$outlet_id; 
           $new_data->del_status='Live';
           $new_data->gst_id=CustomHelpers::get_master_table_data('master_gsts','gst_value',$request->gst_percentage[$row],'id'); 
           $new_data->gst_percentage=$request->gst_percentage[$row]; 
           $new_data->total_gst=$request->total_gst[$row]; 
           $new_data->total_with_gst=$request->total_with_gst[$row]; 
           $new_data->save();
        endforeach;
      }
       
     return redirect('/Purchase-Pushbacked');   
     }  
    }
    public function update_daily_purchase_reedit($id,Request $request)
    {
    $purchase_ingredients=$request->ingredient_id;
    if($purchase_ingredients=='')
    {
     return Redirect::back()->with('error', 'Pls select ingredients');     
    }

      $outlet_id =Sentinel::getUser()->parent_id;
      $ingredients=CustomHelpers::get_outlet_products($outlet_id);

     $last=DailyPurchase::where('outlet_id')->latest()->first(); 
     if($last=='')
     {
     $ref_no=1;
     }
     else
     {
    $ref_no=(int)$last->reference_no+1;
     }
     $refcode = str_pad($ref_no, 6, '0', STR_PAD_LEFT);
      $id=CustomHelpers::custom_decrypt($id);
      $data=DailyPurchase::find($id);
      
      if($data->status==1)
      {
        
      // $data->reference_no=$refcode;
      $data->date=$request->date;
      $data->subtotal=$request->subtotal;  
      $data->grand_total=$request->grand_total;  
      $data->paid=$request->paid; 
      $data->due=$request->due;  
      $data->supplier=$request->supplier;  
      $data->invoice_no=$request->invoice_no;  
      $data->total_gst=$request->total_gst_s;  
      $data->total_with_gst=$request->total_with_gst_s;  
      $data->user_id=Sentinel::getUser()->id;    
      $data->outlet_id=$outlet_id; 
      $data->status=0;   
      $data->del_status='Live'; 
      
      if($data->save())
      {
        DailyPurchaseIngredients::where('purchase_id',$data->id)->delete();
        $purchase_ingredients=$request->ingredient_id;
       foreach ($purchase_ingredients as $row => $ingredient_id):
           $new_data=new DailyPurchaseIngredients;
           $new_data->ingredient_id=$request->ingredient_id[$row]; 
           $new_data->unit_price=$request->unit_price[$row]; 
           $new_data->quantity_amount=$request->quantity_amount[$row]; 
           $new_data->total=$request->total[$row]; 
           $new_data->purchase_id=$data->id; 
           $new_data->outlet_id=$outlet_id; 
           $new_data->del_status='Live';
           $new_data->gst_id=CustomHelpers::get_master_table_data('master_gsts','gst_value',$request->gst_percentage[$row],'id'); 
           $new_data->gst_percentage=$request->gst_percentage[$row]; 
           $new_data->total_gst=$request->total_gst[$row]; 
           $new_data->total_with_gst=$request->total_with_gst[$row]; 
           $new_data->save();
        endforeach;
      }
       
     return redirect('/Purchase');   
     }  
     else
     {
        return Redirect::route('approved_purchase')->with('error', 'You Cannot edit this because you already completed daily entry');  
     }
    }
    public function update_enter_daily_purchase($id,Request $request)
    {
    $purchase_ingredients=$request->ingredient_id;
    if($purchase_ingredients=='')
    {
     return Redirect::back()->with('error', 'Pls select ingredients');     
    }

      $outlet_id =Sentinel::getUser()->parent_id;
      $ingredients=CustomHelpers::get_outlet_products($outlet_id);

     $last=DailyPurchase::where('outlet_id')->latest()->first(); 
     if($last=='')
     {
     $ref_no=1;
     }
     else
     {
    $ref_no=(int)$last->reference_no+1;
     }
     $refcode = str_pad($ref_no, 6, '0', STR_PAD_LEFT);
      $id=CustomHelpers::custom_decrypt($id);
      $data=DailyPurchase::find($id);
      
      if($data->status==1)
      {
        
      // $data->reference_no=$refcode;
      $data->date=$request->date;
      // $data->subtotal=$request->subtotal;  
      // $data->grand_total=$request->grand_total;  
      // $data->paid=$request->paid; 
      // $data->due=$request->due;  
      $data->supplier=$request->supplier;  
      $data->invoice_no=$request->invoice_no;  
      // $data->total_gst=$request->total_gst_s;  
      // $data->total_with_gst=$request->total_with_gst_s;  
      $data->user_id=Sentinel::getUser()->id;    
      $data->outlet_id=$outlet_id; 
      $data->status=2;   
      $data->del_status='Live'; 
      
      if($data->save())
      {

        $ingredients=DailyPurchaseIngredients::where('purchase_id',$data->id)->get();
        
        foreach($ingredients as $ingredient)
        {
          $new_data=FranchiseStockSalePrice::where([['product_id',$ingredient->ingredient_id],['outlet_id',$outlet_id]])->first();

          $available_qty_data=$new_data->available_qty;
          $purchase_qty=$ingredient->quantity_amount;
          $new_qty=(float)$available_qty_data+(float)$purchase_qty;
          $new_data->available_qty=$new_qty;
          $new_data->save(); 

        }
      
      }
       
     return redirect('/Completed-Purchase')->with('success', 'Successfully added into your stock');   
     }  
     else
     {
        return Redirect::route('approved_purchase')->with('error', 'You Cannot edit this because you already completed daily entry');  
     }
    }
    public function view_daily_purchase(Request $request)
    {
       $id=CustomHelpers::custom_decrypt($request->id);
       $data=DailyPurchase::find($id);
       $purchase_ingredients=DailyPurchaseIngredients::where('purchase_id',$data->id)->get();
       $options = view("outlet.purchase.view_daily_purchase",compact('data','purchase_ingredients'))->render();


       echo $options;

    }
    public function get_purchase_list_admin(Request $request)
    {
        if ($request->ajax()) {
        $id =Sentinel::getUser()->id;
        $region_ids=RegionSetting::where('assign_area_manager',$id)->pluck('id');
        $outlet_ids=RegionWiseOutlet::whereIn('region_id',$region_ids)->pluck('outlet_id');
        $val=$request->val;   
            $data = DailyPurchase::where('status',$val)->whereIn('outlet_id',$outlet_ids)->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
            
                ->addColumn('outlet_details', function($row){
                   $outlet_id=$row->outlet_id;
$rows_data=User::find($outlet_id);
$outlet_details="<b>ID:</b> $rows_data->email
                 <hr style='padding:0px;margin:0px'>
                 <b>Name:</b> $rows_data->name
                 <hr style='padding:0px;margin:0px'>
                 <b>Mobile:</b> $rows_data->mobile
                 <hr style='padding:0px;margin:0px'>
                <b>State:</b> $rows_data->state
                             <hr style='padding:0px;margin:0px'>
                             <b>City:</b> $rows_data->city";

                return $outlet_details;
                })
                ->addColumn('date', function($row){
                   return date('d-m-Y', strtotime($row->date));
                    
                })
                ->addColumn('supplier_name', function($row){
                   $supplier_name=CustomHelpers::get_master_table_data('local_suppliers','id',$row->supplier,'supplier_name');
                   return $supplier_name;
                    
                })  
                
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);
                     if($row->status==0 || $row->status==4)
                     {
$actionBtn = '<div class="button_flex">

<a href="#" class="pushback button_left"  id="'.$id.'" title="Pushback Daily Purchase"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-success"><span class="fa fa-arrow-left"></span> </button>   </a> 

                    <a href="#" class="view button_left" id="'.$id.'" title="View Daily Purchase"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary">
                    <span class="fa fa-eye"></span> </button></a>

                    <a href="#" class="accept button_left"  id="'.$id.'" title="Accept Daily Purchase"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-success"><span class="fa fa-check"></span> </button>   </a> 
                    
                    </div>
                   ';
                     }
                     elseif($row->status==1)
                     {
$actionBtn = '<div class="button_flex">
                    <a href="#" class="view button_left" id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary"><span class="fa fa-eye"></span> </button></a>

                   
                    
                    </div>
                   ';
                     }
                     elseif($row->status=2)
                     {
$actionBtn = '<div class="button_flex">
                    <a href="#" class="view button_left" id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary"><span class="fa fa-eye"></span> </button></a>

                   
                    </div>
                   ';
                     }
                    
                    return $actionBtn;
                })
                ->rawColumns(['date','action','outlet_details','supplier_name'])
                ->make(true);
        }

    }
    public function get_purchase_list(Request $request)
    {
        if ($request->ajax()) {
        $outlet_id =Sentinel::getUser()->parent_id;
        $val=$request->val;   
            $data = DailyPurchase::where([['outlet_id','=',(int)$outlet_id],['status',$val]])->latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
            
             
                ->addColumn('date', function($row){
                   return date('d-m-Y', strtotime($row->date));
                    
                })
                ->addColumn('supplier_name', function($row){
                   $supplier_name=CustomHelpers::get_master_table_data('local_suppliers','id',$row->supplier,'supplier_name');
                   return $supplier_name;
                    
                }) 
                
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);
                     if($row->status==0)
                     {
$actionBtn = '<div class="button_flex">
                    <a href="#" class="view button_left" id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary"><span class="fa fa-eye"></span> </button></a>

                    <a href="'.url("Edit-Daily-Purchase/".$id).'" class="button_left"  id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-success"><span class="fa fa-edit"></span> </button>   </a> 
                     <a href="#" class="button_left" id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-danger delete" id="'.$id.'" ><span class="fa fa-archive"></span> </button></a>
                    </div>
                   ';
                     }
                      elseif($row->status==3)
                     {
$actionBtn = '<div class="button_flex">
                    <a href="#" class="view button_left" id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary"><span class="fa fa-eye"></span> </button></a>

                    <a href="'.url("Edit-Pushbacked-Purchase/".$id).'" class="button_left"  id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-success"><span class="fa fa-edit"></span> </button>   </a> 
                    
                    </div>
                   ';
                     }
                     elseif($row->status==1)
                     {
$actionBtn = '<div class="button_flex">
                    <a href="#" class="view button_left" id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary"><span class="fa fa-eye"></span> </button></a>

                    <a href="'.url("Enter-Daily-Purchase/".$id).'" class="button_left"  id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-success"><span class="fa fa-edit"></span> </button>   </a> 
                    
                    <a href="'.url("Reedit-Daily-Purchase/".$id).'" class="button_left"  id="'.$id.'" title="Re-Edit Daily Purchase"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-info"><span class="fa fa-arrow-left"></span> </button>   </a>

                    </div>
                   ';
                     }
                     elseif($row->status=2)
                     {
$actionBtn = '<div class="button_flex">
                    <a href="#" class="view button_left" id="'.$id.'"><button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary"><span class="fa fa-eye"></span> </button></a>

                   
                    </div>
                   ';
                     }
                    
                    return $actionBtn;
                })
                ->rawColumns(['date','action','supplier_name'])
                ->make(true);
        }

    }
     public function delete_daily_purchase(Request $request)
    {
    $id=CustomHelpers::custom_decrypt($request->id);
    $data=DailyPurchase::find($id);
    if($data->status!=0)
      {
        echo 'You Cannot edit this because area manager complete his/her action'; 
      
      }
      else
      {
    $outlet_id =Sentinel::getUser()->parent_id;
     
     $id=CustomHelpers::custom_decrypt($request->id);

     $data=DailyPurchase::find((int)$id);

     $purchase_ingredients=DailyPurchaseIngredients::where('purchase_id',$data->id)->delete();
     DailyPurchase::destroy($id);
     echo 'success'; 
      }
   
       
    } 
    public function accept_daily_purchase(Request $request)
    {
    $id=CustomHelpers::custom_decrypt($request->id);
    $data=DailyPurchase::find($id);
    $data->status=1;
    $data->accept_date=date('Y-m-d');
    $data->accept_admin_id=Sentinel::getUser()->id; 
    $data->save();
     echo 'success'; 
     
   
       
    }
    public function pushback_daily_purchase(Request $request)
    {
    $id=CustomHelpers::custom_decrypt($request->id);
    $data=DailyPurchase::find($id);
    $data->status=3;
    $data->note=$request->remarks;
    
    $data->save();
     echo 'success'; 
     
   
       
    }
}

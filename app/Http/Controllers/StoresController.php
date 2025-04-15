<?php

namespace App\Http\Controllers;

use App\Models\StoreSetting;
use App\Models\Stores;
use Illuminate\Http\Request;
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
use Sentinel;
use DB;
use DataTables;
use App\Models\SupplyItemList;
use App\Models\AssignProductFactoryVendor;
use App\Models\OrderPayment;
use App\Models\OrderItemDetails;
use App\Models\WharehouseCart;
use App\Models\WharehouseOrder;
use App\Models\WharehouseOrderDetails;
use App\Models\FactoryCart;
use App\Models\FactoryOrder;
use App\Models\FactoryOrderDetails;
use App\Models\FactoryIngredients;
use App\Models\WharehouseFactoryInvoiceByFactoryVendor;
use App\Models\MasterProduct;

class StoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }
    public function manage_stores()
    {
        
        $datas=Stores::where('type','=',1)->whereIn('status',[1,2])->get();
        return view('admin.stores.index',compact('datas'));
    }
    public function manage_factory()
    {
        
        $datas=Stores::where('type','=',2)->whereIn('status',[1,2])->get();
        return view('admin.factory.index',compact('datas'));
    }
    public function manage_store_product()
    {
       $datas=Stores::where('type','=',1)->whereIn('status',[1,2])->get();
       return view('admin.stores.manage_store_product',compact('datas')); 
    }
     public function manage_store_order()
    {
       $datas=Stores::where('type','=',1)->whereIn('status',[1,2])->get();
       return view('admin.stores.manage_store_order',compact('datas')); 
    }
    public function completed_franchise_orders()
    {
       $datas=Stores::where('type','=',1)->whereIn('status',[1,2])->get();
       return view('admin.stores.manage_store_order',compact('datas')); 
    }
    public function manage_factory_product()
    {
       $datas=Stores::where('type','=',2)->whereIn('status',[1,2])->get();
       return view('admin.factory.manage_factory_product',compact('datas')); 
    }
    public function manage_vendor_product()
    {
     
       $loged_user=Sentinel::getUser();
        $datas = User::where([['registration_level','=',5],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();

       return view('admin.vendor.manage_vendor_product',compact('datas')); 
    }

    public function manage_factory_orders()
    {

       $datas=Stores::where('type','=',2)->whereIn('status',[1,2])->get();
       return view('admin.factory.manage_factory_orders',compact('datas')); 
    }
      public function manage_vendor_orders()
    {

       $loged_user=Sentinel::getUser();
        $datas = User::where([['registration_level','=',5],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
       return view('admin.vendor.franchise.manage_vendor_orders',compact('datas')); 
    }
     public function new_factory_order_from_wharehouse()
    {
        
       $datas=Stores::where('type','=',2)->whereIn('status',[1,2])->get();
       // $data=DB::table('wharehouse_order_details')
       //         ->where('status','=','1')
       //         ->get()->groupBy('wharehouse_order_id');
       //         dd($data);
       return view('admin.factory.new_factory_order_from_wharehouse',compact('datas')); 
    }
     public function new_vendor_order_from_wharehouse()
    {
        
       $loged_user=Sentinel::getUser();
        $datas = User::where([['registration_level','=',5],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
       return view('admin.vendor.wharehouse.new_vendor_order_from_wharehouse',compact('datas')); 
    }
    public function new_vendor_order_from_factory()
    {
        
       $loged_user=Sentinel::getUser();
        $datas = User::where([['registration_level','=',5],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
       return view('admin.vendor.factory.new_vendor_order_from_factory',compact('datas')); 
    }

    public function get_store_order(Request $request)
    {

     if ($request->ajax()) {
            $store_id=$request->store;
            $order=$request->order_status; 

            if($order==1):
                $data = OrderPayment::where([['assign_order_to_warehouse_id','=',$store_id],['status','=',1]])->get();
            elseif($order==2):
                 $data = OrderPayment::where([['assign_order_to_warehouse_id','=',$store_id],['status','=',4]])->get();
            elseif($order==3):
           $data = OrderPayment::where([['assign_order_to_warehouse_id','=',$store_id],['status','=',3]])->get();
            endif; 
           
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('order_id', function($row){
                   
                  return $row->id;
                    
                })
                ->addColumn('order_date', function($row){
                    
                   
                   return $row->created_at;
                })
                ->addColumn('transaction_id', function($row){
                    return $row->transaction_id;
                })
                 ->addColumn('amount', function($row){
                     return $row->amount;
                })
                  ->addColumn('status', function($row){
                    $output='';
                    if($row->status==0):
                      $item_count_order=CustomHelpers::get_order_placed_count($row->id);
                        $output.=$item_count_order.' Items  Order Placed';
                    elseif($row->status==1):
                        $output.=CustomHelpers::get_order_placed_count($row->id).' Items Order Confirmed ';
                    elseif($row->status==3):
                        $output.=CustomHelpers::get_order_placed_count($row->id).' Items Order Completed ';

                    elseif($row->status==4):
                        $output.=CustomHelpers::get_order_placed_count($row->id).' Items Order Ongoing ';
                    endif;

                    if(CustomHelpers::get_order_dispatched_notification_order_wise($row->id)>0):
                        $url=url('resources\assets\new.gif');
                     $output.=CustomHelpers::get_order_dispatched_notification_order_wise($row->id).' Item Dispatch <img src="'.$url.'">';   
                  endif;
                  if(CustomHelpers::get_order_dilivered_count($row->id)>0):
$output.='<p style="color:green"> '.CustomHelpers::get_order_dilivered_count($row->id).' Items Delivered</p>';
                  else:
                    $output.='<p style="color:red"> '.CustomHelpers::get_order_dilivered_count($row->id).' Items Delivered</p>';

                  endif;
                  
     return $output;
 

                })
                 
       
         
     
        
       
       

                ->addColumn('action', function($row){
                    $id=$row->id;
                    $actionBtn = '<a href="'.url('Order-Invoice/'.CustomHelpers::custom_encrypt($row->id)).'" style="display:inline-block;margin-top:5px;width:100%"  class="btn btn-info btn-sm view_invoice">
<span class="fa fa-file-pdf"></span> View Invoice 
</a>
 <a href="#" style="display:inline-block;margin-top:5px;width:100%"  class="btn btn-sm btn-success take_action" id="'.CustomHelpers::custom_encrypt($row->id).'">
<span class="fa fa-eye"></span> View Order
</a>
';

                  
                    return $actionBtn;
                })
                ->rawColumns(['order_id','order_date','transaction_id','amount','action','status'])
                ->make(true);
        }

    }
    public function get_store_product(Request $request)
    {

     if ($request->ajax()) {
            $store_id=$request->store;

            $data = StoreProduct::where('store_id','=',$store_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
             
                ->addColumn('image', function($row){
                    
                   $image_data=ItemImages::where([['item_id','=',$row->product_id],['default','=',1]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="100px">';
          else:
           $image = 'NA';
          endif;
                    return $image;
                })
                ->addColumn('name', function($row){
                   $name=CustomHelpers::get_master_table_data('master_products','id',$row->product_id,'product_name');
                    return $name;
                })
                 ->addColumn('status', function($row){
                    if ($row->status==1)
             {
    $status= "<p style='background:green;color:white;padding:2px 5px;text-align:center'>Enabled</p>";
              }
             else
             {
    $status="<p style='background:#dd4b39;color:white;padding:2px 5px;text-align:center'>Disabled</p>";
               }
                    return $status;
                })
                 ->addColumn('unit', function($row){
                   $unit_id=CustomHelpers::get_master_table_data('master_products','id',$row->product_id,'unit');
                    if($unit_id!='NA'):
                  $unit=Unit::find($unit_id);
                 return $unit->unit;
                   else:
                    return 'NA';
                  endif;
                  
                

                  
                })
                  ->addColumn('available_qty', function($row){
                  
                  $output=$row->available_qty;
                  
                  if($row->available_qty=='' || $row->available_qty<=$row->threshold_qty)
                  {
                    $output.="<p style='background:#dd4b39;color:white;padding:2px 5px;text-align:center'>Low QTY</p>";
                  }
                 return $output;
                  
                })
                ->addColumn('action', function($row){
                    $id=$row->id;
                   if ($row->status==1):
  
    $actionBtn = '<button style="display:inline-block;margin-top:5px;width:100%" class="btn btn-danger btn-sm disable" id="'.$row->id.'"><span class="fa fa-times"></span> Disable </button>';
   
            else:

    $actionBtn = '<button class="btn btn-warning btn-sm enable" style="display:inline-block;margin-top:5px;width:100%" id="'.$row->id.'"><span class="fa fa-check"></span> Enable  </button>';
   
  
              endif;
              $cart_check=WharehouseCart::where([['wharehouse_id','=',$row->store_id],['wharehouse_product_id','=',$row->id]])->first();
              if($cart_check==''):
                    $actionBtn .= '
                    <button item_id="'.$row->id.'" store_id="'.$row->store_id.'" class="add_to_cart btn btn-info btn-sm"  style="display:inline-block;margin-top:5px;width:100%"> <i class="fas fa-shopping-cart"></i> Add </button>';
                else:
                     $actionBtn .= '
                    <button item_id="'.$row->id.'" store_id="'.$row->store_id.'" class="btn btn-info btn-sm"  style="display:inline-block;margin-top:5px;width:100%">  Added </button>'; 
                endif;
                $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn.= '
                    <a href="#" style="display:inline-block;margin-top:5px;width:100%" id="'.$id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit QTY</a> 
                   ';

                    return $actionBtn;
                })
                ->rawColumns(['image','name','unit','action','status','available_qty'])
                ->make(true);
        }

    }
     public function edit_wharehouse_stock(Request $request)
   {

    $id=CustomHelpers::custom_decrypt($request->id);
    $loged_user=Sentinel::getUser();
   
     $data=StoreProduct::find($id); 

    $options = view('admin.stores.edit_wharehouse_stock',compact('data'))->render();
    echo $options;


   }
   public function update_wharehouse_product_list(Request $request)
   {

    $id=CustomHelpers::custom_decrypt($request->id);
    $loged_user=Sentinel::getUser();
   
     $data=StoreProduct::find($id); 
      $data->available_qty=$request->available_qty;
      $data->save();
     echo 'success';


   }
     public function get_factory_outlet_orders(Request $request)
    {

     if ($request->ajax()) {
            $store_id=$request->store;
            $order=$request->order_status; 
            if($order==1):
                $data = OrderItemDetails::where([['factory_vendor_id','=',$store_id],['status','=','3']])->get();
            elseif($order==2):
                $data = OrderItemDetails::where([['factory_vendor_id','=',$store_id],['status','=','4']])->get();
            elseif($order==3):  
            $data = OrderItemDetails::where([['factory_vendor_id','=',$store_id],['status','=','7']])->get();  
            endif;
            

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('order_id', function($row){
                  
                   return $row->order_id;
                    
                })
               
                ->addColumn('order_date', function($row){
                  return $row->assign_date;
                })
                
                 ->addColumn('product_name', function($row){
                   return $row->product_name;

                  
                })
                  ->addColumn('qty', function($row){
                   return $row->order_qty;

                  
                })
                ->addColumn('action', function($row){
                    if($row->status==3):
                    $id=CustomHelpers::custom_encrypt($row->id);
                  
                    $actionBtn = ' <a href="#" id="'.$id.'" class="take_action btn btn-success btn-sm"><i class="fas fa-edit"></i> Take Action </a> ';
                   elseif($row->status==4):
                   $actionBtn = ' <a href="#"  class="btn btn-success btn-sm"><i class="fa fa-truck"></i> Dispatched </a> ';
                   elseif($row->status==7):
                      $actionBtn = ' <a href="#"  class="btn btn-success btn-sm"><i class="fa fa-check"></i> Delivered </a> ';
                   endif;
                    return $actionBtn;
                })
                ->rawColumns(['order_id','order_date','product_name','qty','action',])
                ->make(true);
        }

    }
    public function get_vendor_outlet_orders(Request $request)
    {

     if ($request->ajax()) {
            $store_id=$request->store;
            $order=$request->order_status; 
            if($order==1):
                $data = OrderItemDetails::where([['factory_vendor_id','=',$store_id],['status','=','5']])->get();
            elseif($order==2):
                $data = OrderItemDetails::where([['factory_vendor_id','=',$store_id],['status','=','6']])->get();
            elseif($order==3):  
            $data = OrderItemDetails::where([['factory_vendor_id','=',$store_id],['status','=','7']])->get();  
            endif;
            

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('order_id', function($row){
                  
                   return $row->order_id;
                    
                })
               
                ->addColumn('order_date', function($row){
                  return $row->assign_date;
                })
                
                 ->addColumn('product_name', function($row){
                   return $row->product_name;

                  
                })
                  ->addColumn('qty', function($row){
                   return $row->order_qty;

                  
                })
                ->addColumn('action', function($row){
                    $actionBtn='';
                    if($row->status==3 || $row->status==5):
                    $id=CustomHelpers::custom_encrypt($row->id);
                  
                    $actionBtn = ' <a href="#" id="'.$id.'" class="take_action btn btn-success btn-sm"><i class="fas fa-edit"></i> Take Action </a> ';
                   elseif($row->status==4 || $row->status==6):
                   $actionBtn = ' <a href="#"  class="btn btn-success btn-sm"><i class="fa fa-truck"></i> Dispatched </a> ';
                   elseif($row->status==7):
                      $actionBtn = ' <a href="#"  class="btn btn-success btn-sm"><i class="fa fa-check"></i> Delivered </a> ';
                   endif;
                    return $actionBtn;
                })
                ->rawColumns(['order_id','order_date','product_name','qty','action',])
                ->make(true);
        }

    }
    public function get_factory_wharehouse_orders(Request $request)
    {

     if ($request->ajax()) {
            $store_id=$request->store;
            $order=$request->order_status; 
            $assign_type=$request->assign_type; 
            if($order==1):
               $data=DB::table('wharehouse_order_details')
               ->where([['factory_vendor_id','=',$store_id],['assign_type','=',$assign_type]])
               ->whereIn('status',[1,4])
               ->get()->groupBy('wharehouse_order_id');
              

                // $data = WharehouseOrderDetails::where([['factory_vendor_id','=',$store_id],['status','=','1'],['assign_type','=',$assign_type]])->get();
            elseif($order==2):
                  $data=DB::table('wharehouse_order_details')
               ->where([['factory_vendor_id','=',$store_id],['assign_type','=',$assign_type]])
               ->whereIn('status',[5,6])
               ->get()->groupBy('wharehouse_order_id');

                // $data = WharehouseOrderDetails::where([['factory_vendor_id','=',$store_id],['assign_type','=',$assign_type]])->whereIn('status',[5,6])->get();
            elseif($order==3):  

                 $data=DB::table('wharehouse_order_details')
               ->where([['factory_vendor_id','=',$store_id],['assign_type','=',$assign_type]])
               ->whereIn('status',[2])
               ->get()->groupBy('wharehouse_order_id');

            // $data = WharehouseOrderDetails::where([['factory_vendor_id','=',$store_id],['status','=','2'],['assign_type','=',$assign_type]])->get();  
          elseif($order==4): 
          $data=DB::table('wharehouse_order_details')
               ->where([['factory_vendor_id','=',$store_id],['assign_type','=',$assign_type]])
               ->whereIn('status',[3])
               ->get()->groupBy('wharehouse_order_id'); 
            // $data = WharehouseOrderDetails::where([['factory_vendor_id','=',$store_id],['status','=','3'],['assign_type','=',$assign_type]])->get();  
            endif;
            

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('order_id', function($row){
                  
                   return  $row['0']->wharehouse_order_id;
                    
                })
               
               
                
                 ->addColumn('factory_name', function($row){

                    return CustomHelpers::get_master_table_data('stores','id',$row['0']->wharehouse_id,'name');
                  

                  
                })
                   ->addColumn('status', function($row){
                 
                   $status='Ordered Items: '.CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'ordered_item');
                   if(CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'action_pending')>0):
                   $status.='<hr style="margin:0px;padding:0px">Pending Action: '.CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'action_pending');
                  endif;
                  if(CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'replied_to_ac')>0):
                   $status.='<hr style="margin:0px;padding:0px">Replied to A/C: '.CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'replied_to_ac');
                  endif;
                  if(CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'view_accept_pending')>0):
                   $status.='<hr style="margin:0px;padding:0px">View & Accept Pending: '.CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'view_accept_pending');
                  endif;
                  if(CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'accepted')>0):
                   $status.='<hr style="margin:0px;padding:0px">Accepted: '.CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'accepted');
                  endif;
                  if(CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'dispatch')>0):
                   $status.='<hr style="margin:0px;padding:0px">Dispatched: '.CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'dispatch');
                 endif;

                 if(CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'delivered')>0):
                   $status.='<hr style="margin:0px;padding:0px">Delivered: '.CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'delivered');
                  endif;
                   return $status;

                  
                })
                ->addColumn('action', function($row){
                    $action='';
                    
                      $order_details_id=$row['0']->id;
                     $order_status=CustomHelpers::get_master_table_data('wharehouse_order_details','id',$order_details_id,'status');
                     if($order_status==1):
                     $action.= '<a href="#" id="'.CustomHelpers::custom_encrypt($row['0']->wharehouse_order_id).'" class="take_action btn btn-success btn-sm" style="display:inline-block;margin-top:5px;width:100%"><i class="fas fa-edit"></i> Send Quote </a>';
                   elseif($order_status==4):
                    $action.= '<a href="#" id="'.CustomHelpers::custom_encrypt($row['0']->wharehouse_order_id).'" class="take_action btn btn-success btn-sm" style="display:inline-block;margin-top:5px;width:100%"><i class="fas fa-edit"></i> Edit Quote </a>';
                     elseif($order_status==5):
                    $action.= '<a href="#" id="'.CustomHelpers::custom_encrypt($row['0']->wharehouse_order_id).'" class="take_action btn btn-success btn-sm" style="display:inline-block;margin-top:5px;width:100%"><i class="fas fa-edit"></i> View & Accept </a>';
                     elseif($order_status==6):
                    $action.= '<a href="#" id="'.CustomHelpers::custom_encrypt($row['0']->wharehouse_order_id).'" class="dispatch btn btn-success btn-sm" style="display:inline-block;margin-top:5px;width:100%"><i class="fas fa-edit"></i> Dispatch </a>';
                     endif;      
                      $action.= '<a href="#" class="btn btn-sm btn-info whare_house_order_view" style="display:inline-block;margin-top:5px;width:100%"  id="'.CustomHelpers::custom_encrypt($row['0']->wharehouse_order_id).'" ><span class="fa fa-eye"></span>  View </a>';
                    return $action;
                })
                ->rawColumns(['order_id','factory_name','action','status'])
                ->make(true);
        }

    }
       public function get_vendor_factory_orders(Request $request)
    {

     if ($request->ajax()) {
            $store_id=$request->store;
            $order=$request->order_status; 
            $assign_type=$request->assign_type; 
            if($order==1):

      $data=DB::table('factory_order_details')
               ->where([['factory_vendor_id','=',$store_id],['assign_type','=',$assign_type]])
               ->whereIn('status',[1,4])
               ->get()->groupBy('factory_order_id');

        // $data = FactoryOrderDetails::where([['factory_vendor_id','=',$store_id],['status','=','1'],['assign_type','=',$assign_type]])->get();

                
            elseif($order==2):
                 $data=DB::table('factory_order_details')
               ->where([['factory_vendor_id','=',$store_id],['assign_type','=',$assign_type]])
               ->whereIn('status',[5,6])
               ->get()->groupBy('factory_order_id');
                // $data = FactoryOrderDetails::where([['factory_vendor_id','=',$store_id],['assign_type','=',$assign_type]])->whereIn('status',[4,5,6])->get();
            elseif($order==3):  
                 $data=DB::table('factory_order_details')
               ->where([['factory_vendor_id','=',$store_id],['assign_type','=',$assign_type]])
               ->whereIn('status',[2])
               ->get()->groupBy('factory_order_id');
            // $data = FactoryOrderDetails::where([['factory_vendor_id','=',$store_id],['status','=','2'],['assign_type','=',$assign_type]])->get();  
        elseif($order==4):  
             $data=DB::table('factory_order_details')
               ->where([['factory_vendor_id','=',$store_id],['assign_type','=',$assign_type]])
               ->whereIn('status',[3])->get()->groupBy('factory_order_id');
            // $data = FactoryOrderDetails::where([['factory_vendor_id','=',$store_id],['status','=','3'],['assign_type','=',$assign_type]])->get();  
            endif;
            

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('order_id', function($row){
                  
                  return  $row['0']->factory_order_id;
                    
                })
               
               
                
                  ->addColumn('factory_name', function($row){

                    return CustomHelpers::get_master_table_data('stores','id',$row['0']->factory_id ,'name');
                  
                })
                 ->addColumn('status', function($row){
                 
                   $status='Ordered Items: '.CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'ordered_item');
                   if(CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'action_pending_account')>0):
                   $status.='<hr style="margin:0px;padding:0px">Pending Action: '.CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'action_pending_account');
                  endif;
                   if(CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'action_pending')>0):
                   $status.='<hr style="margin:0px;padding:0px">Pending Factory/Vendor: '.CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'action_pending');
                  endif;
                  if(CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'replied_to_ac')>0):
                   $status.='<hr style="margin:0px;padding:0px">Replied to A/C: '.CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'replied_to_ac');
                  endif;
                  if(CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'view_accept_pending')>0):
                   $status.='<hr style="margin:0px;padding:0px">View & Accept Pending: '.CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'view_accept_pending');
                  endif;
                  if(CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'accepted')>0):
                   $status.='<hr style="margin:0px;padding:0px">Accepted: '.CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'accepted');
                  endif;
                  if(CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'dispatch')>0):
                   $status.='<hr style="margin:0px;padding:0px">Dispatched: '.CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'dispatch');
                 endif;

                 if(CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'delivered')>0):
                   $status.='<hr style="margin:0px;padding:0px">Delivered: '.CustomHelpers::get_factory_order_status_count($row['0']->factory_order_id,'delivered');
                  endif;
                   return $status;

                  
                }) 
                ->addColumn('action', function($row){
                    $action='';
                    
                      $order_details_id=$row['0']->id;
                     $order_status=CustomHelpers::get_master_table_data('factory_order_details','id',$order_details_id,'status');
                     if($order_status==1):
                     $action.= '<a href="#" id="'.CustomHelpers::custom_encrypt($row['0']->factory_order_id).'" class="take_action btn btn-success btn-sm" style="display:inline-block;margin-top:5px;width:100%"><i class="fas fa-edit"></i> Send Quote </a>';
                   elseif($order_status==4):
                    $action.= '<a href="#" id="'.CustomHelpers::custom_encrypt($row['0']->factory_order_id).'" class="take_action btn btn-success btn-sm" style="display:inline-block;margin-top:5px;width:100%"><i class="fas fa-edit"></i> Edit Quote </a>';
                     elseif($order_status==5):
                    $action.= '<a href="#" id="'.CustomHelpers::custom_encrypt($row['0']->factory_order_id).'" class="take_action btn btn-success btn-sm" style="display:inline-block;margin-top:5px;width:100%"><i class="fas fa-edit"></i> View & Accept </a>';
                     elseif($order_status==6):
                    $action.= '<a href="#" id="'.CustomHelpers::custom_encrypt($row['0']->factory_order_id).'" class="dispatch btn btn-success btn-sm" style="display:inline-block;margin-top:5px;width:100%"><i class="fas fa-edit"></i> Dispatch </a>';
                     endif;      
                      $action.= '<a href="#" class="btn btn-sm btn-info whare_house_order_view" style="display:inline-block;margin-top:5px;width:100%"  id="'.CustomHelpers::custom_encrypt($row['0']->factory_order_id).'" ><span class="fa fa-eye"></span>  View </a>';
                    return $action;
                })
                ->rawColumns(['order_id','factory_name','action','status'])
                ->make(true);
        }

    }
     public function send_quote_by_factory_to_accounts(Request $request)
    {
   $id=CustomHelpers::custom_decrypt($request->id);
   $data=WharehouseOrderDetails::find($id);
    $output=' <input type="hidden" name="id" id="order_item_id" value="'.$request->id.'">  
         <div class="row">
  
 <div class="col-md-6">
     <div class="form-group">
          <label for="">Estimated cost</label>
          <input type="test" name="est_cost" id="est_cost" class="form-control" placeholder="Estimated cost" value="" required>
       
        </div>
 </div>

 <div class="col-md-6">
     <div class="form-group">
          <label for="">Attachment</label>
          <input type="file" name="attachment" id="attachment" class="form-control"  value="" required>
       
        </div>
 </div>

 
 
  </div><br>

 <button type="submit"   class="btn btn-info btn-lg">Update</button>';
  echo $output;

    }
    public function send_quote_by_vendor_to_accounts(Request $request)
    {
   $id=CustomHelpers::custom_decrypt($request->id);
   $data=FactoryOrderDetails::find($id);
    $output=' <input type="hidden" name="id" id="order_item_id" value="'.$request->id.'">  
         <div class="row">
  
 <div class="col-md-6">
     <div class="form-group">
          <label for="">Estimated cost</label>
          <input type="test" name="est_cost" id="est_cost" class="form-control" placeholder="Estimated cost" value="" required>
       
        </div>
 </div>

 <div class="col-md-6">
     <div class="form-group">
          <label for="">Attachment</label>
          <input type="file" name="attachment" id="attachment" class="form-control"  value="" required>
       
        </div>
 </div>

 
 
  </div><br>

 <button type="submit"   class="btn btn-info btn-lg">Update</button>';
  echo $output;

    }
       public function accounts_view_and_accept_wharehouse_order(Request $request)
    {
   $id=CustomHelpers::custom_decrypt($request->id);
   $data=WharehouseOrderDetails::find($id);
   $options = view('admin.stores.accounts_view_and_accept_wharehouse_order',compact('data'))->render();
    echo $options;


    }
       public function accounts_view_and_accept_factory_order(Request $request)
    {
   $id=CustomHelpers::custom_decrypt($request->id);
   $data=FactoryOrderDetails::find($id);
   $options = view('admin.factory.accounts_view_and_accept_factory_order',compact('data'))->render();
    echo $options;


    }
    public function whare_house_order_view(Request $request)
    {
   $id=CustomHelpers::custom_decrypt($request->id);
   // $data=WharehouseOrderDetails::find($id);

    $data=DB::table('wharehouse_order_details')
               ->where('wharehouse_order_id','=',$id)
               ->get()->groupBy('factory_vendor_id');

   $options = view('admin.stores.whare_house_order_view',compact('data','id'))->render();
    echo $options;


    }
      public function factory_order_view(Request $request)
    {
   $id=CustomHelpers::custom_decrypt($request->id);
   // $data=FactoryOrderDetails::find($id);
   
   $data=DB::table('factory_order_details')
               ->where('factory_order_id','=',$id)
               ->get()->groupBy('factory_vendor_id');

   $options = view('admin.factory.factory_order_view',compact('data','id'))->render();
    echo $options;


    }
     public function accounts_view_and_verify_collection_details(Request $request)
    {
   $id=CustomHelpers::custom_decrypt($request->id);
   $data=WharehouseOrderDetails::find($id);
   $options = view('admin.stores.accounts_view_and_verify_collection_details',compact('data'))->render();
    echo $options;


    }
    public function accounts_view_and_verify_collection_details_factory(Request $request)
    {
   $id=CustomHelpers::custom_decrypt($request->id);
   $data=FactoryOrderDetails::find($id);
   $options = view('admin.factory.accounts_view_and_verify_collection_details_factory',compact('data'))->render();
    echo $options;


    }
    public function update_cost_est_factory(Request $request)
    {

      $order_id=$request->id;
      $order_id=CustomHelpers::custom_decrypt($order_id);
      $data=WharehouseOrderDetails::find($order_id);
      $data->est_cost=$request->est_cost;
       $data->status=4;
       
        if($request->hasFile("attachment")):
    $loi=$request->file("attachment");
    $loi_name=rand(0, 99999).".".$loi->getClientOriginalExtension();
    $loi_path=public_path("/uploads/fanchise");
    $loi->move($loi_path,$loi_name);
    $data->attachment=$loi_name;
        endif;
        
       $data->save();


       echo 'success'; 

    }
     public function update_cost_est_vendor(Request $request)
    {

      $order_id=$request->id;
      $order_id=CustomHelpers::custom_decrypt($order_id);
      $data=FactoryOrderDetails::find($order_id);
      $data->est_cost=$request->est_cost;
       $data->status=4;
       
        if($request->hasFile("attachment")):
    $loi=$request->file("attachment");
    $loi_name=rand(0, 99999).".".$loi->getClientOriginalExtension();
    $loi_path=public_path("/uploads/fanchise");
    $loi->move($loi_path,$loi_name);
    $data->attachment=$loi_name;
        endif;
        
       $data->save();


       echo 'success'; 

    }
    public function update_accept_status_by_accounts(Request $request)
    {

      $order_id=$request->id;
      $order_id=CustomHelpers::custom_decrypt($order_id);
      $data=WharehouseOrderDetails::find($order_id);

       $data->status=5;

        
       $data->save();


       echo 'success'; 

    }
    public function update_factory_accept_status_by_accounts(Request $request)
    {

      $order_id=$request->id;
      $order_id=CustomHelpers::custom_decrypt($order_id);
      $data=FactoryOrderDetails::find($order_id);

       $data->status=5;

        
       $data->save();


       echo 'success'; 

    }
    public function update_delivered_status_by_accounts(Request $request)
    {

      $order_id=$request->id;
      $order_id=CustomHelpers::custom_decrypt($order_id);
      $data=WharehouseOrderDetails::find($order_id);
      //StoreProduct
       $store_product=StoreProduct::find($data->product_id);
       $qty=$store_product->available_qty;
       if($qty!='')
       {
        $new_qty=(float)$qty+(float)$data->qty;
       }
       else
       {
     $new_qty=(float)$data->qty;
       }
       $store_product->available_qty=$new_qty;
       $store_product->save();
      //
       $data->status=3;

        
       $data->save();


       echo 'success'; 

    }
    public function update_factory_delivered_status_by_accounts(Request $request)
    {

      $order_id=$request->id;
      $order_id=CustomHelpers::custom_decrypt($order_id);
      $data=FactoryOrderDetails::find($order_id);
      //StoreProduct
       $store_product=FactoryIngredients::find($data->product_id);
       $qty=$store_product->avl_qty;
       if($qty!='')
       {
        $new_qty=(float)$qty+(float)$data->qty;
       }
       else
       {
     $new_qty=(float)$data->qty;
       }
       $store_product->avl_qty=$new_qty;
       $store_product->save();
      //
       $data->status=3;

        
       $data->save();


       echo 'success'; 

    }
  
      public function final_accept_status_by_factory_vendor(Request $request)
    {

      $order_id=$request->id;
      $order_id=CustomHelpers::custom_decrypt($order_id);
      $data=WharehouseOrderDetails::find($order_id);

       $data->status=6;

        
       $data->save();


       echo 'success'; 

    }
     public function final_accept_status_by_vendor(Request $request)
    {

      $order_id=$request->id;
      $order_id=CustomHelpers::custom_decrypt($order_id);
      $data=FactoryOrderDetails::find($order_id);

       $data->status=6;

        
       $data->save();


       echo 'success'; 

    }
      public function update_wharehouse_order_status_factory(Request $request)
    {
      
      $wharehouse_order_id=$request->wharehouse_order_id;
      $factory_vendor_id=$request->factory_vendor_id;
      $serial_number=$request->serial_number;
      $order_from_factory_wharehouse_id='';
      if($serial_number==1)
      {
        $confirm_qty=$request->confirm_qty;
        $est_cost=$request->est_cost;
       $order_detail_id=$request->order_detail_id;
       foreach($order_detail_id as $order_id):
          $data=WharehouseOrderDetails::find($order_id); 
          $data->status=4;
          $data->confirm_qty=$confirm_qty[$order_id][0]; 
          $data->est_cost=$est_cost[$order_id][0]; 
        
          $data->save(); 
       $order_from_factory_wharehouse_id=$data->wharehouse_id;
        $factory_vendor_type=$data->assign_type;
       endforeach;
      $order_type='wharehouse';
     

         $invoice=WharehouseFactoryInvoiceByFactoryVendor::where([['factory_vendor_id','=',$factory_vendor_id],['order_id','=',$wharehouse_order_id],['order_from_factory_wharehouse_id','=',$order_from_factory_wharehouse_id],['order_type','=',$order_type],['factory_vendor_type','=',$factory_vendor_type]])->first();
      if($invoice==''):
      $invoice=new WharehouseFactoryInvoiceByFactoryVendor;
       endif;
       $invoice->factory_vendor_id=$factory_vendor_id;
       $invoice->order_id=$wharehouse_order_id;
       $invoice->order_from_factory_wharehouse_id=$order_from_factory_wharehouse_id;
       $invoice->order_type=$order_type;
       $invoice->factory_vendor_type=$factory_vendor_type;
        if($request->hasFile("factory_vendor_invoice")):
    $adhar_card=$request->file("factory_vendor_invoice");
    $adhar_card_name=rand(0, 99999).".".$adhar_card->getClientOriginalExtension();
    $adhar_card_path=public_path("/uploads/factory_vendor_invoice");
    $adhar_card->move($adhar_card_path,$adhar_card_name);
    $invoice->invoice=$adhar_card_name;
        endif;
    $invoice->save();
      }
      elseif($serial_number==2)
      {

       $order_detail_id=$request->order_detail_id;
       foreach($order_detail_id as $order_id):
          $data=WharehouseOrderDetails::find($order_id); 
          $data->status=6;
          
          $data->save(); 
   
       endforeach;
      
 
      }
      elseif($serial_number==3)
      {
      $order_detail_id=$request->order_detail_id;
        if ($request->has('order_detail_id')) {
       foreach($order_detail_id as $order_id):
          $data=WharehouseOrderDetails::find($order_id); 
          $data->status=2;
          $data->dispatch_date=$request->dispatch_date;
          $data->courier_name=$request->courier_name;
          $data->save(); 
   
       endforeach;
      }
 
      }
       
  

       echo 'success';

    }
    public function update_factory_order_status_vendor(Request $request)
    {

       $factory_order_id=$request->factory_order_id;
      $factory_vendor_id=$request->factory_vendor_id;
      $serial_number=$request->serial_number;
      $order_from_factory_wharehouse_id='';
      if($serial_number==1)
      {
        $confirm_qty=$request->confirm_qty;
        $est_cost=$request->est_cost;
        $order_detail_id=$request->order_detail_id;
       foreach($order_detail_id as $order_id):
          $data=FactoryOrderDetails::find($order_id); 
          $data->status=4;
          $data->confirm_qty=$confirm_qty[$order_id][0]; 
          $data->est_cost=$est_cost[$order_id][0]; 
        
          $data->save(); 
       $order_from_factory_wharehouse_id=$data->factory_id;
        $factory_vendor_type=$data->assign_type;
       endforeach;
      $order_type='factory';
     

         $invoice=WharehouseFactoryInvoiceByFactoryVendor::where([['factory_vendor_id','=',$factory_vendor_id],['order_id','=',$factory_order_id],['order_from_factory_wharehouse_id','=',$order_from_factory_wharehouse_id],['order_type','=',$order_type],['factory_vendor_type','=',$factory_vendor_type]])->first();
      if($invoice==''):
      $invoice=new WharehouseFactoryInvoiceByFactoryVendor;
       endif;
       $invoice->factory_vendor_id=$factory_vendor_id;
       $invoice->order_id=$factory_order_id;
       $invoice->order_from_factory_wharehouse_id=$order_from_factory_wharehouse_id;
       $invoice->order_type=$order_type;
       $invoice->factory_vendor_type=$factory_vendor_type;
        if($request->hasFile("factory_vendor_invoice")):
    $adhar_card=$request->file("factory_vendor_invoice");
    $adhar_card_name=rand(0, 99999).".".$adhar_card->getClientOriginalExtension();
    $adhar_card_path=public_path("/uploads/factory_vendor_invoice");
    $adhar_card->move($adhar_card_path,$adhar_card_name);
    $invoice->invoice=$adhar_card_name;
        endif;
    $invoice->save();
      }
      elseif($serial_number==2)
      {

       $order_detail_id=$request->order_detail_id;
       foreach($order_detail_id as $order_id):
          $data=FactoryOrderDetails::find($order_id); 
          $data->status=6;
          
          $data->save(); 
   
       endforeach;
      
 
      }
      elseif($serial_number==3)
      {
      $order_detail_id=$request->order_detail_id;
        if ($request->has('order_detail_id')) {
       foreach($order_detail_id as $order_id):
          $data=FactoryOrderDetails::find($order_id); 
          $data->status=2;
          $data->dispatch_date=$request->dispatch_date;
          $data->courier_name=$request->courier_name;
          $data->save(); 
   
       endforeach;
      }
 
      }
       
  

       echo 'success';

    }
    public function wharehouse_order_status_update_by_factory(Request $request)
    {
   $id=CustomHelpers::custom_decrypt($request->id);
   $status=$request->status;
   $store=$request->store;
    if($status==1):
     $data=WharehouseOrderDetails::where([['wharehouse_order_id','=',$id],['factory_vendor_id','=',$store]])->whereIn('status',[1,4])->get();

    elseif($status==2):
        $data=WharehouseOrderDetails::where([['wharehouse_order_id','=',$id],['factory_vendor_id','=',$store]])->whereIn('status',[5])->get();
    elseif($status==3):
        $data=WharehouseOrderDetails::where([['wharehouse_order_id','=',$id],['factory_vendor_id','=',$store]])->whereIn('status',[6])->get();
    endif;
   
   $options = view('admin.factory.render_wharehouse_order_action',compact('data','status','id','store'))->render();
    echo $options;


   

    }
    public function factory_order_status_update_by_vendor(Request $request)
    {

      $id=CustomHelpers::custom_decrypt($request->id);
   $status=$request->status;
   $store=$request->store;
    if($status==1):
     $data=FactoryOrderDetails::where([['factory_order_id','=',$id],['factory_vendor_id','=',$store]])->whereIn('status',[1,4])->get();

    elseif($status==2):
        $data=FactoryOrderDetails::where([['factory_order_id','=',$id],['factory_vendor_id','=',$store]])->whereIn('status',[5])->get();
    elseif($status==3):
        $data=FactoryOrderDetails::where([['factory_order_id','=',$id],['factory_vendor_id','=',$store]])->whereIn('status',[6])->get();
    endif;
   
   $options = view('admin.vendor.factory.render_factory_order_action',compact('data','status','id','store'))->render();
    echo $options;

    }
      public function get_factory_product(Request $request)
    {

     if ($request->ajax()) {
            $store_id=$request->store;
             
            $data = AssignProductFactoryVendor::where([['factory_vendor_id','=',$store_id],['type','=','factory']])->get();
            return Datatables::of($data)
                ->addIndexColumn()
              
                ->addColumn('image', function($row){
                    
                   $image_data=ItemImages::where([['item_id','=',$row->product_id],['default','=',1]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="100px">';
          else:
           $image = 'NA';
          endif;
                    return $image;
                })
                ->addColumn('name', function($row){
                   $name=CustomHelpers::get_master_table_data('master_products','id',$row->product_id,'product_name');
                    return $name;
                })
                 ->addColumn('status', function($row){
                    if ($row->status==1)
             {
    $status= "<p style='background:green;color:white;padding:2px 5px;text-align:center'>Enabled</p>";
              }
             else
             {
    $status="<p style='background:#dd4b39;color:white;padding:2px 5px;text-align:center'>Disabled</p>";
               }
                    return $status;
                })
                 ->addColumn('unit', function($row){
                   $unit_id=CustomHelpers::get_master_table_data('master_products','id',$row->product_id,'unit');
                  if($unit_id!='NA'):
                  $unit=Unit::find($unit_id);
                 return $unit->unit;
                   else:
                    return 'NA';
                  endif;

                  
                })
                ->addColumn('action', function($row){
                    $id=$row->id;
                  
                    $actionBtn = ' <a href="#" id="'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Add/Edit Ingredients </a> ';
                    return $actionBtn;
                })
                ->rawColumns(['image','name','unit','action',])
                ->make(true);
        }

    }
      public function get_vendor_product(Request $request)
    {

     if ($request->ajax()) {
            $store_id=$request->store;
             
            $data = AssignProductFactoryVendor::where([['factory_vendor_id','=',$store_id],['type','=','vendor']])->get();
            return Datatables::of($data)
                ->addIndexColumn()
              
                ->addColumn('image', function($row){
                    
                   $image_data=ItemImages::where([['item_id','=',$row->product_id],['default','=',1]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="100px">';
          else:
           $image = 'NA';
          endif;
                    return $image;
                })
                ->addColumn('name', function($row){
                   $name=CustomHelpers::get_master_table_data('master_products','id',$row->product_id,'product_name');
                    return $name;
                })
                 ->addColumn('status', function($row){
                    if ($row->status==1)
             {
    $status= "<p style='background:green;color:white;padding:2px 5px;text-align:center'>Enabled</p>";
              }
             else
             {
    $status="<p style='background:#dd4b39;color:white;padding:2px 5px;text-align:center'>Disabled</p>";
               }
                    return $status;
                })
                 ->addColumn('unit', function($row){
                   $unit_id=CustomHelpers::get_master_table_data('master_products','id',$row->product_id,'unit');
                  if($unit_id!='NA'):
                  $unit=Unit::find($unit_id);
                 return $unit->unit;
                   else:
                    return 'NA';
                  endif;

                  
                })
               
                ->rawColumns(['image','name','unit',])
                ->make(true);
        }

    }
    public function disable_store_product(Request $request)
    {
      $id=$request->id;
      $data=StoreProduct::find($id);   
      $data->status=0;
      $data->save();
    }
    public function enable_store_product(Request $request)
    {
      $id=$request->id;
      $data=StoreProduct::find($id);   
      $data->status=1;
      $data->save();
    }
    public function add_store()
    {  
        $setting_data=StoreSetting::find(1);
        $stores=Stores::where('type','=',1)->whereIn('status',[1,2])->get();

        if($setting_data->status==0 && count($stores)>0)
        {
            return redirect()->back()->with("success","Kindly Change Store Setting");
        }
        else
        {
         $loged_user=Sentinel::getUser();
         $states=State::all();
         $users = User::where([['registration_level','=',3],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
         return view('admin.stores.create',compact('users','states'));    
        }
      
         
    }
    public function add_factory()
    {  

         $loged_user=Sentinel::getUser();
         $states=State::all();
         $users = User::where([['registration_level','=',3],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();
         return view('admin.factory.create',compact('users','states'));
    }
    public function save_factory(Request $request)
   {
    
    $store_data=new Stores();
    $store_data->name=$request->name;
    $store_data->mobile=$request->mobile;
    $store_data->state=$request->state;
    $store_data->dist=$request->dist;
    $store_data->city=$request->city;
    $store_data->address=$request->address;
      if($request->hasFile("rent_aggreement")):
    $rent_aggreement=$request->file("rent_aggreement");
    $rent_aggreement_name="_rent_aggreement_".rand().".".$rent_aggreement->getClientOriginalExtension();
    $path=public_path("/uploads/documents");
    $rent_aggreement->move($path,$rent_aggreement_name);
     $store_data->rent_aggreement=$rent_aggreement_name;
        endif;

    $store_data->name=$request->name;
    $store_data->rent_per_month=$request->rent_per_month;
    if ($request->has('status')) {
     $store_data->status=$request->status;
         }
    
    $store_data->type=2;
    if($store_data->save())
    { 
    $assign_user=new StoreAssignUser;
    $assign_user->store_id=$store_data->id;
    $assign_user->user_id=$request->user_id;
    $assign_user->type=2;
    $assign_user->save();

     
    }
     return redirect()->route('manage_factory')->with("success","Store Added Successfully");
   }
   public function save_store(Request $request)
   {
    
    $store_data=new Stores();
    $store_data->name=$request->name;
    $store_data->mobile=$request->mobile;
    $store_data->state=$request->state;
    $store_data->dist=$request->dist;
    $store_data->city=$request->city;
    $store_data->address=$request->address;
      if($request->hasFile("rent_aggreement")):
    $rent_aggreement=$request->file("rent_aggreement");
    $rent_aggreement_name="_rent_aggreement_".rand().".".$rent_aggreement->getClientOriginalExtension();
    $path=public_path("/uploads/documents");
    $rent_aggreement->move($path,$rent_aggreement_name);
     $store_data->rent_aggreement=$rent_aggreement_name;
        endif;

    $store_data->name=$request->name;
    $store_data->rent_per_month=$request->rent_per_month;
    if ($request->has('status')) {
     $store_data->status=$request->status;
         }
    
    $store_data->type=1;
    if($store_data->save())
    {
    $items=MasterProduct::all();
    foreach($items as $item)
    {
      $store_product=new StoreProduct;
      $store_product->store_id=$store_data->id;
      $store_product->product_id=$item->id;
      $store_product->threshold_qty=$item->threshold_qty;
      $store_product->available_qty=$item->initial_qty;
      $store_product->bal_qty=$item->initial_qty;
      $store_product->save(); 
    } 
    $assign_user=new StoreAssignUser;
    $assign_user->store_id=$store_data->id;
    $assign_user->user_id=$request->user_id;
    $assign_user->type=1;
    $assign_user->save();

     
    }
     return redirect()->route('manage_stores')->with("success","Store Added Successfully");
   }
    public function edit_store(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);



         $data=Stores::find($id);
         $states=State::all(); 
         
         $loged_user=Sentinel::getUser();
         $states=State::all();
         $users = User::where([['registration_level','=',3],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();

         return view('admin.stores.create',compact('users','states','data'));


       
    }
     public function edit_factory(Request $request)
    {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);



         $data=Stores::find($id);
         $states=State::all(); 
         
         $loged_user=Sentinel::getUser();
         $states=State::all();
         $users = User::where([['registration_level','=',3],['parent_id','=',$loged_user->parent_id]])->whereIn('status',[1,2])->get();

         return view('admin.factory.create',compact('users','states','data'));


       
    }
    public function update_store(Request $request)
   {
    
    $id=$request->id;
    $id=CustomHelpers::custom_decrypt($id);
    $store_data=Stores::find($id);
    $store_data->name=$request->name;
    $store_data->mobile=$request->mobile;
    $store_data->state=$request->state;
    $store_data->dist=$request->dist;
    $store_data->city=$request->city;
    $store_data->address=$request->address;
      if($request->hasFile("rent_aggreement")):
    $rent_aggreement=$request->file("rent_aggreement");
    $rent_aggreement_name="_rent_aggreement_".rand().".".$rent_aggreement->getClientOriginalExtension();
    $path=public_path("/uploads/documents");
    $rent_aggreement->move($path,$rent_aggreement_name);
    $store_data->rent_aggreement=$rent_aggreement_name;
        endif;

    $store_data->name=$request->name;
    $store_data->rent_per_month=$request->rent_per_month;
    if ($request->has('status')) {
     $store_data->status=$request->status;
         }
    
    $store_data->type=1;
    if($store_data->save())
    {
    $items=MasterProduct::all();
    foreach($items as $item)
    {
      $check_data=StoreProduct::where('product_id','=',$item->id)->first();
      if($check_data=='')
      {
      $store_product=new StoreProduct;
      $store_product->store_id=$store_data->id;
      $store_product->product_id=$item->id;
      $store_product->threshold_qty=$item->threshold_qty;
      $store_product->available_qty=0;
      $store_product->bal_qty=$item->initial_qty;
      $store_product->save(); 
      }  
    
    } 
    $previous_data=StoreAssignUser::where('store_id','=',$store_data->id)->first();
    if($previous_data!=''):
    $assign_user=StoreAssignUser::find($previous_data->id);
    else:
        $assign_user=new StoreAssignUser;
        endif;
    $assign_user->store_id=$store_data->id;
    $assign_user->user_id=$request->user_id;
    $assign_user->type=1;
    $assign_user->save();

     
    }
     return redirect()->route('manage_stores')->with("success","Store Updated Successfully");
   }
    public function update_factory(Request $request)
   {
    
    $id=$request->id;
    $id=CustomHelpers::custom_decrypt($id);
    $store_data=Stores::find($id);
    $store_data->name=$request->name;
    $store_data->mobile=$request->mobile;
    $store_data->state=$request->state;
    $store_data->dist=$request->dist;
    $store_data->city=$request->city;
    $store_data->address=$request->address;
      if($request->hasFile("rent_aggreement")):
    $rent_aggreement=$request->file("rent_aggreement");
    $rent_aggreement_name="_rent_aggreement_".rand().".".$rent_aggreement->getClientOriginalExtension();
    $path=public_path("/uploads/documents");
    $rent_aggreement->move($path,$rent_aggreement_name);
    $store_data->rent_aggreement=$rent_aggreement_name;
        endif;

    $store_data->name=$request->name;
    $store_data->rent_per_month=$request->rent_per_month;
    if ($request->has('status')) {
     $store_data->status=$request->status;
         }
    
    $store_data->type=2;
    if($store_data->save())
    {
   
    $previous_data=StoreAssignUser::where('store_id','=',$store_data->id)->first();
    $assign_user=StoreAssignUser::find($previous_data->id);
    $assign_user->store_id=$store_data->id;
    $assign_user->user_id=$request->user_id;
    $assign_user->type=2;
    $assign_user->save();

     
    }
     return redirect()->route('manage_factory')->with("success","Factory Updated Successfully");
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete_store(Request $request)
     {
        $id=$request->id;
        $id=CustomHelpers::custom_decrypt($id);
        $data=Stores::find($id);
        $data->status=0;
        $data->save();
       
        
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
     * @param  \App\Models\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function show(Stores $stores)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function edit(Stores $stores)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stores $stores)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stores  $stores
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stores $stores)
    {
        //
    }
}

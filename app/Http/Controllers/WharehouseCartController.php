<?php

namespace App\Http\Controllers;

use App\Models\WharehouseCart;
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
use App\Models\MasterProduct;
use App\Models\FanchiseRegistration;
use App\Models\WharehouseOrder;
use App\Models\WharehouseOrderDetails;
use DB;

class WharehouseCartController extends Controller
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
     public function wharehouse_add_to_cart(Request $request)
    {
    $item_id=$request->item_id;
    $store_id=$request->store_id;
    $data_check=WharehouseCart::where([['wharehouse_id','=',$store_id],['wharehouse_product_id','=',$item_id]])->first();
    if($data_check==''):
    $data =new WharehouseCart;
    $data->wharehouse_id=$store_id;
    $data->wharehouse_product_id=$item_id;
    $data->qty=1;
    $data->save();
     
  

  $count_data=WharehouseCart::where([['wharehouse_id','=',$store_id]])->get();
   $count=count($count_data);
   $output=['count'=>$count];
          return $output;
    endif;
    }
    public function wharehouse_cart_count(Request $request)
    {
 
    $store_id=$request->store_id;
 
  $count_data=WharehouseCart::where('wharehouse_id','=',$store_id)->get();
   $count=count($count_data);
   $output=['count'=>$count];
          return $output;
  
    }
    public function get_wharehouse_cart_data(Request $request)
    {
        $store_id=$request->store_id;
         $data=WharehouseCart::where('wharehouse_id','=',$store_id)->get();
        $options = view('admin.stores.order_placed',compact('data'))->render();
        echo $options;
    }
       public function wharehouse_qty_change(Request $request)
    {
        $cart_id=$request->cart_id;
        $cart_id=CustomHelpers::custom_decrypt($cart_id);
       $button='';
       $get_all_item_subtotal_with_gst=0;
        $subtotal=0;
        if($request->new_value==0):
        $previous_data=WharehouseCart::find($cart_id); 
       
        WharehouseCart::destroy($cart_id); 
       
        else:
       $cart=WharehouseCart::find($cart_id); 
        $cart->qty=$request->new_value;
        $cart->save();
     
        endif;
    }
    public function submit_cart_by_wharehouse(Request $request)
    {
      $store_id=$request->store_id;
      $cart_datas=WharehouseCart::where('wharehouse_id','=',$store_id)->get();
      if(count($cart_datas)!=0):
        $cart_item=[];
        foreach($cart_datas as $cart_data):
        

         $cart_item[]=[
                     'product_id'=>$cart_data->wharehouse_product_id,
                     
                     'qty'=>$cart_data->qty,
                      ]; 
       WharehouseCart::destroy($cart_data->id);
        
        endforeach;
      
        $orderpayment=new WharehouseOrder;

        $orderpayment->wharehouse_id=$store_id;
       
        $orderpayment->save();

        //OrderItemDetails
        foreach($cart_item as $item)
        {
            
             $new_item=new WharehouseOrderDetails;
             $new_item->wharehouse_id=$store_id;
             $new_item->wharehouse_order_id=$orderpayment->id;
             $new_item->product_id=$item['product_id'];
             $new_item->qty=$item['qty'];
             $new_item->confirm_qty=$item['qty'];
             $new_item->save();
        }
        echo 'success';
     endif;
    }
     public function wharehouse_newly_submitted_order()
    {
       $datas=Stores::where('type','=',1)->whereIn('status',[1,2])->get();
       return view('admin.stores.wharehouse_newly_submitted_order',compact('datas')); 
    }
     public function get_store_new_order(Request $request)
    {

     if ($request->ajax()) {
            $store_id=$request->store;
            $order=$request->order_status; 
            if($order==1):

             $data=DB::table('wharehouse_order_details')
               ->where([['wharehouse_id','=',$store_id],['status','=','0']])
              
               ->orderBy('id','DESC')
               ->get()->groupBy('wharehouse_order_id');

                // $data = WharehouseOrderDetails::where([['wharehouse_id','=',$store_id],['status','=','0']])->get();
            elseif($order==2):

                $data=DB::table('wharehouse_order_details')
               ->where('wharehouse_id','=',$store_id)
               ->whereIn('status',[1,2,4,5,6])
               ->orderBy('id','DESC')
               ->get()->groupBy('wharehouse_order_id');

                // $data = WharehouseOrderDetails::where('wharehouse_id','=',$store_id)->whereIn('status',[1,2,4,5,6])->get();
           
        elseif($order==3):  
            $data=DB::table('wharehouse_order_details')
               ->where([['wharehouse_id','=',$store_id],['status','=','3']])
              
               ->orderBy('id','DESC')
               ->get()->groupBy('wharehouse_order_id');
            // $data = WharehouseOrderDetails::where([['wharehouse_id','=',$store_id],['status','=','3']])->get();  
            endif;

            // $data = WharehouseOrderDetails::where('wharehouse_id','=',$store_id)->get();
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
                   if(CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'action_pending_account')>0):
                   $status.='<hr style="margin:0px;padding:0px">Pending Action: '.CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'action_pending_account');
                  endif;
                   if(CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'action_pending')>0):
                   $status.='<hr style="margin:0px;padding:0px">Pending Factory/Vendor: '.CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'action_pending');
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
                     $id=CustomHelpers::custom_encrypt($row['0']->wharehouse_order_id);
                       

$action='<a href="#" class="btn btn-sm btn-info whare_house_order_view"  id="'.$id.'" ><span class="fa fa-eye"></span>  View </a>';

                   
                    return $action;
                })
                
                ->rawColumns(['order_id','factory_name','status','action'])
                ->make(true);
        }

    }
      public function newly_wharehouse_order_accounts()
    {
       $datas=Stores::where('type','=',1)->whereIn('status',[1,2])->get();
       $orders=WharehouseOrder::where('status',0)->get();  

       return view('admin.stores.newly_wharehouse_order_accounts',compact('orders')); 
    }
    public function wharehouse_order_assign($id)
    {
    $order_id=CustomHelpers::custom_decrypt($id);
    $orders_items=WharehouseOrderDetails::where('wharehouse_order_id','=',$order_id)->get();
     return view('admin.stores.wharehouse_order_assign',compact('orders_items')); 
    }
    public function get_product_vendor_factory(Request $request)
    {
         $product_id=$request->product_id;
         $factory_vendor=$request->factory_vendor;
         if($factory_vendor=='factory'):
           $data=DB::table('assign_product_factory_vendors')->where([['product_id','=',$product_id],['type','=','factory']])->get();

            if(count($data)!='0')
          {
            $output='<option value="">--Select One--</option>';
            foreach($data as $datas)
            {
         $output.='<option value="'.$datas->factory_vendor_id.'">'.CustomHelpers::get_master_table_data('stores','id',$datas->factory_vendor_id,'name').'</option>';
            }  
          }
          else
          {
             $output='<option value="">--Select One--</option>';
          }

          elseif($factory_vendor=='vendor'):
              $data=DB::table('assign_product_factory_vendors')->where([['product_id','=',$product_id],['type','=','vendor']])->get();
           if(count($data)!='0')
          {
            $output='<option value="">--Select One--</option>';
            foreach($data as $datas)
            {
         $output.='<option value="'.$datas->factory_vendor_id.'">'.CustomHelpers::get_master_table_data('users','id',$datas->factory_vendor_id,'name').'</option>';
            }  
          }
          else
          {
             $output='<option value="">--Select One--</option>';
          }

          endif;
         

          echo $output;
    }
     public function wharehouse_order_assign_store($id,Request $request)
    {
       $assign=$request->assign;

       foreach($assign as $row=>$col)
       {
       
         $order_item=WharehouseOrderDetails::find((int)$col['order_item_id']);
         $order_item->assign_type=$col['factory_vendor'];
         $order_item->factory_vendor_id=$col['factory_vendor_id'];
         $order_item->status=1;
         $order_item->save();

         $order=WharehouseOrder::find((int)$order_item->wharehouse_order_id);
         $order->status=1;
         $order->save();
        
       }
     return redirect('/Ongoing-Wharehouse-Order-Accounts');
    }
     public function ongoing_wharehouse_order_accounts()
    {
       $datas=Stores::where('type','=',1)->whereIn('status',[1,2])->get();
       $orders=WharehouseOrderDetails::whereIn('status',[1,2,4,5,6])->get();  

       return view('admin.stores.ongoing_wharehouse_order_accounts',compact('orders')); 
    }
    public function wharehouse_order_status_update_by_account(Request $request)
    {
        $id=CustomHelpers::custom_decrypt($request->id);
   $status=$request->status;
 
    if($status==2):
      $data=DB::table('wharehouse_order_details')
               ->where('wharehouse_order_id','=',$id)
               ->get()->groupBy('factory_vendor_id');
    elseif($status==4):
      $data=DB::table('wharehouse_order_details')
               ->where('wharehouse_order_id','=',$id)
               ->get()->groupBy('factory_vendor_id');
    endif;
   
   $options = view('admin.stores.render_wharehouse_order_status_update_by_account',compact('data','id','status'))->render();
    echo $options;
     
    }
     public function update_wharehouse_order_status_account(Request $request)
    {
      
      $wharehouse_order_id=$request->wharehouse_order_id;
      $factory_vendor_id=$request->factory_vendor_id;
      $serial_number=$request->serial_number;
    
      if($serial_number==1)
      {
        if ($request->has('factory_vendor_id')) {
       foreach($factory_vendor_id as $factory_vendor_ids):
            
          $new_datas=WharehouseOrderDetails::where([['wharehouse_order_id','=',$wharehouse_order_id],['factory_vendor_id','=',$factory_vendor_ids]])->get();

          foreach($new_datas as $d):
          $data=WharehouseOrderDetails::find($d->id); 
          $data->status=5;
        
          $data->save(); 
          endforeach;
           
       
       endforeach;
       
       }
    
      }
      elseif($serial_number==2)
      {
        $order_detail_id=$request->order_detail_id;
        if ($request->has('order_detail_id')) {
       foreach($order_detail_id as $d):
            
          $data=WharehouseOrderDetails::find($d);

          $data->status=3;
          //StoreProduct
       $store_product=StoreProduct::find($data->product_id);
       $qty=$store_product->available_qty;
       if($qty!='')
       {
        $new_qty=(float)$qty+(float)$data->confirm_qty;
       }
       else
       {
     $new_qty=(float)$data->confirm_qty;
       }
       $store_product->available_qty=$new_qty;
       $store_product->save();
      //
          $data->save(); 
           
       
       endforeach;
       
       }
    
      }
      
    
       


       echo 'success';

    }
    public function get_wharehouse_order_accounts(Request $request)
    {

     if ($request->ajax()) {
           
            $order=$request->order_status; 
            if($order==1):

             $data=DB::table('wharehouse_order_details')
               ->where('status','=',1)
              
               ->orderBy('id','DESC')
               ->get()->groupBy('wharehouse_order_id');

            elseif($order==2):
              

              $data=DB::table('wharehouse_order_details')
               ->where('status','=',4)
              
               ->orderBy('id','DESC')
               ->get()->groupBy('wharehouse_order_id');


               

                // $data = WharehouseOrderDetails::where('wharehouse_id','=',$store_id)->whereIn('status',[1,2,4,5,6])->get();
           
        elseif($order==3):  
             $data=DB::table('wharehouse_order_details')
             
               ->whereIn('status',[5,6])
               ->orderBy('id','DESC')
               ->get()->groupBy('wharehouse_order_id');
          elseif($order==4):  
               $data=DB::table('wharehouse_order_details')
               ->where('status','=',2)
              
               ->orderBy('id','DESC')
               ->get()->groupBy('wharehouse_order_id');
             elseif($order==5):  
               $data=DB::table('wharehouse_order_details')
               ->where('status','=',3)
              
               ->orderBy('id','DESC')
               ->get()->groupBy('wharehouse_order_id');
           
            endif;

            // $data = WharehouseOrderDetails::where('wharehouse_id','=',$store_id)->get();
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
                   if(CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'action_pending_account')>0):
                   $status.='<hr style="margin:0px;padding:0px">Pending Action: '.CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'action_pending_account');
                  endif;
                   if(CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'action_pending')>0):
                   $status.='<hr style="margin:0px;padding:0px">Pending Factory/Vendor: '.CustomHelpers::get_wharehouse_order_status_count($row['0']->wharehouse_order_id,'action_pending');
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
                     $id=CustomHelpers::custom_encrypt($row['0']->wharehouse_order_id);
                    $action='';
                    
                      $order_details_id=$row['0']->id;
                     $order_status=CustomHelpers::get_master_table_data('wharehouse_order_details','id',$order_details_id,'status');
                     if($order_status==4):
                     $action.= '<a href="#" id="'.CustomHelpers::custom_encrypt($row['0']->wharehouse_order_id).'" class="take_action btn btn-success btn-sm" style="display:inline-block;margin-top:5px;width:100%"><i class="fas fa-edit"></i> View & Reply </a>';
                    elseif($order_status==2):
                    $action.= '<a href="#" id="'.CustomHelpers::custom_encrypt($row['0']->wharehouse_order_id).'" class="take_action btn btn-success btn-sm" style="display:inline-block;margin-top:5px;width:100%"><i class="fas fa-edit"></i> Fill Collection </a>';
                     endif; 

$action.='<a href="#" class="btn btn-sm btn-info whare_house_order_view" style="display:inline-block;margin-top:5px;width:100%"  id="'.$id.'" ><span class="fa fa-eye"></span>  View </a>';

                   
                    return $action;
                })
                
                ->rawColumns(['order_id','factory_name','status','action'])
                ->make(true);
        }

    }
    public function completed_wharehouse_order_accounts()
    {
       $datas=Stores::where('type','=',1)->whereIn('status',[1,2])->get();
       $orders=WharehouseOrderDetails::whereIn('status',[3])->get();  

       return view('admin.stores.ongoing_wharehouse_order_accounts',compact('orders')); 
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
     * @param  \App\Models\WharehouseCart  $wharehouseCart
     * @return \Illuminate\Http\Response
     */
    public function show(WharehouseCart $wharehouseCart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WharehouseCart  $wharehouseCart
     * @return \Illuminate\Http\Response
     */
    public function edit(WharehouseCart $wharehouseCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WharehouseCart  $wharehouseCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WharehouseCart $wharehouseCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WharehouseCart  $wharehouseCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(WharehouseCart $wharehouseCart)
    {
        //
    }
}

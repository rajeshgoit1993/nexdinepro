<?php

namespace App\Http\Controllers;

use App\Models\FranchiseStockSalePrice;
use App\Helpers\CustomHelpers;
use Illuminate\Http\Request;
use App\Models\FranchiseStockStatus;
use App\Models\FanchiseRegistration;
use App\Models\ItemImages;
use App\Models\Unit;
use App\Exports\FranchiseStockExport;
use App\Imports\FranchiseStockImport;
use App\Imports\FranchiseAdminStockImport;
use App\Models\PhysicalEntry;
use App\Models\RegionWiseOutlet;
use App\Models\RegionSetting;
use App\Models\User;
use Sentinel;
use DB;
use DataTables;
use Validator;
use Excel;
use PDF; 

class FranchiseStockSalePriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new_physical_request()
    {
   $id =Sentinel::getUser()->id;
   $region_ids=RegionSetting::where('assign_area_manager',$id)->pluck('id');
   $outlet_ids=RegionWiseOutlet::whereIn('region_id',$region_ids)->pluck('outlet_id');
   $data = PhysicalEntry::where('area_manager_approval',0)->whereIn('outlet_id',$outlet_ids)->latest()->get()->groupBy('outlet_id');
   $val=0;
   return view('outlet.stock.physical',compact('val')); 
   // dd($data);

    }
     public function completed_physical_request()
    {
   $id =Sentinel::getUser()->id;
   $region_ids=RegionSetting::where('assign_area_manager',$id)->pluck('id');
   $outlet_ids=RegionWiseOutlet::whereIn('region_id',$region_ids)->pluck('outlet_id');
   $data = PhysicalEntry::where('area_manager_approval',0)->whereIn('outlet_id',$outlet_ids)->latest()->get()->groupBy('outlet_id');
   $val=1;
 return view('outlet.stock.physical',compact('val')); 
   // dd($data);

    }
   public function get_physical_request(Request $request)
    {
    $val=$request->val;
      $id =Sentinel::getUser()->id;
   $region_ids=RegionSetting::where('assign_area_manager',$id)->pluck('id');
   $outlet_ids=RegionWiseOutlet::whereIn('region_id',$region_ids)->pluck('outlet_id');
   $data = PhysicalEntry::where('area_manager_approval',$val)->whereIn('outlet_id',$outlet_ids)->latest()->get()->groupBy('outlet_id');

           

           

            return Datatables::of($data)
                ->addIndexColumn()
                
->addColumn('outlet_details', function($row){
                   $outlet_id=$row[0]->outlet_id;
$rows_data=User::find($outlet_id);
$outlet_details="<b>ID:</b> $rows_data->email
                 <hr style='margin:0px'>
                 <b>Name:</b> $rows_data->name
                 <hr style='margin:0px'>
                 <b>Mobile:</b> $rows_data->mobile
                 <hr style='margin:0px'>
                <b>State:</b> $rows_data->state
                             <hr style='margin:0px'>
                             <b>City:</b> $rows_data->city";

                return $outlet_details;
                })
              ->addColumn('details', function($row){
                   $outlet_id=$row[0]->outlet_id;
 $date_wise_datas=DB::table('physical_entries')->where([['area_manager_approval',$row[0]->area_manager_approval],['outlet_id',(int)$outlet_id]])->latest()->get()->groupBy('date');
 if($row[0]->area_manager_approval==0):
     $output='<table class="table table-bordered">
 <thead>
    <tr>
      <th>Date</th>

      <th>Export</th>
      <th>Import</th>
    
    </tr>
  </thead>
    <tbody>';

foreach($date_wise_datas as $row=>$col):
    $id=CustomHelpers::custom_encrypt($col[0]->outlet_id);
 $output.='<tr style="">
        <td style="padding:2px 10px">'.$row.'</td>
       
      
        
        <td style="padding:5px 10px;">
          <a href="'.url('/exportstock/'.$id.'/'.$col[0]->date).'"  class="export_stock  btn btn-default btn-sm"><i class="fas fa-file-export"></i> Export Stock</a>
        </td>
       <td style="padding:5px 10px;">
           <a href="#" class="import_stock btn btn-primary btn-sm"><i class="fas fa-file-import"></i> Import Stock</a>
        </td>
        
      </tr>';
endforeach;

$output.='</tbody>
  </table>
 
        ';
 else:
     $output='<table class="table table-bordered">
 <thead>
    <tr>
      <th>Date</th>

      <th>Export</th>
     
    
    </tr>
  </thead>
    <tbody>';

foreach($date_wise_datas as $row=>$col):
    $id=CustomHelpers::custom_encrypt($col[0]->outlet_id);
 $output.='<tr style="">
        <td style="padding:2px 10px">'.$row.'</td>
       
      
        
        <td style="padding:5px 10px;">
          <a href="'.url('/exportstock/'.$id.'/'.$col[0]->date).'"  class="export_stock  btn btn-default btn-sm"><i class="fas fa-file-export"></i> Export Stock</a>
        </td>
     
        
      </tr>';
endforeach;

$output.='</tbody>
  </table>
 
        ';
 endif;
 



                return $output;
                }) 
             
                
                ->rawColumns(['outlet_details','details'])
                ->make(true);
    }
    public function exportstock($id1,$id2,Request $request)
    {
    $outlet_id=CustomHelpers::custom_decrypt($id1);
    $date=$id2;
   
    
    $data=FranchiseStockSalePrice::where('outlet_id','=',(int)$outlet_id)->get();
    return Excel::download(new FranchiseStockExport((int)$outlet_id,$date,'admin'), $date.'_stock'.'.xlsx');
       
    }
    public function index()
    {

      $outlet_id =Sentinel::getUser()->parent_id;
 
      $stock_update=CustomHelpers::get_update_outlet_stock($outlet_id);
         $stock_status=FranchiseStockStatus::where('outlet_id',$outlet_id)->first();
       if($stock_status==''):  
          $stock_data=new FranchiseStockStatus; 
          $stock_data->outlet_id=(int)$outlet_id;
          $stock_data->status=1;
          $stock_data->save();
         
         $new_data=FranchiseStockSalePrice::where('outlet_id','=',(int)$outlet_id)->get();
          return view('outlet.stock.index',compact('new_data')); 
       else:
          $new_data=FranchiseStockSalePrice::where('outlet_id','=',(int)$outlet_id)->get();
          return view('outlet.stock.index',compact('new_data')); 
       endif;
    }
    public function export_stock(Request $request)
    {
    $date=date('d-m-Y');
    $outlet_id =Sentinel::getUser()->parent_id;
    $data=FranchiseStockSalePrice::where('outlet_id','=',(int)$outlet_id)->get();
    return Excel::download(new FranchiseStockExport((int)$outlet_id,$date,'outlet'), $date.'_stock'.'.xlsx');
       
    }

    public function store_admin_stock_by_excel(Request $request)
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
        
        Excel::import(new FranchiseAdminStockImport(1),$request->file('stock'));

           echo 'success';  
            
        }else{
            echo 'error';
        }
       }
    }
  
    public function get_stock_product(Request $request)
    {
        if ($request->ajax()) {
        $outlet_id =Sentinel::getUser()->parent_id;
           
            $data = FranchiseStockSalePrice::where('outlet_id','=',(int)$outlet_id)->latest()->get();

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
             
                ->addColumn('unit', function($row){
                   $unit_id=CustomHelpers::get_master_table_data('master_products','id',$row->product_id,'unit');
                    if($unit_id!='NA'):
                  $unit=Unit::find($unit_id);
                 return $unit->unit;
                   else:
                    return 'NA';
                  endif;
                    
                })
                 
                   ->addColumn('product_name', function($row){
                   $product_name=CustomHelpers::get_master_table_data('master_products','id',$row->product_id,'product_name');
                    return $product_name;
                    
                })
                 ->addColumn('available_qty', function($row){

                    $outlet_id =Sentinel::getUser()->parent_id;
                    $product_id=$row->product_id;
                    $available_qty=$row->available_qty;

        $consuption_sum=DB::table('franchise_sale_consuptions_of_menus')
         ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id],['sync_status',0]])->sum('consumption');
          
        $waste_sum=DB::table('waste_ingredients')
         
           ->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id],['sync_status',0]])->sum('waste_amount');
       $total_waste=(float)$consuption_sum+(float)$waste_sum;
      
      $last_sync_data=DB::table('physical_entries')->where([['outlet_id',(int)$outlet_id],['ingredient_id',(int)$product_id],['sync_status',1]])->latest()->first();
       
    $return=(float)$available_qty-(float)$total_waste; 
    if($last_sync_data!='')
    {
      $return.='<hr style="margin:0px;padding:0px"><i style="font-size:10px">Last Sync Phy Entry: '.date('d-m-Y h:s:a', strtotime($last_sync_data->updated_at)).'</i>';  
    } 
    else
    {
   $return.='<hr style="margin:0px;padding:0px"><i style="font-size:10px">Last Sync Phy Entry: Not Sync Yet</i>';       
    }             
   return $return; 


                })

                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '
                    <a href="#" style="display:inline-block;margin-top:5px;width:100%" id="'.$id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit QTY</a> 
                   ';
                    return $actionBtn;
                })
                ->rawColumns(['action','image','unit','product_name','available_qty'])
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
     * @param  \App\Models\FranchiseStockSalePrice  $franchiseStockSalePrice
     * @return \Illuminate\Http\Response
     */
    public function show(FranchiseStockSalePrice $franchiseStockSalePrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FranchiseStockSalePrice  $franchiseStockSalePrice
     * @return \Illuminate\Http\Response
     */
    public function edit(FranchiseStockSalePrice $franchiseStockSalePrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FranchiseStockSalePrice  $franchiseStockSalePrice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FranchiseStockSalePrice $franchiseStockSalePrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FranchiseStockSalePrice  $franchiseStockSalePrice
     * @return \Illuminate\Http\Response
     */
    public function destroy(FranchiseStockSalePrice $franchiseStockSalePrice)
    {
        //
    }
}

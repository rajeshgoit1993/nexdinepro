<?php

namespace App\Http\Controllers;

use App\Models\FranchiseTableSetting;
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
use App\Models\FactoryIngredients;
use DB;
use Validator;
use App\Models\AssignFoodMenuCategoryToBrands;

class FranchiseTableSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands=Brands::all();
       return view('outlet.pos.table.index',compact('brands'));
    }
  public function get_table(Request $request)
    {
        if ($request->ajax()) {
            $data = FranchiseTableSetting::where('outlet_id','=',Sentinel::getUser()->id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                     $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="#" id="'.$id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="#" id="'.$id.'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
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
        $options = view("outlet.pos.table.create")->render();
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
           'sit_capacity' => "required",
           'position' => "required",
           'description' => "required",
        
             ]); 
        if($validator->fails()) 
            {          
           echo "Please Enter All Details";            
            } 
            else
            {
        $data=new FranchiseTableSetting;
        $data->name=$request->name;
        $data->sit_capacity=$request->sit_capacity;
        $data->position=$request->position;
        $data->description=$request->description;
        $data->user_id=Sentinel::getUser()->id;
        $data->outlet_id=Sentinel::getUser()->id;
        $data->company_id=1;
        $data->save();
      
        echo 'success';

            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FranchiseTableSetting  $franchiseTableSetting
     * @return \Illuminate\Http\Response
     */
    public function show(FranchiseTableSetting $franchiseTableSetting)
    {
     
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FranchiseTableSetting  $franchiseTableSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        
         $id=CustomHelpers::custom_decrypt($request->id);
         $outlet_id=Sentinel::getUser()->id;
         $data=FranchiseTableSetting::where([['id','=',$id],['outlet_id','=',$outlet_id]])->first();
         if($data==''):
         echo 'Data Not Found';
         else:
          $options = view("outlet.pos.table.edit",compact('data',))->render();
         echo $options;
         endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FranchiseTableSetting  $franchiseTableSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FranchiseTableSetting $franchiseTableSetting)
    {
       $validator = Validator::make($request->all(), 
              [ 
           'name' => "required",
           'sit_capacity' => "required",
           'position' => "required",
           'description' => "required",
        
             ]); 
        if($validator->fails()) 
            {          
           echo "Please Enter All Details";            
            } 
            else
            {

         $id=CustomHelpers::custom_decrypt($request->id);
         $outlet_id=Sentinel::getUser()->id;
         $data=FranchiseTableSetting::where([['id','=',$id],['outlet_id','=',$outlet_id]])->first();
         if($data==''):
         echo 'Data Not Found';
         else:
          $data->name=$request->name;
        $data->sit_capacity=$request->sit_capacity;
        $data->position=$request->position;
        $data->description=$request->description;
        $data->user_id=Sentinel::getUser()->id;
        $data->outlet_id=Sentinel::getUser()->id;
        $data->company_id=1;
        $data->save();
      
        echo 'success';
         endif;
             
       
       

            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FranchiseTableSetting  $franchiseTableSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $id=CustomHelpers::custom_decrypt($request->id);
         $outlet_id=Sentinel::getUser()->id;
         $data=FranchiseTableSetting::where([['id','=',$id],['outlet_id','=',$outlet_id]])->first();
         if($data==''):
         echo 'Data Not Found';
         else:
          FranchiseTableSetting::destroy($id);
          echo 'success';
         endif;
    }
}

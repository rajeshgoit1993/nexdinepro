<?php

namespace App\Http\Controllers;

use App\Models\Designation;
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

class DesignationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('admin.designation.index');
    }
    public function get_designation(Request $request)
    {
        if ($request->ajax()) {
            $data = Designation::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    

                    $actionBtn = '<a href="#" id="'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="#" id="'.$row->id.'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
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
         $options = view("admin.designation.create")->render();
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
           'designation' => "required",
        
             ]); 
        if($validator->fails()) 
            {          
           echo "Please Enter Designation Name";            
            } 
            else
            {
        $data=new Designation;
        $data->designation=$request->designation;
        $data->designation_level=$request->designation_level;
        $data->save();
      
       
        echo 'success';

            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
   
   public function edit(Request $request)
    {
      $id=$request->id;
         $data=Designation::find($id);
       
         $options = view("admin.designation.edit",compact('data'))->render();
         echo $options;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
  
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), 
              [ 
           'designation' => "required",
        
             ]); 
        if($validator->fails()) 
            {          
           echo "Please Enter Designation Name";            
            } 
            else
            {
        $id=$request->id;
        $data=Designation::find($id);
        $data->designation=$request->designation;
        $data->designation_level=$request->designation_level;
        $data->save();
      
       
        echo 'success';

            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Designation  $designation
     * @return \Illuminate\Http\Response
     */
    
    public function destroy(Request $request)
    {
        $id=$request->id;
         Designation::destroy($id);
         echo 'success';
    }
}

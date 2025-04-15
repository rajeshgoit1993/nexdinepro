<?php

namespace App\Http\Controllers;

use App\Models\FoodMenuCategory;
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
use App\Models\RegionSetting;
use DB;
use Validator;
use App\Models\FoodMenu;
use App\Models\AssignFoodMenuCategoryToBrands;

class FoodMenuCategoryController extends Controller
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
       return view('admin.pos.foodcategory.index',compact('data','regions','cities'));
    }
    public function get_food_category(Request $request)
    {
        if ($request->ajax()) {
            $outlet_id=$request->outlet_id;
            $data = FoodMenuCategory::where('outlet_id',$outlet_id)->latest()->get();
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
    public function create(Request $request)
    {
        $outlet_id=$request->outlet_id;
       
        $options = view("admin.pos.foodcategory.create",compact('outlet_id'))->render();
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
        $outlet_id=$request->outlet_id;

        $validator = Validator::make($request->all(), 
              [ 
           'category_name' => "required",
        
             ]); 
        if($validator->fails()) 
            {          
           echo "Please Enter Category Name";            
            } 
            else
            {
        $data=new FoodMenuCategory;
        $data->category_name=$request->category_name;
        $data->outlet_id=$request->outlet_id;
        $data->description=$request->description;
        $data->create_by_id=Sentinel::getUser()->id;
        $data->save();
      
       
       
        echo 'success';

            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FoodMenuCategory  $foodMenuCategory
     * @return \Illuminate\Http\Response
     */
    public function show(FoodMenuCategory $foodMenuCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FoodMenuCategory  $foodMenuCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id=$request->id;
         $data=FoodMenuCategory::find($id);
         $brands=Brands::all();
         $options = view("admin.pos.foodcategory.edit",compact('data','brands'))->render();
         echo $options;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FoodMenuCategory  $foodMenuCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $validator = Validator::make($request->all(), 
              [ 
           'category_name' => "required",
        
             ]); 
        if($validator->fails()) 
            {          
           echo "Please Enter Category Name";            
            } 
            else
            {
        $id=$request->id;
        $data=FoodMenuCategory::find($id);
        $data->category_name=$request->category_name;
       
        $data->description=$request->description;
        $data->create_by_id=Sentinel::getUser()->id;
        $data->save();
      
       
        echo 'success';

            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FoodMenuCategory  $foodMenuCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
         $id=$request->id;
         $data_check=FoodMenu::where('category_id',(int)$id)->first();
         if($data_check==''):
         FoodMenuCategory::destroy($id);
         echo 'success';
        else:
            echo 'Category in used !!!';
        endif;
    }
}

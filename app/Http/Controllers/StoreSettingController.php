<?php

namespace App\Http\Controllers;

use App\Models\StoreSetting;
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
use Sentinel;
use DB;
use DataTables;
use App\Models\SupplyItemList;
use App\Models\AssignProductFactoryVendor;

class StoreSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $data=StoreSetting::find(1);
       return view('admin.setting.storesetting.index',compact('data'));

    }
    public function store_setting_status(Request $request)
    {
        $data=StoreSetting::find(1);

        $stores=Stores::where('type','=',1)->whereIn('status',[1,2])->get();
        if($request->status==0 && count($stores)>1)
        {
         echo 'Orders cannot be redirect to multiple warehouse';
        }
        else
        {
        $data->status=$request->status;
        $data->save();
        echo 'success';  
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
     * @param  \App\Models\StoreSetting  $storeSetting
     * @return \Illuminate\Http\Response
     */
    public function show(StoreSetting $storeSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StoreSetting  $storeSetting
     * @return \Illuminate\Http\Response
     */
    public function edit(StoreSetting $storeSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StoreSetting  $storeSetting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StoreSetting $storeSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StoreSetting  $storeSetting
     * @return \Illuminate\Http\Response
     */
    public function destroy(StoreSetting $storeSetting)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\TransportCharge;
use Illuminate\Http\Request;
use App\Models\UtensilList;
use App\Models\FanchiseRegistration;
use DataTables;
use Sentinel;
use DB;
use App\Models\Role;
use App\Models\User;
use App\Helpers\CustomHelpers;
use App\Models\State;
use App\Models\District;
use App\Models\City;
use App\Models\PreLaunch;
use App\Models\PreLaunchDoc;
use App\Models\FirstTimeStockCart;
use App\Models\StoreDetails;
use App\Models\ItemImages;
use Validator;
use App\Models\Unit;
use App\Models\MasterGst;


class TransportChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.setting.transport.index');
    }
    
    public function transport(Request $request)
    {
        if ($request->ajax()) {
            $data = TransportCharge::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('unit', function($row){
                  $unit_data=CustomHelpers::get_table_data('units',$row->unit,'unit');
                    return $unit_data;
                })
                ->addColumn('gst', function($row){
                  
                    
                    return CustomHelpers::get_table_data('master_gsts',$row->gst_id,'gst_name');
                })
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="'.url('TransportCharge-Edit/'.$id).'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="'.url('TransportCharge-Delete/'.$id).'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action','unit','gst'])
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
        $states=State::all();
        $units=Unit::all();
        $gsts=MasterGst::all();
         return view('admin.setting.transport.create',compact('states','units','gsts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      

     $checkdata=DB::table('transport_charges')->where([['state', $request->state],['dist', $request->dist],['city', $request->city],['unit',$request->unit]])->first(); 

     

    if($checkdata!='')
    {
         return redirect()->back()->with('error','Already Taken This Location !!!');
    }
    else
    {
     $data=new TransportCharge;
     $data->state=$request->state;
     $data->dist=$request->dist;   
     $data->city=$request->city;
     $data->unit=$request->unit;
     $data->fee=$request->fee;
     $data->gst_id=$request->gst_id;

    
     $data->save();
     return redirect()->route("transport_list")->with("success","Successfully Added");


    }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransportCharge  $transportCharge
     * @return \Illuminate\Http\Response
     */
    public function show(TransportCharge $transportCharge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransportCharge  $transportCharge
     * @return \Illuminate\Http\Response
     */
    public function edit($id,TransportCharge $transportCharge)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (TransportCharge::where('id', $id)->exists()) 
        {
         $data=TransportCharge::find($id);
         $states=State::all();
         $units=Unit::all();
         $gsts=MasterGst::all();

          return view('admin.setting.transport.edit',compact('data','states','units','gsts'));
        }
        else
        {
       return redirect()->route("transport_list")->with("success","No Data Found");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransportCharge  $transportCharge
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, TransportCharge $transportCharge)
    {
       $id=CustomHelpers::custom_decrypt($id);

        $checkdata=DB::table('transport_charges')->where([['state', $request->state],['dist', $request->dist],['city', $request->city],['unit',$request->unit]])->where('id','!=',$id)->first(); 

     

          if($checkdata!='')
          {
         return redirect()->back()->with('error','Already Taken This Location !!!');
          }
          else
          {
         //
         if (TransportCharge::where('id', $id)->exists()) 
        {
         $data=TransportCharge::find($id);
         $data->state=$request->state;
     $data->dist=$request->dist;   
     $data->city=$request->city;
     $data->unit=$request->unit;
     $data->fee=$request->fee;
     $data->gst_id=$request->gst_id;
       
          
    
        $data->save();
        return redirect()->route("transport_list")->with("success","Successfully Updated");

        }
        else
        {
       return redirect()->route("transport_list")->with("success","No Data Found");
        }
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransportCharge  $transportCharge
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransportCharge $transportCharge)
    {
        //
    }
}

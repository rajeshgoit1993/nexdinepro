<?php

namespace App\Http\Controllers;

use App\Models\OutletPaymentMethod;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;
use App\Models\SupplyItemList;
use App\Models\UtensilList;

class OutletPaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.setting.payment_method.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_pos_payment_menthod(Request $request)
    {
        if ($request->ajax()) {
            $data = OutletPaymentMethod::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function($row){
                   if($row->status==1)
                   {
$actionBtn = '<p style="background:green;text-align:center;color:white">Active</p>';
                   }
                   else
                   {
    $actionBtn = '<p style="background:red;text-align:center;color:white">Inactive</p>';
                   }
                
                    
                    return $actionBtn;
                })
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="'.url('POSPaymentMethod-Edit/'.$id).'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> ';
                    return $actionBtn;
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }
    }
    public function create()
    {

        return view('admin.setting.payment_method.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required|unique:outlet_payment_methods",
          
            ]);
        $data=new OutletPaymentMethod;
        $data->name=$request->name;
        $data->status=$request->status;
    
        $data->save();
        return redirect()->route("pos_payment_menthod")->with("success","Payment Method Successfully Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OutletPaymentMethod  $outletPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function show(OutletPaymentMethod $outletPaymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OutletPaymentMethod  $outletPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function edit($id,OutletPaymentMethod $outletPaymentMethod)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (OutletPaymentMethod::where('id', $id)->exists()) 
        {
         $data=OutletPaymentMethod::find($id);
          return view('admin.setting.payment_method.edit',compact('data'));
        }
        else
        {
       return redirect()->route("pos_payment_menthod")->with("success","No Data Found");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OutletPaymentMethod  $outletPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, OutletPaymentMethod $outletPaymentMethod)
    {
       $id=CustomHelpers::custom_decrypt($id);
       $request->validate([
            "name"=>"required|unique:outlet_payment_methods,name,$id",
          
         
            ]);
        
         //
         if (OutletPaymentMethod::where('id', $id)->exists()) 
        {
         $data=OutletPaymentMethod::find($id);
         
        $data->name=$request->name;
        $data->status=$request->status;
    
        $data->save();
        return redirect()->route("pos_payment_menthod")->with("success","Payment Method Successfully Updated");


        }
        else
        {
       return redirect()->route("pos_payment_menthod")->with("success","No Data Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OutletPaymentMethod  $outletPaymentMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(OutletPaymentMethod $outletPaymentMethod)
    {
        //
    }
}

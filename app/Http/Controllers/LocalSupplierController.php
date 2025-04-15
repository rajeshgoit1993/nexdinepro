<?php

namespace App\Http\Controllers;

use App\Models\LocalSupplier;
use Illuminate\Http\Request;
use App\Helpers\CustomHelpers;
use DataTables;
use Sentinel;
use DB;
use Validator;
class LocalSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('outlet.supplier.index');
    }
    public function get_supplier(Request $request)
    {
        if ($request->ajax()) {
            $outlet_id =Sentinel::getUser()->parent_id;
            $data = LocalSupplier::where('outlet_id',$outlet_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
               
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<div class="button_flex"><a href="#" id="'.$id.'" class="edit btn btn-success btn-sm button_left"><i class="fas fa-edit"></i> Edit</a> <a href="#" id="'.$id.'" class="delete remove btn btn-danger btn-sm button_left"><i class="far fa-trash-alt"></i> Delete</a></div>';
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
       $options = view("outlet.supplier.create")->render();
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
        $outlet_id=Sentinel::getUser()->parent_id;
      
        $data=new LocalSupplier;
        $data->outlet_id=Sentinel::getUser()->parent_id;
        $data->supplier_name=$request->supplier_name;
        $data->phone_no=$request->phone_no;
        $data->mail_id=$request->mail_id;
        $data->address=$request->address;
        $data->pincode=$request->pincode;
        $data->gst_no=$request->gst_no;

        $data->save();
        echo 'success';
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LocalSupplier  $localSupplier
     * @return \Illuminate\Http\Response
     */
    public function show(LocalSupplier $localSupplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LocalSupplier  $localSupplier
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,LocalSupplier $localSupplier)
    {
 
         $id=CustomHelpers::custom_decrypt($request->id);
         $data=LocalSupplier::find($id);
        
         $options = view("outlet.supplier.edit",compact('data'))->render();
         echo $options;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LocalSupplier  $localSupplier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LocalSupplier $localSupplier)
    {
        $outlet_id=Sentinel::getUser()->parent_id;
        
        $id=CustomHelpers::custom_decrypt($request->id);
        $data=LocalSupplier::find($id);
        $data->outlet_id=Sentinel::getUser()->parent_id;
        $data->supplier_name=$request->supplier_name;
        $data->phone_no=$request->phone_no;
        $data->mail_id=$request->mail_id;
        $data->address=$request->address;
        $data->pincode=$request->pincode;
        $data->gst_no=$request->gst_no;

        $data->save();
        echo 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LocalSupplier  $localSupplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,LocalSupplier $localSupplier)
    {
       $id=CustomHelpers::custom_decrypt($request->id);
        
         LocalSupplier::destroy($id);
         echo 'success';
    }
}

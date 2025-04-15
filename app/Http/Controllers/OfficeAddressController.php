<?php

namespace App\Http\Controllers;

use App\Models\OfficeAddress;
use Illuminate\Http\Request;
use App\Helpers\CustomHelpers;
use DataTables;
use Sentinel;
use DB;
use Validator;

class OfficeAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.hrms.office.index');
    }
   public function get_office(Request $request)
    {
        if ($request->ajax()) {
            $data = OfficeAddress::latest()->get();
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
        $options = view("admin.hrms.office.create")->render();
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
        $data=new OfficeAddress;
        $data->latitude=$request->latitude;
        $data->longitude=$request->longitude;
        $data->location=$request->location;
      
        $data->save();
        echo 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\OfficeAddress  $officeAddress
     * @return \Illuminate\Http\Response
     */
    public function show(OfficeAddress $officeAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\OfficeAddress  $officeAddress
     * @return \Illuminate\Http\Response
     */
   
   public function edit(Request $request,OfficeAddress $officeAddress)
    {
         $id=$request->id;
         $data=OfficeAddress::find($id);
        
         $options = view("admin.hrms.office.edit",compact('data'))->render();
         echo $options;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\OfficeAddress  $officeAddress
     * @return \Illuminate\Http\Response
     */
    
   public function update(Request $request, OfficeAddress $officeAddress)
    {
       $id=$request->id;
         $data=OfficeAddress::find($id);
        $data->latitude=$request->latitude;
        $data->longitude=$request->longitude;
        $data->location=$request->location;
        $data->save();
        echo 'success';
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\OfficeAddress  $officeAddress
     * @return \Illuminate\Http\Response
     */
   
    public function destroy(Request $request,OfficeAddress $officeAddress)
    {
       $id=$request->id;
        $check_data=DB::table('user_extra_details')->where('office_location_id',$id)->get();
        if(count($check_data)==0)
        {
        OfficeAddress::destroy($id);
         echo 'success';    
        }
        else
        {

          echo 'Location In Used';
         }
        }
}

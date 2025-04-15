<?php

namespace App\Http\Controllers;

use App\Models\HRMSShift;
use Illuminate\Http\Request;
use App\Helpers\CustomHelpers;
use DataTables;
use Sentinel;
use DB;
use Validator;


class HRMSShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.hrms.shift.index');
    }
   public function get_shift(Request $request)
    {
        if ($request->ajax()) {
            $data = HRMSShift::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('login_variance', function($row){
                    

                   
                    return $row->login_variance.' Min';
                })
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
        $options = view("admin.hrms.shift.create")->render();
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
       
        $data=new HRMSShift;
        $data->shift_name=$request->shift_name;
        $data->login_time=$request->login_time;
        $data->logout_time=$request->logout_time;
        $data->lunch_start_time=$request->lunch_start_time;
        $data->lunch_end_time=$request->lunch_end_time;
        $data->login_variance=$request->login_variance;
        $data->save();
        echo 'success';
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HRMSShift  $hRMSShift
     * @return \Illuminate\Http\Response
     */
    public function show(HRMSShift $hRMSShift)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HRMSShift  $hRMSShift
     * @return \Illuminate\Http\Response
     */

   public function edit(Request $request,HRMSShift $weekoff)
    {
         $id=$request->id;
         $data=HRMSShift::find($id);
        
         $options = view("admin.hrms.shift.edit",compact('data'))->render();
         echo $options;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HRMSShift  $hRMSShift
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HRMSShift $hRMSShift)
    {
       $id=$request->id;
         $data=HRMSShift::find($id);
        $data->shift_name=$request->shift_name;
        $data->login_time=$request->login_time;
        $data->logout_time=$request->logout_time;
        $data->lunch_start_time=$request->lunch_start_time;
        $data->lunch_end_time=$request->lunch_end_time;
        $data->login_variance=$request->login_variance;
        $data->save();
        echo 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HRMSShift  $hRMSShift
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,HRMSShift $hRMSShift)
    {
       $id=$request->id;
        $check_data=DB::table('user_extra_details')->where('shift_id',$id)->get();
        if(count($check_data)==0)
        {
       HRMSShift::destroy($id);
         echo 'success';
        }
        else
        {

          echo 'Location In Used';
         }
         
         
    }
}

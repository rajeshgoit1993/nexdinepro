<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Helpers\CustomHelpers;
use DataTables;
use Sentinel;
use DB;
use Validator;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.hrms.holiday.index');
    }
  public function get_holiday(Request $request)
    {
        if ($request->ajax()) {
            $data = Holiday::orderBy('date','ASC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('date', function($row){
                   
                    
                    return date('d-M-Y',strtotime($row->date));
                })
                ->addColumn('holiday_type', function($row){
                    $output='';
                    if($row->holiday_type==1):
                   $output.='<span style="color:gray">Company Holiday</span>';
                    elseif($row->holiday_type==2):
                   $output.='<span style="color:orange">Optional Holiday</span>';
                    elseif($row->holiday_type==3):
                    $output.='<span style="color:green">National Holiday</span>';
                elseif($row->holiday_type==4):
                    $output.='<span style="color:red">Leaving early at 05:00 PM</span>';
                     elseif($row->holiday_type==5):
                    $output.='<span style="color:red">Late Coming at 11:30 AM</span>';

                    endif;
                    
                    return $output;
                })
                ->addColumn('action', function($row){
                    

                    $actionBtn = '<a href="#" id="'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="#" id="'.$row->id.'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action','holiday_type','date'])
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
       $options = view("admin.hrms.holiday.create")->render();
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
         $date=$request->date;
         $check_data=Holiday::where(['outlet_id'=>$outlet_id])->whereDate('date','=',$date)->first();
         if($check_data==''):
            $data=new Holiday;
        $data->date=$request->date;
        $data->year=date('Y');
        $data->outlet_id=Sentinel::getUser()->parent_id;
        $data->holiday=$request->holiday;
        $data->holiday_type=$request->holiday_type;
        $data->save();
        echo 'success';
         else:
        echo $date.' already taken';
         endif;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Holiday $holiday)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Holiday $holiday)
    {
         $id=$request->id;
         $data=Holiday::find($id);
        
         $options = view("admin.hrms.holiday.edit",compact('data'))->render();
         echo $options;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holiday $holiday)
    {
        $outlet_id=Sentinel::getUser()->parent_id;
         $date=$request->date;
         $id=$request->id;
         $check_data=Holiday::where([['outlet_id','=',$outlet_id],['id','!=',$id]])->whereDate('date','=',$date)->first();

    
         if($check_data==''):
            $data=Holiday::find($id);
        $data->date=$request->date;
        $data->year=date('Y');
        $data->outlet_id=Sentinel::getUser()->parent_id;
        $data->holiday=$request->holiday;
        $data->holiday_type=$request->holiday_type;
        $data->save();
        echo 'success';
         else:
        echo $date.' already taken';
         endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Holiday $holiday)
    {
        $id=$request->id;
        
         Holiday::destroy($id);
         echo 'success';
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Weekoff;
use Illuminate\Http\Request;
use App\Helpers\CustomHelpers;
use DataTables;
use Sentinel;
use DB;
use Validator;


class WeekoffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.hrms.weekoff.index');
    }
    public function get_weekoff(Request $request)
    {
        if ($request->ajax()) {
            $data = Weekoff::latest()->get();
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
      
        $options = view("admin.hrms.weekoff.create")->render();
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
         $week_day=$request->week_day;
         $check_data=Weekoff::where(['outlet_id'=>$outlet_id,'week_day'=>$week_day])->first();
         if($check_data==''):
            $data=new Weekoff;
        $data->week_day=$request->week_day;
        $data->year=date('Y');
        $data->outlet_id=Sentinel::getUser()->parent_id;
        $data->save();
        echo 'success';
         else:
        echo $week_day.' already taken';
         endif;
       
       
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Weekoff  $weekoff
     * @return \Illuminate\Http\Response
     */
    public function show(Weekoff $weekoff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Weekoff  $weekoff
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,Weekoff $weekoff)
    {
         $id=$request->id;
         $data=Weekoff::find($id);
        
         $options = view("admin.hrms.weekoff.edit",compact('data'))->render();
         echo $options;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Weekoff  $weekoff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Weekoff $weekoff)
    {
       $outlet_id=Sentinel::getUser()->parent_id;
         $week_day=$request->week_day;
         $id=$request->id;
         $check_data=Weekoff::where([['outlet_id','=',$outlet_id],['week_day','=',$week_day],['id','!=',$id]])->first();
         if($check_data==''):
            $data=Weekoff::find($id);
        $data->week_day=$request->week_day;
        
        $data->outlet_id=Sentinel::getUser()->parent_id;
        $data->save();
        echo 'success';
         else:
        echo $week_day.' already taken';
         endif;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Weekoff  $weekoff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Weekoff $weekoff)
    {
        $id=$request->id;
        
         Weekoff::destroy($id);
         echo 'success';
      
    }
}

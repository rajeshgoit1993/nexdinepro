<?php

namespace App\Http\Controllers;

use App\Models\MasterGst;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;


class MasterGstController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function index()
    {
         return view('admin.setting.gst.index');
    }

       public function gst(Request $request)
    {
        if ($request->ajax()) {
            $data = MasterGst::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="'.url('GSTList-Edit/'.$id).'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="'.url('GSTList-Delete/'.$id).'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
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
         return view('admin.setting.gst.create');
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
            "gst_value"=>"required",
            "gst_name"=>"required",
         
            ]);
        $data=new MasterGst;
        $data->gst_value=$request->gst_value;
        $data->gst_name=$request->gst_name;
    
        $data->save();
        return redirect()->route("gst_list")->with("success","GST List Successfully Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MasterGst  $masterGst
     * @return \Illuminate\Http\Response
     */
    public function show(MasterGst $masterGst)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MasterGst  $masterGst
     * @return \Illuminate\Http\Response
     */
    public function edit($id,MasterGst $masterGst)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (MasterGst::where('id', $id)->exists()) 
        {
         $data=MasterGst::find($id);
          return view('admin.setting.gst.edit',compact('data'));
        }
        else
        {
       return redirect()->route("gst_list")->with("success","No Data Found");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MasterGst  $masterGst
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, MasterGst $masterGst)
    {
       $id=CustomHelpers::custom_decrypt($id);
         $request->validate([
            "gst_value"=>"required",
            "gst_name"=>"required",
         
            ]);

        if (MasterGst::where('id', $id)->exists()) 
        {
         $data=MasterGst::find($id);
          $data->gst_value=$request->gst_value;
        $data->gst_name=$request->gst_name;
    
        $data->save();
        return redirect()->route("gst_list")->with("success","GST List Successfully Updated");
        
        }
        else
        {
       return redirect()->route("gst_list")->with("success","No Data Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MasterGst  $masterGst
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,MasterGst $masterGst)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (MasterGst::where('id', $id)->exists()) 
        {
          MasterGst::destroy($id);
         return redirect()->route('gst_list')->with('success',"GST List Successfully Deleted");
        }
        else
        {
       return redirect()->route("gst_list")->with("success","No Data Found");
        }
    }
}

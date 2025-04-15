<?php

namespace App\Http\Controllers;

use App\Models\CrockeryList;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;

class CrockeryListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('admin.crockery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crockery(Request $request)
    {
        if ($request->ajax()) {
            $data = CrockeryList::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="'.url('CrockeryList-Edit/'.$id).'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="'.url('CrockeryList-Delete/'.$id).'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.crockery.create');
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
            "crockery_name"=>"required",
            "initial_qty"=>"required",
         
            ]);
        $data=new CrockeryList;
        $data->crockery_name=$request->crockery_name;
        $data->initial_qty=$request->initial_qty;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        return redirect()->route("crockery_list")->with("success","Crockery List Successfully Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CrockeryList  $crockeryList
     * @return \Illuminate\Http\Response
     */
    public function show(CrockeryList $crockeryList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CrockeryList  $crockeryList
     * @return \Illuminate\Http\Response
     */
    public function edit($id,CrockeryList $crockeryList)
    {
         $id=CustomHelpers::custom_decrypt($id);
       
        if (CrockeryList::where('id', $id)->exists()) 
        {
         $data=CrockeryList::find($id);
          return view('admin.crockery.edit',compact('data'));
        }
        else
        {
       return redirect()->route("crockery_list")->with("success","No Data Found");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CrockeryList  $crockeryList
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, CrockeryList $crockeryList)
    {
        $id=CustomHelpers::custom_decrypt($id);
         $request->validate([
            "crockery_name"=>"required",
            "initial_qty"=>"required",
         
            ]);

        if (CrockeryList::where('id', $id)->exists()) 
        {
         $data=CrockeryList::find($id);
           $data->crockery_name=$request->crockery_name;
        $data->initial_qty=$request->initial_qty;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        return redirect()->route("crockery_list")->with("success","Crockery List Successfully Updated");
        }
        else
        {
       return redirect()->route("crockery_list")->with("success","No Data Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CrockeryList  $crockeryList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,CrockeryList $crockeryList)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (CrockeryList::where('id', $id)->exists()) 
        {
          CrockeryList::destroy($id);
         return redirect()->route('crockery_list')->with('success',"Crockery List Successfully Deleted");
        }
        else
        {
       return redirect()->route("crockery_list")->with("success","No Data Found");
        }
    }
}

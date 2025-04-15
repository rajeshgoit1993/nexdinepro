<?php

namespace App\Http\Controllers;

use App\Models\EquipmentList;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;

class EquipmentListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         return view('admin.equipmentlist.index');
    }
   public function equipment(Request $request)
    {
        if ($request->ajax()) {
            $data = EquipmentList::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="'.url('EquipmentList-Edit/'.$id).'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="'.url('EquipmentList-Delete/'.$id).'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
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
        return view('admin.equipmentlist.create');
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
            "equipment_name"=>"required",
            "initial_qty"=>"required",
         
            ]);
        $data=new EquipmentList;
        $data->equipment_name=$request->equipment_name;
        $data->initial_qty=$request->initial_qty;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        return redirect()->route("equipment_list")->with("success","Equipment List Successfully Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EquipmentList  $equipmentList
     * @return \Illuminate\Http\Response
     */
    public function show(EquipmentList $equipmentList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EquipmentList  $equipmentList
     * @return \Illuminate\Http\Response
     */
    public function edit($id,EquipmentList $equipmentList)
    {
       $id=CustomHelpers::custom_decrypt($id);
       
        if (EquipmentList::where('id', $id)->exists()) 
        {
         $data=EquipmentList::find($id);
          return view('admin.equipmentlist.edit',compact('data'));
        }
        else
        {
       return redirect()->route("equipment_list")->with("success","No Data Found");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EquipmentList  $equipmentList
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, EquipmentList $equipmentList)
    {
        $id=CustomHelpers::custom_decrypt($id);
         $request->validate([
            "equipment_name"=>"required",
            "initial_qty"=>"required",
         
            ]);

        if (EquipmentList::where('id', $id)->exists()) 
        {
         $data=EquipmentList::find($id);
           $data->equipment_name=$request->equipment_name;
        $data->initial_qty=$request->initial_qty;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        return redirect()->route("equipment_list")->with("success","Equipment List Successfully Updated");
        }
        else
        {
       return redirect()->route("equipment_list")->with("success","No Data Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EquipmentList  $equipmentList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,EquipmentList $equipmentList)
    {
       $id=CustomHelpers::custom_decrypt($id);
       
        if (EquipmentList::where('id', $id)->exists()) 
        {
          EquipmentList::destroy($id);
         return redirect()->route('equipment_list')->with('success',"Equipment List Successfully Deleted");
        }
        else
        {
       return redirect()->route("equipment_list")->with("success","No Data Found");
        }
    
    }
}

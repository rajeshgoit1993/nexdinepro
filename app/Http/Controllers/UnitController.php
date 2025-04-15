<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;
use App\Models\SupplyItemList;
use App\Models\UtensilList;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.setting.unit.index');
    }
    public function unit(Request $request)
    {
        if ($request->ajax()) {
            $data = Unit::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="'.url('Unit-Edit/'.$id).'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="'.url('Unit-Delete/'.$id).'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
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
        return view('admin.setting.unit.create');
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
            "unit"=>"required|unique:units",
          
         
            ]);
        $data=new Unit;
        $data->unit=$request->unit;
        
    
        $data->save();
        return redirect()->route("unit_list")->with("success","Unit Successfully Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Unit $unit)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (Unit::where('id', $id)->exists()) 
        {
         $data=Unit::find($id);
          return view('admin.setting.unit.edit',compact('data'));
        }
        else
        {
       return redirect()->route("unit_list")->with("success","No Data Found");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, Unit $unit)
    {
        $id=CustomHelpers::custom_decrypt($id);
       $request->validate([
            "unit"=>"required|unique:units,unit,$id",
          
         
            ]);
        
         //
         if (Unit::where('id', $id)->exists()) 
        {
         $data=Unit::find($id);
         
          $data->unit=$request->unit;
    
    
        $data->save();
        return redirect()->route("unit_list")->with("success","Unit Successfully Updated");

        }
        else
        {
       return redirect()->route("unit_list")->with("success","No Data Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Unit $unit)
    {
       $id=CustomHelpers::custom_decrypt($id);
       
        if (Unit::where('id', $id)->exists()) 
        {
             
          $data1_check=SupplyItemList::where('unit','=',$id)->get();
          $data2_check=UtensilList::where('unit','=',$id)->get();
         if(count($data1_check)==0 && count($data2_check)==0):
          Unit::destroy($id);  
return redirect()->route('unit_list')->with('success',"Unit Successfully Deleted");
        else:
return redirect()->route('unit_list')->with('success',"Unit cannot be deleted");
        endif;
         
        }
        else
        {
       return redirect()->route("unit_list")->with("success","No Data Found");
        }
    }
}

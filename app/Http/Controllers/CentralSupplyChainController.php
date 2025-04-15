<?php

namespace App\Http\Controllers;

use App\Models\CentralSupplyChain;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;

class CentralSupplyChainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.central_supply_chain.index');
    }
    public function central_supply_chain(Request $request)
    {
        if ($request->ajax()) {
            $data = CentralSupplyChain::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="'.url('Central-Supply-Chain-Edit/'.$id).'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="'.url('Central-Supply-Chain-Delete/'.$id).'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
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
        return view('admin.central_supply_chain.create');
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
            "central_supply_chain_name"=>"required",
            "initial_qty"=>"required",
         
            ]);
        $data=new CentralSupplyChain;
        $data->central_supply_chain_name=$request->central_supply_chain_name;
        $data->initial_qty=$request->initial_qty;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        return redirect()->route("central_supply_chain_list")->with("success","CentralSupplyChain List Successfully Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CentralSupplyChain  $centralSupplyChain
     * @return \Illuminate\Http\Response
     */
    public function show(CentralSupplyChain $centralSupplyChain)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CentralSupplyChain  $centralSupplyChain
     * @return \Illuminate\Http\Response
     */
    public function edit($id,CentralSupplyChain $centralSupplyChain)
    {
         $id=CustomHelpers::custom_decrypt($id);
       
        if (CentralSupplyChain::where('id', $id)->exists()) 
        {
         $data=CentralSupplyChain::find($id);
          return view('admin.central_supply_chain.edit',compact('data'));
        }
        else
        {
       return redirect()->route("central_supply_chain_list")->with("success","No Data Found");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CentralSupplyChain  $centralSupplyChain
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, CentralSupplyChain $centralSupplyChain)
    {
      $id=CustomHelpers::custom_decrypt($id);
         $request->validate([
            "central_supply_chain_name"=>"required",
            "initial_qty"=>"required",
         
            ]);

        if (CentralSupplyChain::where('id', $id)->exists()) 
        {
         $data=CentralSupplyChain::find($id);
           $data->central_supply_chain_name=$request->central_supply_chain_name;
        $data->initial_qty=$request->initial_qty;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        return redirect()->route("central_supply_chain_list")->with("success","CentralSupplyChain List Successfully Updated");
        }
        else
        {
       return redirect()->route("central_supply_chain_list")->with("success","No Data Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CentralSupplyChain  $centralSupplyChain
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,CentralSupplyChain $centralSupplyChain)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (CentralSupplyChain::where('id', $id)->exists()) 
        {
          CentralSupplyChain::destroy($id);
         return redirect()->route('central_supply_chain_list')->with('success',"CentralSupplyChain List Successfully Deleted");
        }
        else
        {
       return redirect()->route("central_supply_chain_list")->with("success","No Data Found");
        }
    }
}

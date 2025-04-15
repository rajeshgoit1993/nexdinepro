<?php

namespace App\Http\Controllers;

use App\Models\LocalPurchaseList;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;


class LocalPurchaseListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.local_purchase_list.index');
    }
    public function local_purchase_list(Request $request)
    {
        if ($request->ajax()) {
            $data = LocalPurchaseList::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="'.url('Local-Purchase-Edit/'.$id).'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="'.url('Local-Purchase-Delete/'.$id).'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
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
        return view('admin.local_purchase_list.create');
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
            "local_purchase_name"=>"required",
            "initial_qty"=>"required",
         
            ]);
        $data=new LocalPurchaseList;
        $data->local_purchase_name=$request->local_purchase_name;
        $data->initial_qty=$request->initial_qty;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        return redirect()->route("local_purchase")->with("success","Local Purchase List Successfully Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\LocalPurchaseList  $localPurchaseList
     * @return \Illuminate\Http\Response
     */
    public function show(LocalPurchaseList $localPurchaseList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\LocalPurchaseList  $localPurchaseList
     * @return \Illuminate\Http\Response
     */
    public function edit($id,LocalPurchaseList $localPurchaseList)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (LocalPurchaseList::where('id', $id)->exists()) 
        {
         $data=LocalPurchaseList::find($id);
          return view('admin.local_purchase_list.edit',compact('data'));
        }
        else
        {
       return redirect()->route("local_purchase")->with("success","No Data Found");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LocalPurchaseList  $localPurchaseList
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, LocalPurchaseList $localPurchaseList)
    {
        $id=CustomHelpers::custom_decrypt($id);
         $request->validate([
            "local_purchase_name"=>"required",
            "initial_qty"=>"required",
         
            ]);

        if (LocalPurchaseList::where('id', $id)->exists()) 
        {
         $data=LocalPurchaseList::find($id);
           $data->local_purchase_name=$request->local_purchase_name;
        $data->initial_qty=$request->initial_qty;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        return redirect()->route("local_purchase")->with("success","Local Purchase List Successfully Updated");
        }
        else
        {
       return redirect()->route("local_purchase")->with("success","No Data Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LocalPurchaseList  $localPurchaseList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,LocalPurchaseList $localPurchaseList)
    {
       $id=CustomHelpers::custom_decrypt($id);
       
        if (LocalPurchaseList::where('id', $id)->exists()) 
        {
          LocalPurchaseList::destroy($id);
         return redirect()->route('local_purchase')->with('success',"Local Purchase List Successfully Deleted");
        }
        else
        {
       return redirect()->route("local_purchase")->with("success","No Data Found");
        }
    }
}

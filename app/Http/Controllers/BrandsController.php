<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use Illuminate\Http\Request;
use App\Models\UtensilList;
use App\Models\FanchiseRegistration;
use DataTables;
use Sentinel;
use DB;
use App\Helpers\CustomHelpers;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.setting.brand.index');
    }
    public function brand(Request $request)
    {
        if ($request->ajax()) {
            $data = Brands::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                 ->addColumn('brand_logo', function($row){
                  
      
          if($row->brand_logo!=''):
            $path=url('public/uploads/logo/'.$row->brand_logo);
                    $image = '<img src="'.$path.'" width="100px">';
           else:
           $image = 'NA';
           endif;
                    return $image;
                })
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="'.url('Brand-Edit/'.$id).'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="'.url('Brand-Delete/'.$id).'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action','brand_logo'])
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
       return view('admin.setting.brand.create');
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
            "brand"=>"required|unique:brands",
          
         
            ]);
        $data=new Brands;
        $data->brand=$request->brand;
        $data->terms=$request->terms;
        $data->extra_policy=$request->extra_policy;
        if($request->hasFile('brand_logo')):
        $brand_logo=$request->file('brand_logo');
        $brand_logo_name=rand(0,99999).".".$brand_logo->getClientOriginalExtension();
        $path=public_path('/uploads/logo');
        $brand_logo->move($path,$brand_logo_name);
        $data->brand_logo=$brand_logo_name;
        endif;

    
        $data->save();
        return redirect()->route("brand_list")->with("success","Brand Successfully Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    public function show(Brands $brands)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Brands $brands)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (Brands::where('id', $id)->exists()) 
        {
         $data=Brands::find($id);
          return view('admin.setting.brand.edit',compact('data'));
        }
        else
        {
       return redirect()->route("brand_list")->with("success","No Data Found");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, Brands $brands)
    {
         $id=CustomHelpers::custom_decrypt($id);
       $request->validate([
            "brand"=>"required|unique:brands,brand,$id",
          
         
            ]);
        
         //
         if (Brands::where('id', $id)->exists()) 
        {
         $data=Brands::find($id);
          $data->terms=$request->terms;
          $data->extra_policy=$request->extra_policy;
          $data->brand=$request->brand;
        if($request->hasFile('brand_logo')):
        $brand_logo=$request->file('brand_logo');
        $brand_logo_name=rand(0,99999).".".$brand_logo->getClientOriginalExtension();
        $path=public_path('/uploads/logo');
        $brand_logo->move($path,$brand_logo_name);
          $data->brand_logo=$brand_logo_name;
        endif;

    
        $data->save();
        return redirect()->route("brand_list")->with("success","Brand Successfully Updated");

        }
        else
        {
       return redirect()->route("brand_list")->with("success","No Data Found");
        }


      
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brands  $brands
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Brands $brands)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (Brands::where('id', $id)->exists()) 
        {
             
          $data1_check=FanchiseRegistration::where('brands','=',$id)->get();
          $data2_check=UtensilList::where('thumb','=',$id)->get();
         if(count($data1_check)==0 && count($data2_check)==0):
          Brands::destroy($id);  
return redirect()->route('brand_list')->with('success',"Brands Successfully Deleted");
        else:
return redirect()->route('brand_list')->with('success',"Brands cannot be deleted");
        endif;
         
        }
        else
        {
       return redirect()->route("brand_list")->with("success","No Data Found");
        }
    }
}

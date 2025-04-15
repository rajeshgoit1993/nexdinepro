<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\State;
use App\Models\District;
use Validator;
use App\Models\PageAccess;
use App\Models\Brands;
use Sentinel;
use DB;
use DataTables;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $states=State::all();
        return view('admin.setting.city.index',compact('states'));
    }

    public function get_city(Request $request)
    {
        if ($request->ajax()) {
            $dist_id=$request->dist_id;

            $data = City::where('districtid','=',$dist_id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
            
                ->addColumn('action', function($row){
                    $id=$row->id;

                    $actionBtn = '<a href="#" id="'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="#" id="'.$row->id.'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function city_save(Request $request)
   {
    

      $data_validation=City::where('name','=',$request->name)->first();
     if($data_validation==''):
   
      $data=new City;
     $data->districtid=$request->districtid;
     $data->state_id=$request->state_id;
     $data->name=$request->name;
     $data->status='Active';
     $data->save();
     echo 'success';
     else:
     echo 'City already taken';
     endif;
     
    
   }
    public function edit_city(Request $request)
   {
     $id=$request->id;
     $data=City::find($id);
     $output='<input type="hidden" name="id" value="'.$id.'"/>
             <div class="form-group">
<label for="" >City</label>
<input type="text" name="name" class="form-control" required value="'.$data->name.'">

 
</div>
<button type="submit" class="btn btn-success">Update</button>
             
             ';
     echo $output;
   }
    public function update_city(Request $request)
   {

     $id=$request->id;
     $data_validation=City::where([['name','=',$request->name],['id','!=',$id]])->first();
     if($data_validation==''):
   
   $data=City::find($id);

     $data->name=$request->name;
     $data->save();
     echo 'success';
     else:
     echo 'City already taken';
     endif;


     
   }
   public function delete_city(Request $request)
   {
     $id=(int)$request->id;
    
     
      City::destroy($id);
    echo 'success';
   }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
    }
}

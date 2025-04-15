<?php

namespace App\Http\Controllers;

use App\Models\RegionSetting;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;
use App\Helpers\POS_SettingHelpers;
use App\Models\User;
use DB;
use App\Models\PageAccess;
use App\Models\RegionWiseOutlet;

class RegionSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        
      return view('admin.setting.region.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=DB::table('users')
         ->join('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
         
         ->whereIn('users.registration_level',[2,1])
         
         ->select('users.*')  
        ->get();
        $previous_data=RegionSetting::all();
        $previous_id=[];
        foreach($previous_data as $p_d):
             $outlet_ids=unserialize($p_d->assign_outlet);
             foreach($outlet_ids as $d):
                $previous_id[]=$d;
             endforeach;
        endforeach;
        $previous_ids=array_unique($previous_id);
        $users=DB::table('page_accesses')
            ->join('role_users','role_users.role_id','=','page_accesses.role_id')
            ->join('users','users.id','=','role_users.user_id')
            ->where('area_manager_work',1)->get();     
        return view('admin.setting.region.create',compact('data','previous_ids','users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get_region(Request $request)
    {
        if ($request->ajax()) {
            $data = RegionSetting::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('outlet', function($row){
                  $outlets=unserialize($row->assign_outlet);
                  $output='';
                  $a=1;
                   foreach($outlets as $datas):
    $rows_data=User::find($datas);
     $output.=$a++.'.&nbsp;'.$rows_data->name.'('.$rows_data->city.')'.'<hr style=margin:0px;padding:2px>';
            endforeach;
                    return $output;
                })
                ->addColumn('area_manager', function($row){
                 $user=User::find($row->assign_area_manager);
                 if($user!=''):
                    return $user->name;
                 else:
                    return 'NA';
                 endif;

                    
                })
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="'.url('Region-Edit/'.$id).'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="'.url('Region-Delete/'.$id).'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action','outlet','area_manager'])
                ->make(true);
        }
    }
    public function store(Request $request)
    {
        $request->validate([
            "region_name"=>"required|unique:region_settings",
          
            ]);
        $data=new RegionSetting;
        $data->region_name=$request->region_name;
        $data->assign_outlet=serialize($request->assign_outlet);
        $data->assign_area_manager=$request->assign_area_manager;
        $data->save();
        
        $outlets=$request->assign_outlet;
        foreach($outlets as $outlet)
        {
            $data_outlet=new RegionWiseOutlet;
            $data_outlet->region_id=$data->id;
            $data_outlet->outlet_id=$outlet;
               
            $data_outlet->save();
        }

        return redirect()->route("region")->with("success","Region Successfully Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RegionSetting  $regionSetting
     * @return \Illuminate\Http\Response
     */
    public function show(RegionSetting $regionSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RegionSetting  $regionSetting
     * @return \Illuminate\Http\Response
     */
    public function edit($id,RegionSetting $regionSetting)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (RegionSetting::where('id', $id)->exists()) 
        {
         $region_data=RegionSetting::find($id);
         $data=DB::table('users')
         ->join('fanchise_registrations','fanchise_registrations.fanchise_id' , '=', 'users.id')
        
         ->whereIn('users.registration_level',[2,1])
         
         ->select('users.*')  
        ->get();
        $previous_data=RegionSetting::where('id','!=',$id)->get();
        $previous_id=[];
        foreach($previous_data as $p_d):
             $outlet_ids=unserialize($p_d->assign_outlet);
             foreach($outlet_ids as $d):
                $previous_id[]=$d;
             endforeach;
        endforeach;
        $previous_ids=array_unique($previous_id);
          
        $current_data=RegionSetting::where('id','=',$id)->get();
        $current_id=[];
        foreach($current_data as $p_d):
             $outlet_ids=unserialize($p_d->assign_outlet);
             foreach($outlet_ids as $d):
                $current_id[]=$d;
             endforeach;
        endforeach;
        $current_ids=array_unique($current_id);
        $users=DB::table('page_accesses')
            ->join('role_users','role_users.role_id','=','page_accesses.role_id')
            ->join('users','users.id','=','role_users.user_id')
            ->where('area_manager_work',1)->get(); 
          return view('admin.setting.region.edit',compact('region_data','data','previous_ids','current_ids','users'));
        }
        else
        {
       return redirect()->route("region")->with("success","No Data Found");
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RegionSetting  $regionSetting
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, RegionSetting $regionSetting)
    {
        $id=CustomHelpers::custom_decrypt($id);
       $request->validate([
            "region_name"=>"required|unique:region_settings,region_name,$id",
          
         
            ]);
        
         //
         if (RegionSetting::where('id', $id)->exists()) 
        {
         $data=RegionSetting::find($id);
         
        $data->region_name=$request->region_name;
        $data->assign_outlet=serialize($request->assign_outlet);
        $data->assign_area_manager=$request->assign_area_manager;
        $data->save();

        $previous_data=RegionWiseOutlet::where('region_id','=',$data->id)->delete();
        $outlets=$request->assign_outlet;
        foreach($outlets as $outlet)
        {
            $data_outlet=new RegionWiseOutlet;
            $data_outlet->region_id=$data->id;
            $data_outlet->outlet_id=$outlet;
               
            $data_outlet->save();
        }

        return redirect()->route("region")->with("success","Region Successfully Updated");


        }
        else
        {
       return redirect()->route("region")->with("success","No Data Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RegionSetting  $regionSetting
     * @return \Illuminate\Http\Response
     */
  
    public function destroy($id,RegionSetting $regionSetting)
    {
       $id=CustomHelpers::custom_decrypt($id);
       
        if (RegionSetting::where('id', $id)->exists()) 
        {
         RegionWiseOutlet::where('region_id','=',$id)->delete();    
         RegionSetting::destroy($id);  
       return redirect()->route('region')->with('success',"Region Successfully Deleted");
         
        }
        else
        {
       return redirect()->route("region")->with("success","No Data Found");
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\UtensilList;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;
use Image;
use App\Models\ItemImages;
use App\Models\MasterGst;
use App\Models\Brands;
use App\Models\Unit;
use File;
use Excel;

class UtensilListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $csv=url("public/uploads/utensil_lists.csv");
         $rows=array();
         $rows=file($csv);
         $data_size=sizeof($rows);
     
   //     foreach($rows as $row):
   //   $data_array=explode(",",$row);
   //    if($data_array['0']!=''):
   // $data=new UtensilList;

   // $data->utensil_name=$data_array['0'];
   // $data->initial_qty=$data_array['1'];
   // $data->unit=$data_array['2'];
   // $data->item_type=$data_array['3'];
   // $data->rate_margin=$data_array['4'];
   // $data->rate_fanchise=$data_array['5'];
   // $data->thumb=11;
   // if($data_array['6']=='5%'):
   //  $data->gst_id=3;
   // elseif($data_array['6']=='12%'):
   //  $data->gst_id=5;
   // elseif($data_array['6']=='18%'):
   //  $data->gst_id=4;
   // endif;
   
   // $data->save();

   // endif;


   //   endforeach;
   //  echo "hi";
    //   dd($rows);
         $brands=Brands::all();
       return view('admin.utensillist.index',compact('brands'));
    }
    public function delete_item_image(Request $request)
    {
        $id=CustomHelpers::custom_decrypt($request->id);
        $old=ItemImages::destroy($id);
          
    }
    public function get_item_image(Request $request)
    {
        $id=CustomHelpers::custom_decrypt($request->id);
        
      $image_datas=ItemImages::where('item_id','=',$id)->get();
      $output='<table class="table">
    <thead>
      <tr>
        <th>Image</th>
        
        <th>Default</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>';
      foreach($image_datas as $images):
        $path=url('public/uploads/item/thumb/'.$images->thumb);
        
        $checked='';
        if($images->default=='1'):
        $checked='checked';
        endif;         
        $image_id=CustomHelpers::custom_encrypt($images->id);
       $output.='<tr>
        <td><img src="'.$path.'" width="100px"></td>
        
        <td><label class="form-check-label">
    <input type="radio" class="form-check-input" name="default" '.$checked.' value="'.$image_id.'">
  </label>  </td>
  <td>
 <a href="#" class="delete_image  btn btn-danger btn-sm" id="'.$image_id.'"><i class="far fa-trash-alt"></i> Delete</a>
  </td>
      </tr>';
      endforeach;  
      $output.=' </tbody></table>';
      echo $output;
    }
    public function utensil(Request $request)
    {
        if ($request->ajax()) {
            $brand=$request->brand;
            $item_type=$request->item_type;
            if($brand=='NA' && $item_type=='NA'):
                $data = UtensilList::latest()->get();
            elseif($brand=='NA' && $item_type!='NA'):
                $data = UtensilList::where('item_type','=',$item_type)->get();
            elseif($brand!='NA' && $item_type=='NA'):
                $data = UtensilList::where('thumb','=',(int)$brand)->get();
            elseif($brand!='NA' && $item_type!='NA'):
                $data = UtensilList::where([['thumb','=',(int)$brand],['item_type','=',$item_type]])->get();
            endif;
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function($row){
                  
          $image_data=ItemImages::where([['item_id','=',$row->id],['default','=',1],['image_type','=',0]])->first();
          if($image_data!='' && $image_data->thumb!=''):
            $path=url('public/uploads/item/thumb/'.$image_data->thumb);
                    $image = '<img src="'.$path.'" width="100px">';
          else:
           $image = 'NA';
          endif;
                    return $image;
                })
                  ->addColumn('gst', function($row){
                 if($row->gst_id!=''):
                       $gst_data=MasterGst::find($row->gst_id);
          if($gst_data!='')
          {
            return $gst_data->gst_name;
          }
          else
          {
            return 'Not Updated';
          }
             else:
                return 'Not Updated';
             endif;
                    
                })
                  ->addColumn('unit', function($row){
                 if($row->unit!=''):
          $unit=Unit::find($row->unit);
                 return $unit->unit;
             else:
                return 'Not Updated';
             endif;
                    
                })
                  ->addColumn('thumb', function($row){
                 if($row->thumb!=''):
          $thumb=Brands::find($row->thumb);
                 return $thumb->brand;
             else:
                return 'Not Updated';
             endif;
                    
                })
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="#" style="display:inline-block;margin-top:5px;width:100%" class="btn btn-primary btn-sm uploads" id="'.$id.'">
                    <i class="fas fa-edit"></i> Uploads </a> 
                    <a href="#" style="display:inline-block;margin-top:5px;width:100%" id="'.$id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> 
                    <a href="'.url('UtensilList-Delete/'.$id).'" style="display:inline-block;margin-top:5px;width:100%" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action','image','gst','unit'])
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
        $gsts=MasterGst::all();
        $brands=Brands::all();
        $units=Unit::all();
       return view('admin.utensillist.create',compact('gsts','brands','units'));
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
            "utensil_name"=>"required",
            "initial_qty"=>"required",
         
            ]);
        $data=new UtensilList;

        

        
        $data->gst_id=$request->gst_id;
        $data->item_type=$request->item_type;
        $data->utensil_name=$request->utensil_name;
        $data->unit=$request->unit;
        $data->thumb=$request->thumb;
        $data->rate_margin=$request->rate_margin;
        $data->rate_fanchise=$request->rate_fanchise;
        $data->initial_qty=$request->initial_qty;
        $data->description=$request->description;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        
        

       
   
        return redirect()->route("utensil_list")->with("success","List Successfully Added");
    }
    public function uploads_list_image(Request $request)
    {

       if($request->has('default')):
        $id=CustomHelpers::custom_decrypt($request->id);
        $old_id=CustomHelpers::custom_decrypt($request->default);
        $old_data=ItemImages::where('item_id','=',$id)->get();
        foreach($old_data as $old_datas):
           $old=ItemImages::find($old_datas->id);
           if($old_datas->id==$old_id):
           $old->default=1;
           else:
           $old->default=0;
           endif;
          
           $old->save();
        endforeach;

       if($request->hasFile('images')):
        
        
        $images = $request->file('images');

        foreach($images as $image)
         {
        $new_name = rand().'.'.$image->getClientOriginalExtension();
       //
        $destinationPath_thumb = public_path('/uploads/item/thumb');
        $thumb_name = rand().'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->resize(400, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath_thumb.'/'.$thumb_name);
      
       $destinationPath = public_path('/uploads/item/images');
      
        $img_main = Image::make($image->getRealPath());
        $img_main->resize(1024, 768, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$new_name);
       

        
         $image_data=new ItemImages;
         $image_data->item_id=$id;
         $image_data->images=$new_name;
         $image_data->thumb=$thumb_name;
         $image_data->image_type=$request->image_type;
        $image_data->save();
       
       }
       echo "success";
  else:
 echo "success";
  endif;
        else:
       if($request->hasFile('images')):
        $id=CustomHelpers::custom_decrypt($request->id);
        
        $images = $request->file('images');
        $a=1;
        foreach($images as $image)
         {
        $new_name = rand().'.'.$image->getClientOriginalExtension();
       //
        $destinationPath_thumb = public_path('/uploads/item/thumb');
        $thumb_name = rand().'.'.$image->getClientOriginalExtension();
        $img = Image::make($image->getRealPath());
        $img->resize(400, 300, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath_thumb.'/'.$thumb_name);
      
       $destinationPath = public_path('/uploads/item/images');
      
        $img_main = Image::make($image->getRealPath());
        $img_main->resize(1024, 768, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$new_name);
       

        
         $image_data=new ItemImages;
         $image_data->item_id=$id;
         $image_data->images=$new_name;
         $image_data->thumb=$thumb_name;
         
         if($a==1):
         $image_data->default=1;
        endif;
        $image_data->save();
       $a++;
       }
       echo "success";
  else:
 echo "success";
  endif;
        endif;

       
       
      
       
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UtensilList  $utensilList
     * @return \Illuminate\Http\Response
     */
    public function show(UtensilList $utensilList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UtensilList  $utensilList
     * @return \Illuminate\Http\Response
     */
    
   public function edit_first_stock(Request $request)
   {
    $id=CustomHelpers::custom_decrypt($request->id);
    $gsts=MasterGst::all();
    $data=UtensilList::find($id);
    $brands=Brands::all();
    $units=Unit::all();
    $options = view('admin.utensillist.edit',compact('data','gsts','brands','units'))->render();
    echo $options;


   }
    public function edit($id,UtensilList $utensilList)
    {
        $id=CustomHelpers::custom_decrypt($id);
       
        if (UtensilList::where('id', $id)->exists()) 
        {
            $gsts=MasterGst::all();
         $data=UtensilList::find($id);
          $brands=Brands::all();
        $units=Unit::all();
          return view('admin.utensillist.edit',compact('data','gsts','brands','units'));
        }
        else
        {
       return redirect()->route("utensil_list")->with("success","No Data Found");
        }
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UtensilList  $utensilList
     * @return \Illuminate\Http\Response
     */
    public function update_first_stock(Request $request)
    {
     $id=CustomHelpers::custom_decrypt($request->id);
         $request->validate([
            "utensil_name"=>"required",
            "initial_qty"=>"required",
         
            ]);

        if (UtensilList::where('id', $id)->exists()) 
        {
         $data=UtensilList::find($id);
         $data->gst_id=$request->gst_id;
        $data->item_type=$request->item_type;
        $data->utensil_name=$request->utensil_name;
        $data->unit=$request->unit;
        $data->rate_margin=$request->rate_margin;
        $data->rate_fanchise=$request->rate_fanchise;
        $data->initial_qty=$request->initial_qty;
        $data->description=$request->description;
        $data->user_id=Sentinel::getUser()->id;
        $data->thumb=$request->thumb;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        echo 'success';
        }
        else
        {
        echo 'error';
        }
    }
    public function update($id,Request $request, UtensilList $utensilList)
    {
         $id=CustomHelpers::custom_decrypt($id);
         $request->validate([
            "utensil_name"=>"required",
            "initial_qty"=>"required",
         
            ]);

        if (UtensilList::where('id', $id)->exists()) 
        {
         $data=UtensilList::find($id);
         $data->gst_id=$request->gst_id;
        $data->item_type=$request->item_type;
        $data->utensil_name=$request->utensil_name;
        $data->unit=$request->unit;
        $data->rate_margin=$request->rate_margin;
        $data->rate_fanchise=$request->rate_fanchise;
        $data->initial_qty=$request->initial_qty;
        $data->description=$request->description;
        $data->user_id=Sentinel::getUser()->id;
        $data->thumb=$request->thumb;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        return redirect()->route("utensil_list")->with("success","Utensil List Successfully Updated");
        }
        else
        {
       return redirect()->route("utensil_list")->with("success","No Data Found");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UtensilList  $utensilList
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,UtensilList $utensilList)
    {
       $id=CustomHelpers::custom_decrypt($id);
       
        if (UtensilList::where('id', $id)->exists()) 
        {
          UtensilList::destroy($id);
         return redirect()->route('utensil_list')->with('success',"Utensil List Successfully Deleted");
        }
        else
        {
       return redirect()->route("utensil_list")->with("success","No Data Found");
        }
    }
}

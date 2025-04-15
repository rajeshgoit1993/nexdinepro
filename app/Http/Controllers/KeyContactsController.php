<?php

namespace App\Http\Controllers;

use App\Models\KeyContacts;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use Validator;

class KeyContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $data=KeyContacts::all();
       return view("admin.keycontacts.index",compact("data"));
    }
    public function get_key_contacts(Request $request)
    {
        if ($request->ajax()) {
            $data = KeyContacts::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                
                ->addColumn('personal_details', function($row){
                    $anniversary = ($row->anniversary =='') ? 'NA' : $row->anniversary;
                 $basic_details="<b>Name:</b> $row->name
                 <hr style='margin:0px'>
                 <b>Contact No:</b> $row->contact_no
                 <hr style='margin:0px'>
                 <b>DOB:</b> $row->dob
                 <hr style='margin:0px'>
                 <b>Anniversary:</b> $anniversary";
                    return $basic_details;
                })
                ->addColumn('spouse_details', function($row){
                    $spouse_name = ($row->spouse_name =='') ? 'NA' : $row->spouse_name;
                    $spouse_dob = ($row->spouse_dob =='') ? 'NA' : $row->spouse_dob;
                 $basic_details="<b>Spouse Name:</b> $spouse_name
                 <hr style='margin:0px'>
                 
                 <b>Spouse DOB:</b> $spouse_dob";
                    return $basic_details;
                })
                ->addColumn('action', function($row){
                    

                    $actionBtn = '<a href="#" id="'.$row->id.'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="#" id="'.$row->id.'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['personal_details','action','spouse_details'])
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
       $options = view("admin.keycontacts.create")->render();
        echo $options;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), 
              [ 
            "contact_no"=>"required|unique:key_contacts",
           
             ]); 
           if($validator->fails()) 
            { 
                $a='';
            $messages = $validator->messages();
             foreach ($messages->all(':message') as $message)
            {
                $a= $message;
            }
              
           echo $a;            
            } 
            else
            {
       $data=new KeyContacts;
          
        $data->key_contacts_type=$request->key_contacts_type;
        $data->name=$request->name;
        $data->contact_no=$request->contact_no;
        $data->dob=$request->dob;
        $data->address=$request->address;
        $data->anniversary=$request->anniversary;
        $data->spouse_name=$request->spouse_name;
        $data->spouse_dob=$request->spouse_dob;
        $data->save();
        echo 'success';

            }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\KeyContacts  $keyContacts
     * @return \Illuminate\Http\Response
     */
    public function show(KeyContacts $keyContacts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\KeyContacts  $keyContacts
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id=$request->id;
         $data=KeyContacts::find($id);
         $options = view("admin.keycontacts.edit",compact('data'))->render();
         echo $options;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\KeyContacts  $keyContacts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, KeyContacts $keyContacts)
    {
        $id=$request->id;
        
        $validator = Validator::make($request->all(), 
              [ 
          "contact_no"=>"required|unique:key_contacts,contact_no,$id",
           
             ]); 
           if($validator->fails()) 
            {          
           $a='';
            $messages = $validator->messages();
             foreach ($messages->all(':message') as $message)
            {
                $a= $message;
            }
              
           echo $a;   
            } 
            else
            {
       
         $data=KeyContacts::find($id);
        $data->key_contacts_type=$request->key_contacts_type;
        $data->name=$request->name;
        $data->contact_no=$request->contact_no;
        $data->dob=$request->dob;
        $data->address=$request->address;
        $data->anniversary=$request->anniversary;
        $data->spouse_name=$request->spouse_name;
        $data->spouse_dob=$request->spouse_dob;
        $data->save();
        
        echo 'success';

            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\KeyContacts  $keyContacts
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
          KeyContacts::destroy($id);
         echo 'success';  
    }
}

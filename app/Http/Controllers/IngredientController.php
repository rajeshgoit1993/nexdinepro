<?php

namespace App\Http\Controllers;

use App\Models\Ingredient;
use Illuminate\Http\Request;
use DataTables;
use Sentinel;
use App\Helpers\CustomHelpers;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('admin.ingredients.index');
    }
    public function ingredients_list(Request $request)
    {
        if ($request->ajax()) {
            $data = Ingredient::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $id=CustomHelpers::custom_encrypt($row->id);

                    $actionBtn = '<a href="'.url('Ingredient-Edit/'.$id).'" class="edit btn btn-success btn-sm"><i class="fas fa-edit"></i> Edit</a> <a href="'.url('Ingredient-Delete/'.$id).'" class="delete remove btn btn-danger btn-sm"><i class="far fa-trash-alt"></i> Delete</a>';
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
        return view('admin.ingredients.create');
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
            "ingredient_name"=>"required",
         
            ]);
        $data=new Ingredient;
        $data->ingredient_name=$request->ingredient_name;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        return redirect()->route("ingredients")->with("success","Ingredients Successfully Added");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function show(Ingredient $ingredient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Ingredient $ingredient)
    {
         $id=CustomHelpers::custom_decrypt($id);
         $data=Ingredient::find($id);
          return view('admin.ingredients.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function update($id,Request $request, Ingredient $ingredient)
    {
       $id=CustomHelpers::custom_decrypt($id);
         $data=Ingredient::find($id);
         $data->ingredient_name=$request->ingredient_name;
        $data->user_id=Sentinel::getUser()->id;
        $data->system_ip=CustomHelpers::get_ip();
        $data->save();
        return redirect()->route("ingredients")->with("success","Ingredients Successfully Updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ingredient  $ingredient
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Ingredient $ingredient)
    {
        $id=CustomHelpers::custom_decrypt($id);
        $data=Ingredient::find($id);
        if($data):
       
         Ingredient::destroy($id);
         return redirect()->route('ingredients')->with('success',"Ingredients Successfully Deleted");
        else:
          return redirect()->route('ingredients')->with('success',"Data Not Found");
        endif;
    }
}

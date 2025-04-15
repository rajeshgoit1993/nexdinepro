<?php

namespace App\Http\Controllers;

use App\Models\FranchiseExpense;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Helpers\POS_SettingHelpers;
use DataTables;
use Sentinel;
use Validator;
use DB;
use Session;
class FranchiseExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $data=User::whereIn('registration_level',[2,1])
            ->where('active_status','=',1)->get();
       return view("admin.outlet_exp.index",compact("data"));
    }
    public function get_franchise_exp(Request $request)
    {
        
        $outlet_id= $request->outlet;
        $start_date= $request->start_date;
        $end_date= $request->end_date;   
        Session::put('start_date', $start_date);
        Session::put('end_date', $end_date);
        if($outlet_id==0):
            $data=DB::table('franchise_expenses')->whereBetween('exp_date', [$start_date, $end_date])->get()->groupBy('outlet_id');
        else:
            $data=DB::table('franchise_expenses')->where("outlet_id", $outlet_id)->whereBetween('exp_date', [$start_date, $end_date])->get()->groupBy('outlet_id');
        endif;


           

           

            return Datatables::of($data)
                ->addIndexColumn()
                  
->addColumn('outlet_details', function($row){
                   $outlet_id=$row[0]->outlet_id;
$rows_data=User::find($outlet_id);
$outlet_details="<b>ID:</b> $rows_data->email
                 <hr style='padding:0px;margin:0px'>
                 <b>Name:</b> $rows_data->name
                 <hr style='padding:0px;margin:0px'>
                 <b>Mobile:</b> $rows_data->mobile
                 <hr style='padding:0px;margin:0px'>
                <b>State:</b> $rows_data->state
                             <hr style='padding:0px;margin:0px'>
                             <b>City:</b> $rows_data->city";

                return $outlet_details;
                })
                ->addColumn('exp_details', function($row){
                    
                    $output='<table class="table table-bordered">
 <thead>
    <tr>
      <th>Date</th>
      <th>
       Exp Details  
      </th>
      
   
    </tr>
  </thead>
    <tbody>';
     $j=0;
       $start_date=Session::get('start_date');  
       $end_date=Session::get('end_date');           
$exps=DB::table('franchise_expenses')->where([['outlet_id','=',(int)$row[0]->outlet_id]])->whereBetween('exp_date', [$start_date, $end_date])->get()->groupBy('exp_date');
   foreach($exps as $exp):
    $date=$exp[0]->exp_date;
     
      $output.='<tr style="">
        <td style="padding:2px;text-align:center">'.$date.'</td>';
       
      $output.='<td><table class="table">
       ';
       $exp_datas=DB::table('franchise_expenses')->where([['outlet_id','=',(int)$row[0]->outlet_id]])->whereDate('exp_date',$date)->get();
       foreach($exp_datas as $exp_data):
         $j=(int)$j+(int)$exp_data->exp;
        $actionBtn= '<div class="button_flex"><a href="#"  id="'.$exp_data->id.'" class="edit btn btn-success btn-sm button_left"><i class="fas fa-edit"></i> Edit</a> <a href="#"  id="'.$exp_data->id.'" class="delete remove btn btn-danger btn-sm button_left"><i class="far fa-trash-alt"></i> Delete</a><div>';

       $output.='<tr><td style="width:25%;padding:2px 10px">'.$exp_data->exp_type.'</td>
       <td style="width:30%;padding:2px 10px">'.$exp_data->exp_desc.'</td>
       <td style="width:15%;padding:2px 10px">'.POS_SettingHelpers::getAmt($exp_data->exp).'</td>

       <td style="width:30%;padding:2px 10px">'.$actionBtn.'</td>
          </tr>';
      endforeach;
       $output.='
     
       </table>';
        
      
      $output.=' </td></tr>';
      
       endforeach;

        
                $output.=' <tr>

      <td></td>
      <td style="text-align:center">Total '.POS_SettingHelpers::getAmt($j).'</td>
     
      </tr></tbody>
  </table>

        ';
                return $output;
                })
             
                
                ->rawColumns(['exp_details','outlet_details'])
                ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data=User::whereIn('registration_level',[2,1])
            ->where('active_status','=',1)->get();
        $options = view("admin.outlet_exp.create",compact('data'))->render();
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
       $exp=$request->exp;
        foreach($exp as $row=>$col)
        {
           
                $data=new FranchiseExpense;
                $data->outlet_id=$request->outlet_id;
                $data->exp_desc=$request->exp_desc;
                $data->exp_date=$col['exp_date'];
                $data->exp=$col['exp'];
                $data->exp_type=$col['exp_type'];
                $data->save();
                
            
        }
        echo 'success';
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FranchiseExpense  $franchiseExpense
     * @return \Illuminate\Http\Response
     */
    public function show(FranchiseExpense $franchiseExpense)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FranchiseExpense  $franchiseExpense
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
       $id=$request->id;
         $exp_data=FranchiseExpense::find($id);
         $data=User::whereIn('registration_level',[2,1])
            ->where('active_status','=',1)->get();
    

         $options = view("admin.outlet_exp.edit",compact('data','exp_data'))->render();
         echo $options;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FranchiseExpense  $franchiseExpense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FranchiseExpense $franchiseExpense)
    {
        $id=$request->id;
        $data=FranchiseExpense::find($id);
        $data->outlet_id=$request->outlet_id;
        $data->exp_desc=$request->exp_desc;
        $data->exp_date=$request->exp_date;
        $data->exp=$request->exp;
        $data->exp_type=$request->exp_type;
        $data->save();

        echo 'success';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FranchiseExpense  $franchiseExpense
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
       $id=$request->id;
          FranchiseExpense::destroy($id);
         echo 'success';  
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Sentinel;
use DB;
use App\Helpers\CustomHelpers;
use App\Helpers\POS_SettingHelpers;
use App\Models\User;


class HourlyReport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }
    public function __construct($region,$date,$start_time,$end_time,$outlet_id,$city)
    {
        $this->region = $region;
        $this->date = $date;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->outlet_id = $outlet_id;
        $this->city = $city;
    }
    public function view(): View
    {
      $region=$this->region;
      $date=$this->date;
      $start_time=$this->start_time;
      $end_time=$this->end_time;
      $outlet_id=$this->outlet_id;
      $city=$this->city;
      
          if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
          
      if($region==0 && $city==0 && $outlet_id==0): 
        $ids=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 
       
       $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

      
return view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time')); 

  
         
        elseif($region!=0 && $city==0 && $outlet_id==0):
           
         $region_ids=POS_SettingHelpers::get_region_ids($region);  
         $ids=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$region_ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$region_ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$region_ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$region_ids;   

        return view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'));


    

        
           
        elseif($region==0 && $city!=0 && $outlet_id==0):

             $ids=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1],['dist','=',$city]])->get()->pluck('id'); 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        return view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'));


     


        elseif($region==0 && $city==0 && $outlet_id!=0):

            $ids=[$outlet_id]; 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        return view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'));


   

        
        elseif($region!=0 && $city!=0 && $outlet_id==0):

            $region_ids=POS_SettingHelpers::get_region_ids($region);  
             $ids=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1],['dist','=',$city]])->whereIn('id',$region_ids)->get()->pluck('id'); 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        return view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'));


     

            
           
         
        

        elseif($region!=0 && $city==0 && $outlet_id!=0):

            
             $ids=[$outlet_id]; 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        return view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'));




        elseif($region==0 && $city!=0 && $outlet_id!=0):

             $ids=[$outlet_id]; 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        return view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'));


      

           
        elseif($region!=0 && $city!=0 && $outlet_id!=0):

             $ids=[$outlet_id]; 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        return view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'));


      

        endif;



          

          
     else:
             $ids=[$outlet_id]; 

         $data_dine_in = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',1]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 
         
         

         $data_takeaway = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',2]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         
         
         $data_delivery = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3],['franchise_sales.order_type',3]]) 
                 ->whereDate('franchise_sales.sale_date',$date)
                 ->whereBetween('franchise_sales.order_time',[$start_time,$end_time])
                 ->whereIn('outlet_id',$ids)
                 ->select(DB::raw('count(*) as count, HOUR(order_time) as hour'))
                 ->groupBy('hour')
                 ->get(); 

         

        $ids_second=$ids;   

        return view("report.pos.hourly_content",compact('data_dine_in','date','data_takeaway','data_delivery','ids_second','start_time','end_time'));
   
     endif;
       
    }

      
}

<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Sentinel;
use DB;
use App\Helpers\CustomHelpers;
use App\Helpers\POS_SettingHelpers;
use App\Models\User;


class OutletCustomers implements FromView, WithEvents, ShouldAutoSize
{
    
    
    public function __construct($region,$from,$to,$outlet_id,$city)
    {
        $this->from = $from;
        $this->to = $to;
        $this->outlet_id = $outlet_id;
        $this->city = $city;
        $this->region = $region;
       
    }

    public function view(): View
    {
      $from=$this->from;
      $to=$this->to;
      $outlet_id=$this->outlet_id;
      $city=$this->city;
      $region=$this->region;

     if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
          
        if($region==0 && $city==0 && $outlet_id==0): 
        $ids_second=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 
            $data = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('sale_date', [$from, $to])
                 ->orderBy('sale_date','ASC')->get()->groupBy('sale_date');
         
      return view('report.pos.combine.customer',compact('data','outlet_id','from','to','ids_second')); 
        elseif($region!=0 && $city==0 && $outlet_id==0):
            $region_ids=POS_SettingHelpers::get_region_ids($region);  
        $ids_second=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 
            $data = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                  ->whereIn('outlet_id',$region_ids)
                 ->whereBetween('sale_date', [$from, $to])
                 ->orderBy('sale_date','ASC')->get()->groupBy('sale_date');
         $ids_second=$region_ids;
      return view('report.pos.combine.customer',compact('data','outlet_id','from','to','ids_second'));
        elseif($region==0 && $city!=0 && $outlet_id==0):
         $region_ids=POS_SettingHelpers::get_region_ids($region);  
            $ids_second=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1],['dist','=',$city]])->get()->pluck('id'); 
            $data = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                   ->whereIn('outlet_id',$ids_second)
                 ->whereBetween('sale_date', [$from, $to])
                 ->orderBy('sale_date','ASC')->get()->groupBy('sale_date');
         
      return view('report.pos.combine.customer',compact('data','outlet_id','from','to','ids_second'));
        elseif($region==0 && $city==0 && $outlet_id!=0):
            $data = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('sale_date', [$from, $to])
                 ->get()->groupBy('sale_date');
             $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
      return view('report.pos.individual.customer',compact('data','outlet_details','outlet_id','from','to'));
        elseif($region!=0 && $city!=0 && $outlet_id==0):
         $region_ids=POS_SettingHelpers::get_region_ids($region);  
            $ids_second=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1],['dist','=',$city]])->whereIn('id',$region_ids)->get()->pluck('id'); 
            $data = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                  ->whereIn('outlet_id',$ids_second)
                 ->whereBetween('sale_date', [$from, $to])
                 ->orderBy('sale_date','ASC')->get()->groupBy('sale_date');
         
      return view('report.pos.combine.customer',compact('data','outlet_id','from','to','ids_second'));
        elseif($region!=0 && $city==0 && $outlet_id!=0):
            $data = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('sale_date', [$from, $to])
                 ->get()->groupBy('sale_date');
             $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
      return view('report.pos.individual.customer',compact('data','outlet_details','outlet_id','from','to'));
        elseif($region==0 && $city!=0 && $outlet_id!=0):
            $data = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('sale_date', [$from, $to])
                 ->get()->groupBy('sale_date');
             $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
      return view('report.pos.individual.customer',compact('data','outlet_details','outlet_id','from','to'));
        elseif($region!=0 && $city!=0 && $outlet_id!=0):
            $data = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('sale_date', [$from, $to])
                 ->get()->groupBy('sale_date');
             $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
      return view('report.pos.individual.customer',compact('data','outlet_details','outlet_id','from','to'));
        endif;



          

          
     else:
          $data = DB::table('franchise_sales')
                ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                ->whereBetween('sale_date', [$from, $to])
                ->get()->groupBy('sale_date');
         $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
      return view('report.pos.individual.customer',compact('data','outlet_details','outlet_id','from','to'));
   
     endif;
     

    }

   

    public function registerEvents(): array
    {
      $from=$this->from;
      $to=$this->to;
      $outlet_id=$this->outlet_id;
      $city=$this->city;
      if(Sentinel::getUser()->inRole('superadmin') || CustomHelpers::get_page_access_data(Sentinel::getUser()->id,'billing')==1):
           if($city==0 && $outlet_id==0):
             return [
       
        AfterSheet::class=>function(AfterSheet $event){
           

            $event->sheet->getStyle('A:D')->applyFromArray([
                'color' => ['argb' => 'FFFF0000'],
            ]);

          
$event->sheet->getDelegate()->freezePane('A4'); 
           
            
            
        }
       ];
           elseif($city==0 && $outlet_id!=0):
             return [
       
        AfterSheet::class=>function(AfterSheet $event){
            $event->sheet->getStyle('A7:I7')->applyFromArray([
                'font'=>[
                    'bold'=>true,
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        // 'color' => ['argb' => 'FFFF0000'],
                    ],
                ]
            ]);

            $event->sheet->getStyle('A8:I8')->applyFromArray([
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ]
                ]
            );


            $event->sheet->getStyle('A:D')->applyFromArray([
                'color' => ['argb' => 'FFFF0000'],
            ]);

          
$event->sheet->getDelegate()->freezePane('A9'); 
           
            
            
        }
       ];
           elseif($city!=0 && $outlet_id==0):
           return [
       
        AfterSheet::class=>function(AfterSheet $event){
           

            $event->sheet->getStyle('A:D')->applyFromArray([
                'color' => ['argb' => 'FFFF0000'],
            ]);

          

           $event->sheet->getDelegate()->freezePane('A4'); 
            
            
        }
       ];
            elseif($city!=0 && $outlet_id!=0):
                 return [
       
        AfterSheet::class=>function(AfterSheet $event){
            $event->sheet->getStyle('A7:I7')->applyFromArray([
                'font'=>[
                    'bold'=>true,
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        // 'color' => ['argb' => 'FFFF0000'],
                    ],
                ]
            ]);

            $event->sheet->getStyle('A8:I8')->applyFromArray([
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ]
                ]
            );


            $event->sheet->getStyle('A:D')->applyFromArray([
                'color' => ['argb' => 'FFFF0000'],
            ]);

          
       $event->sheet->getDelegate()->freezePane('A9');
           
            
            
        }
       ];
            endif;
        else:

 return [
       
        AfterSheet::class=>function(AfterSheet $event){
            $event->sheet->getStyle('A7:I7')->applyFromArray([
                'font'=>[
                    'bold'=>true,
                ],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        // 'color' => ['argb' => 'FFFF0000'],
                    ],
                ]
            ]);

            $event->sheet->getStyle('A8:I8')->applyFromArray([
                    'borders' => [
                        'bottom' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ]
                ]
            );


            $event->sheet->getStyle('A:D')->applyFromArray([
                'color' => ['argb' => 'FFFF0000'],
            ]);

          
$event->sheet->getDelegate()->freezePane('A9');
           
            
            
        }
       ];
        endif;
      
       
    }

}

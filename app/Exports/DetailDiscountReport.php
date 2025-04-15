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

class DetailDiscountReport implements FromView,WithEvents, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     //
    // }
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
                 ->orderBy('sale_date','ASC')->get()->groupBy('outlet_id');
         
      return view('report.pos.combine.detail_discount',compact('data','outlet_id','from','to','ids_second'));

        elseif($region!=0 && $city==0 && $outlet_id==0):

            $ids_second=POS_SettingHelpers::get_region_ids($region);  
            $data = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                  ->whereIn('outlet_id',$ids_second)
                 ->whereBetween('sale_date', [$from, $to])
                 ->get()->groupBy('outlet_id');
             
      return view('report.pos.combine.detail_discount',compact('data','outlet_id','from','to','ids_second'));

        elseif($region==0 && $city!=0 && $outlet_id==0):

            $ids_second=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1],['dist','=',$city]])->get()->pluck('id');
            $data = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                  ->whereIn('outlet_id',$ids_second)
                 ->whereBetween('sale_date', [$from, $to])
                 ->get()->groupBy('outlet_id');
             
      return view('report.pos.combine.detail_discount',compact('data','outlet_id','from','to','ids_second'));

        elseif($region==0 && $city==0 && $outlet_id!=0):
            $ids_second=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 
            $data = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('sale_date', [$from, $to])
                 ->get()->groupBy('outlet_id');
             $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
      return view('report.pos.combine.detail_discount',compact('data','outlet_details','outlet_id','from','to','ids_second'));
        elseif($region!=0 && $city!=0 && $outlet_id==0):

           $region_ids=POS_SettingHelpers::get_region_ids($region);  
            $ids_second=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1],['dist','=',$city]])->whereIn('id',$region_ids)->get()->pluck('id'); 
            $data = DB::table('franchise_sales')
                  ->where([['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                  ->whereIn('outlet_id',$ids_second)
                 ->whereBetween('sale_date', [$from, $to])
                 ->get()->groupBy('outlet_id');
             
      return view('report.pos.combine.detail_discount',compact('data','outlet_id','from','to','ids_second'));

        elseif($region!=0 && $city==0 && $outlet_id!=0):
            $ids_second=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 
            $data = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('sale_date', [$from, $to])
                 ->get()->groupBy('outlet_id');
             $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
      return view('report.pos.combine.detail_discount',compact('data','outlet_details','outlet_id','from','to','ids_second'));
        elseif($region==0 && $city!=0 && $outlet_id!=0):
            $ids_second=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 
            $data = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('sale_date', [$from, $to])
                 ->get()->groupBy('outlet_id');
             $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
      return view('report.pos.combine.detail_discount',compact('data','outlet_details','outlet_id','from','to','ids_second'));
        elseif($region!=0 && $city!=0 && $outlet_id!=0):
            $ids_second=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 
            $data = DB::table('franchise_sales')
                  ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                 ->whereBetween('sale_date', [$from, $to])
                 ->get()->groupBy('outlet_id');
             $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
      return view('report.pos.combine.detail_discount',compact('data','outlet_details','outlet_id','from','to','ids_second'));
        endif;

          
     else:
        $ids_second=User::whereIn('registration_level',[2,1])
            ->where([['status','=',7],['active_status','=',1]])->get()->pluck('id'); 
          $data = DB::table('franchise_sales')
                ->where([['outlet_id',$outlet_id],['del_status', 'Live'],['franchise_sales.order_status',3]]) 
                ->whereBetween('sale_date', [$from, $to])
                ->get()->groupBy('outlet_id');
         $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
      return view('report.pos.combine.detail_discount',compact('data','outlet_details','outlet_id','from','to','ids_second'));
   
     endif;
    }

         public function registerEvents(): array
    {
        return [
            AfterSheet::class=>function(AfterSheet $event){
                $event->sheet->getStyle('A:AA')->applyFromArray([
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['rgb' => 'FFFFFF']
                        ],
                       
                    ]
                );

                $event->sheet->getStyle('A4:R4')->applyFromArray([
                    
                    'alignment' => [
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            ],
                    'borders' => [
                            'top' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                            'bottom' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ],
                        ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => ['rgb' => 'CCCCFF']
                    ],

                    ]
                );
                
                // merge cells
                $event->sheet->mergeCells('A1:Q1');
                $event->sheet->mergeCells('A2:Q2');
                $event->sheet->mergeCells('A3:Q3');  

                // freeze cell
                $event->sheet->getDelegate()->freezePane('A5'); 

            }
           
        ];
       
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2    => ['font' => ['bold' => true]],
            4    => ['font' => ['bold' => true]],
        ];
    }
}


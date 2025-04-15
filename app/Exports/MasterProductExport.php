<?php

namespace App\Exports;
use App\Models\MasterProduct;
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


class MasterProductExport implements FromView, WithEvents, ShouldAutoSize
{
    
    
    public function __construct($a)
    {
        $this->a = $a;
         
    }

    public function view(): View
    {
         $a=$this->a;
     $data=MasterProduct::where('outlet_id',$a)->get();
      return view('report.product.master_product',compact('data'));

    }

   

    public function registerEvents(): array
    {
       return [
       
        AfterSheet::class=>function(AfterSheet $event){
            $event->sheet->getStyle('A1:L1')->applyFromArray([
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

         

            $event->sheet->getStyle('A:D')->applyFromArray([
                'color' => ['argb' => 'FFFF0000'],
            ]);

          

           
            
            
        }
       ];
       
    }

}



<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\MasterProduct;
use Illuminate\Contracts\View\View;
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
use App\Models\AssignFoodMenuIngredient;
use App\Models\FranchiseStockSalePrice;

class FranchiseStockExport implements FromView, WithEvents, ShouldAutoSize
{
    
    
    public function __construct($outlet_id,$date,$type)
    {
        $this->outlet_id = $outlet_id;
        $this->date = $date;
        $this->type = $type;   
    }

    public function view(): View
    {
    $outlet_id=$this->outlet_id;
    $date=$this->date;
    $type=$this->type;
    $data=FranchiseStockSalePrice::where('outlet_id','=',(int)$outlet_id)->get();
    return view('report.franchise_stock.franchise_stock',compact('data','outlet_id','date','type'));

    }
       public function registerEvents(): array
    {
       return [
       
        AfterSheet::class=>function(AfterSheet $event){
            $event->sheet->getStyle('A1:H1')->applyFromArray([
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

         

            $event->sheet->getStyle('A:H')->applyFromArray([
                'color' => ['argb' => 'FFFF0000'],
            ]);

          
    $event->sheet->getDelegate()->freezePane('A2'); 
           
            
            
        }
       ];
       
    }

   


}

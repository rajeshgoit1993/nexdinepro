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
use App\Models\FranchiseStockSalePrice;
use App\Helpers\CustomHelpers;
use Illuminate\Http\Request;
use App\Models\FranchiseStockStatus;
use App\Models\FanchiseRegistration;
use App\Models\ItemImages;
use App\Models\Unit;
use App\Exports\FranchiseStockExport;
use App\Imports\FranchiseStockImport;
use App\Imports\FranchiseAdminStockImport;
use App\Models\PhysicalEntry;
use App\Models\RegionWiseOutlet;
use App\Models\RegionSetting;
use App\Helpers\POS_SettingHelpers;
use App\Models\User;
use Sentinel;
use DB;
use DataTables;
use Validator;
use Excel;
use PDF; 



class InventoryValuation implements FromView, WithEvents, ShouldAutoSize, WithStyles
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

       $data = FranchiseStockSalePrice::where('outlet_id','=',(int)$outlet_id)->latest()->get();
         $outlet_details=POS_SettingHelpers::get_outlet_details((int)$outlet_id);
      return view('report.pos.combine.inventory_valuation',compact('data','outlet_details','outlet_id','from','to'));


    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A:AW')->applyFromArray(
                    [
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'color' => ['rgb' => 'FFFFFF']
                        ],

                    ]
                );

                $event->sheet->getStyle('A9:AW9')->applyFromArray([

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

                ]);

                // $event->sheet->getStyle('A7:AW7')->applyFromArray([
                //     'borders' => [
                        
                //         'bottom' => [
                //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                //         ],
                //     ],
                // ]);


                // set row heigt

                // $event->sheet->getDelegate()->getRowDimension('2')->setRowHeight(40);
                // $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(150);

                // merge cell 

                $event->sheet->mergeCells('A2:F2');
                $event->sheet->mergeCells('A3:F3');
                $event->sheet->mergeCells('A6:M6');
                $event->sheet->mergeCells('A7:M7');

                // freez cell
                $event->sheet->getDelegate()->freezePane('A11');
            }

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2    => ['font' => ['bold' => true,]],
            3    => ['font' => ['bold' => true]],
            6    => ['font' => ['bold' => true]],
            7    => ['font' => ['bold' => true]],
            9   => ['font' => ['bold' => true, 'size' => 12]],
            10   => ['font' => ['bold' => true, 'size' => 12,'color' => ['rgb' => 'FF0000']]],
        ];
    }
}


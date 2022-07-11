<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class PriceList extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'provider', 'validity_period', 'currency'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['updated_at', 'deleted_at'];

    /**
     * Dates fields
     * @var string[]
     */
    protected $dates = ['validity_period', 'created_at'];

    /**
     * Get items for this price list
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items()
    {
        return $this->hasMany(PriceListItem::class);//->bySystemTime($date);
    }

    /**
     * Filter actual version data at time
     * @param Request $request
     * @return mixed
     */
    public static function getAtTime(Request $request)
    {
        $date = self::getNeedDate($request);

        // Получаем актуальные данные на выбранное время, подробнее в AppServiceProvider
        $query = self::bySystemTime($date);

        // Отсекаем просроченные прайслисты
        if(!$request->get('delay')) {
            $query = $query->where('validity_period', '>=', date('Y-m-d', strtotime($date)));
        }

        return $query;
    }

    /**
     * Get request actuality date or now
     * @param Request $request
     * @return string
     */
    public static function getNeedDate(Request $request)
    {
        return date('Y-m-d H:i:s', strtotime($request->get('actuality_date', now())));
    }

    /**
     * Check validity_period to date
     * @param $date
     * @return bool
     */
    public function isActual($date)
    {
        return strtotime($this->validity_period->format('Y-m-d 23:59:59')) < strtotime($date);
    }

    /**
     * Download XLSX file
     * @param $date
     * @param $priceLists
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public static function downloadXLSX($date, $priceLists)
    {
        $styleHead = [
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $styleBody = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export.xlsx"');
        header('Cache-Control: max-age=0');

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheetNumber = 1;

        foreach ($priceLists as $priceList) {
            if($sheetNumber != 1) {
                $sheet =$spreadsheet->createSheet($sheetNumber);
                //$sheet = $spreadsheet->getActiveSheet($sheetNumber);
            }
            $sheet->setTitle($priceList->name);

            $sheet->setCellValue('A1', 'Название');
            $sheet->getColumnDimension('A')->setWidth(35);
            $sheet->setCellValue('B1', 'Поставщик');
            $sheet->getColumnDimension('B')->setWidth(35);
            $sheet->setCellValue('C1', 'Срок действия');
            $sheet->getColumnDimension('C')->setWidth(20);
            $sheet->setCellValue('D1', 'Валюта');
            $sheet->getColumnDimension('D')->setWidth(10);
            $sheet->setCellValue('E1', 'Данные актуальны на момент времени');
            $sheet->getColumnDimension('E')->setWidth(40);
            //
            $sheet->getRowDimension('1')->setRowHeight(30);

            $sheet->setCellValue('A2', $priceList->name);
            $sheet->setCellValue('B2', $priceList->provider);
            $sheet->setCellValue('C2', $priceList->validity_period->format('d.m.Y'));
            $sheet->setCellValue('D2', $priceList->currency);
            $sheet->setCellValue('E2', date('d.m.Y H:i:s', strtotime($date)));
            //
            $sheet->getRowDimension('2')->setRowHeight(20);

            $sheet->getStyle('A1:E1')->applyFromArray($styleHead);
            $sheet->getStyle('A2:E2')->applyFromArray($styleBody);

            //
            // Таблица с товарами
            //

            $sheet->setCellValue('A4', 'Название');
            $sheet->setCellValue('B4', 'Артикул');
            $sheet->setCellValue('C4', 'Цена');
            $sheet->getRowDimension('4')->setRowHeight(30);
            $sheet->getStyle('A4:C4')->applyFromArray($styleHead);

            $row = 5;
            foreach ($priceList->items as $priceListItem) {
                $sheet->setCellValue('A'.$row, $priceListItem->name);
                $sheet->setCellValue('B'.$row, $priceListItem->article_number);
                $sheet->setCellValue('C'.$row, $priceListItem->price);
                $sheet->getRowDimension($row)->setRowHeight(20);
                $sheet->getStyle('A'.$row.':C'.$row)->applyFromArray($styleBody);
                $row++;
            }
            $sheetNumber++;
        }


        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}

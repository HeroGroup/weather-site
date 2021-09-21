<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DailyReportExport implements FromCollection, WithHeadings, WithColumnFormatting, ShouldAutoSize
{
    protected $device;
    protected $date;

    public function __construct($device, $date)
    {
        $this->device = $device;
        $this->date = $date;
    }

    public function headings(): array
    {
        return [
            'ساعت',
            'دما',
            'کمینه دما',
            'بیشینه دما',
            'رطوبت',
            'کمینه رطوبت',
            'بیشینه رطوبی',
            'نقطه شبنم'
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER,
            'I' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function collection()
    {
        return DB::select("SELECT device_id, parameters_values, SUBSTR(date_time, 12, 5) AS SensorFeatureTime
        FROM sensor_feature_values_compact
        WHERE device_id = $this->device
        AND date_time LIKE '%$this->date%'");
    }
}

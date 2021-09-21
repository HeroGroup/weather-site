<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Station;
use App\Models\Plant;
use App\Models\Pest;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.report');
    }

    public function getStationsList()
    {
        return DB::table('devices')
            ->select(DB::raw('id, CONCAT(SerialNumber," - ",Title) as value'))
            ->pluck('value', 'id')
            ->toArray();
    }

    public function dailyReport()
    {
        $customList = $this->getStationsList();
        return view('reports.dailyReport', compact('customList'));
    }

    public function getDailyReport($device, $date)
    {
        try {
            $date = jalali_to_gregorian_string($date);
            $tbl = DB::select("SELECT device_id, parameters_values, SUBSTR(date_time, 12, 5) AS SensorFeatureTime
            FROM sensor_feature_values_compact
            WHERE device_id = $device
            AND date_time LIKE '%$date%'");

            return $this->success("success", $tbl);
            } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
            }
    }

    public function periodicReport()
    {
        $customList = DB::table('stations')
            ->join('cities', 'cities.id', '=', 'stations.city_id')
            ->select('stations.id as id', DB::raw('CONCAT(stations.device_code," - ",cities.name) as value'))
            ->pluck('value', 'id')
            ->toArray();

        $station = Station::pluck('device_code', 'id')->toArray();
        $cities = City::pluck('name', 'id')->toArray();

        return view('reports.periodicReport', compact('station', 'cities', 'customList'));

    }

    public function hourlyReport()
    {
        $customList = $this->getStationsList();
        return view('reports.hourlyReport', compact('customList'));
    }

    public function getHourlyReport($device, $from, $to)
    {
        try {
            $fromDate = jalali_to_gregorian_string($from);
            $toDate = jalali_to_gregorian_string($to);

            $tbl = DB::select("SELECT parameters_values, SUBSTR(date_time,1,10) AS SensorFeatureDate, SUBSTR(date_time,12,5) AS SensorFeatureTime
            FROM sensor_feature_values_compact
            WHERE device_id = $device
            AND date_time BETWEEN '$fromDate' AND '$toDate'");

            return $this->success("success", $tbl);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

    public function yearReport()
    {
        $customList = DB::table('stations')->join('cities', 'cities.id', '=', 'stations.city_id')->select('stations.id as id',
            DB::raw('CONCAT(stations.device_code," - ",cities.name) as value'))->pluck('value', 'id')
            ->toArray();

        $station = Station::pluck('device_code', 'id')->toArray();
        $cities = City::pluck('name', 'id')->toArray();
        return view('reports.yearReport', compact('station', 'cities', 'customList'));

    }

    public function DoDreportPlant()
    {
        $customList = DB::table('stations')
            ->join('cities', 'cities.id', '=', 'stations.city_id')
            ->select('stations.id as id', DB::raw('CONCAT(stations.device_code," - ",cities.name) as value'))
            ->pluck('value', 'id')
            ->toArray();

        $plants = Plant::pluck('name', 'id')->toArray();
        return view('reports.DoDreportPlant', compact('plants', 'customList'));

    }

    public function DoDreportPest()
    {
        $customList = DB::table('stations')
            ->join('cities', 'cities.id', '=', 'stations.city_id')
            ->select('stations.id as id', DB::raw('CONCAT(stations.device_code," - ",cities.name) as value'))
            ->pluck('value', 'id')
            ->toArray();

        $pests = Pest::pluck('name', 'id')->toArray();
        return view('reports.DoDreportPest', compact('pests', 'customList'));

    }

    public function LengthGrowingSeason()
    {
        $customList = DB::table('stations')->join('cities', 'cities.id', '=', 'stations.city_id')->select('stations.id as id',
            DB::raw('CONCAT(stations.device_code," - ",cities.name) as value'))->pluck('value', 'id')
            ->toArray();

        $station = Station::pluck('device_code', 'id')->toArray();
        $cities = City::pluck('name', 'id')->toArray();
        return view('reports.LengthGrowingSeason', compact('station', 'cities', 'customList'));

    }
}

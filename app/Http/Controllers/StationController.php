<?php

namespace App\Http\Controllers;

use App\Models\Station;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StationController extends Controller
{
    public function index()
    {
        $stations = Station::all();
        $cities = City::pluck('name', 'id')->toArray();
        return view('stations.index', compact('stations','cities'));
    }
    public function rules()
    {
        return [
            'device_title' => 'required',
            'serial_number' => 'required',
            // 'howBooked'=>'required',
            // 'ticket'=>['required|exists:ticket_audits,ticketnumber' , new TicketNumberIsNotUsed()] ,
            // 'pay_method'=>'required',
            // 'customer_id'=>'required:exists:customers,id'

        ];
    }

    public function store(Request $request)
    {

        // $validatedData = $request->validate([
        // ],
        // [
        //     ]
        // );

        $rules = [
            'name' => 'unique|max:50',
            //'serial_number' => 'required|unique:serial_number|max:50'

              ];

              $customMessages = [

                'name' => ' نام فیلد تکراری است.'
          ];
          $this->validate($request, $rules, $customMessages);


        Station::create($request->all());
        return redirect(route('stations.index'))->with('message', 'ایستگاه با موفقیت ایجاد شد.')->with('type', 'success');
    }

    public function show(Station $station)
    {
        return view('stations.show', compact('station'));
    }

    public function chart($station,$param)
    {
        
         $Result=DB::select("SELECT device_code
         FROM stations
         WHERE id = $station");

        //   dd($Result[0]->device_code);
        
        return view('/charts/chart', compact('station','param','Result'));
    }

    public function getChartData($station)
    {
        try {
            $result = DB::select("SELECT parameters_values, date_time
            FROM sensor_feature_values_compact
            WHERE device_id = $station 
            AND date_time > DATE_SUB(CURDATE(), INTERVAL 1 DAY)
            ORDER BY id DESC
            -- LIMIT 32
            ");

            return $this->success("success", $result);
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }

     public function getChartReport($device, $date)

     {
          try {
        //   $date = jalali_to_gregorian_string($date);
        $tbl = DB::select("SELECT device_id, parameters_values, SUBSTR(date_time, 12, 5) AS SensorFeatureTime
        FROM sensor_feature_values_compact
        WHERE device_id = $device
        AND date_time > DATE_SUB(CURDATE(), INTERVAL 1 DAY)
          ");
          //    AND $date > DATE_SUB(CURDATE(), INTERVAL 1 DAY)

          return $this->success("success", $tbl);
          } catch (\Exception $exception) {
          return $this->fail($exception->getMessage());
          }
     }
    
    
    public function update(Request $request, Station $station)
    {
        $station->update($request->all());
        return redirect(route('stations.index'))->with('message', 'اطلاعات ایستگاه با موفقیت بروزرسانی شد.')->with('type', 'success');
    }

    public function destroy(Station $station)
    {
        try {
            $station->delete();
            return redirect(route('stations.index'))->with('message', 'حذف ایستگاه با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect(route('stations.index'))->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function showOnMap(Station $station)
    {
        //
    }

    public function temperatureDetails(Station $station)
    {
        DB::table('sensor_feature_values_compact')->where('device_id',$station->id)->get(['parameter_values']);
    }
}

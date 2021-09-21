<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function storeDeviceSensorData(Request $request)
    {
        try {
            $settings = DB::table('settings')->first();
            $minutes = $settings->save_in_minutes;

            $device = DB::table('stations')->where('device_code', 'LIKE', $request->deviceId)->first();
            $lastUpdate = DB::select("SELECT MAX(date_time) as mdt FROM sensor_feature_values_compact WHERE device_id=$device->id");
            $now = \Carbon\Carbon::now();

            if ($lastUpdate && $lastUpdate[0]->mdt > 0) {
                $totalDuration = strtotime($now) - strtotime($lastUpdate[0]->mdt);
                if(($totalDuration > $minutes*60) && ($now->minute % $minutes == 0)) {
                    DB::table('sensor_feature_values_compact')->insert([
                        'device_id' => $device->id,
                        'parameters_values' => json_encode($request->body),
                        'date_time' => $now
                    ]);

                    DB::table('stations')->where('id',$device->id)->update(['last_online' => $now]);

                    return $this->success("data stored successfully", $totalDuration);
                } else {
                    return $this->success("data posted successfully", $totalDuration);
                }
            } else {
                DB::table('sensor_feature_values_compact')->insert([
                    'device_id' => $device->id,
                    'parameters_values' => $request->body,
                    'date_time' => $now
                ]);

                DB::table('stations')->where('id',$device->id)->update(['last_online' => $now]);

                return $this->success("data stored successfully");
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getLine().':'.$exception->getMessage());
        }
    }

    public function getLatestDeviceSensorData($deviceId)
    {
        try {
            $device = DB::table('devices')->where('DeviceID', 'LIKE', $deviceId)->first();
            if ($device) {
                $lastUpdate = DB::select("SELECT MAX(id) as mid FROM sensor_feature_values_compact WHERE device_id=$device->id");
                $mid = $lastUpdate[0]->mid;
                if($mid) {
                    $lastRecord = DB::select("SELECT parameters_values,date_time FROM sensor_feature_values_compact WHERE id=$mid");
                    return $this->success("data retrieved successfully", ['parameters' => $lastRecord[0]->parameters_values , 'time' => $lastRecord[0]->date_time]);
                } else {
                    return $this->fail("no history available");
                }
            } else {
                return $this->fail("invalid device");
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage());
        }
    }
}

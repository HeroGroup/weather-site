<?php

namespace App\Http\Controllers;

use App\Models\UserStation;
use Illuminate\Http\Request;
use App\Models\City;
use App\Models\Station;

class MonitoringController extends Controller
{
  public function index()
  {
      $userStations = UserStation::where('user_id',auth()->id())->select('station_id')->get();
      $stations = Station::whereIn('id', $userStations)->orderBy('device_code', 'asc')->get();

      $cities = City::pluck('name', 'id')->toArray();

    return view('monitorings.monitoring', compact('stations','cities'));
  }
}

<?php

namespace App\Http\Controllers;

use App\Models\DegreeDayPlant;
use App\Models\Plant;
use App\Models\Station;
use Illuminate\Http\Request;

class DegreeDayPlantController extends Controller
{
    public function index()
    {
        $stations = Station::pluck('device_title', 'id')->toArray();
        $plants = Plant::pluck('name', 'id')->toArray();
        $items = DegreeDayPlant::all();
        return view('degreeDay.plants.index', compact('items', 'stations', 'plants'));
    }

    public function store(Request $request)
    {
        try {
            DegreeDayPlant::create($request->all());
            return redirect(route('degreeDayPlants.index'))->with('message', 'ذخیره سازی با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect(route('degreeDayPlants.index'))->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function update(Request $request, DegreeDayPlant $degreeDayPlant)
    {
        try {
            $degreeDayPlant->update($request->all());
            return redirect(route('degreeDayPlants.index'))->with('message', 'بروزرسانی با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect(route('degreeDayPlants.index'))->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function destroy(DegreeDayPlant $degreeDayPlant)
    {
        try {
            $degreeDayPlant->delete();
            return redirect(route('degreeDayPlants.index'))->with('message', 'حذف با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect(route('degreeDayPlants.index'))->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }
}

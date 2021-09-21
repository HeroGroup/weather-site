<?php

namespace App\Http\Controllers;

use App\Models\DegreeDayPest;
use App\Models\Pest;
use App\Models\Station;
use Illuminate\Http\Request;

class DegreeDayPestController extends Controller
{
    public function index()
    {
        $stations = Station::pluck('device_title', 'id')->toArray();
        $pests = Pest::pluck('name', 'id')->toArray();
        $items = DegreeDayPest::all();
        return view('degreeDay.pests.index', compact('items', 'stations', 'pests'));
    }

    public function store(Request $request)
    {
        try {
            DegreeDayPest::create($request->all());
            return redirect(route('degreeDayPlants.index'))->with('message', 'ذخیره سازی با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect(route('degreeDayPlants.index'))->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function update(Request $request, DegreeDayPest $degreeDayPest)
    {
        try {
            $degreeDayPest->update($request->all());
            return redirect(route('degreeDayPlants.index'))->with('message', 'بروزرسانی با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect(route('degreeDayPlants.index'))->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }

    public function destroy(DegreeDayPest $degreeDayPest)
    {
        try {
            $degreeDayPest->delete();
            return redirect(route('degreeDayPlants.index'))->with('message', 'حذف با موفقیت انجام شد.')->with('type', 'success');
        } catch (\Exception $exception) {
            return redirect(route('degreeDayPlants.index'))->with('message', $exception->getMessage())->with('type', 'danger');
        }
    }
}

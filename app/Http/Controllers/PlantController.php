<?php

namespace App\Http\Controllers;

use App\Models\Plant;
use Illuminate\Http\Request;

class PlantController extends Controller
{
    public function index()
    {
        $plants = Plant::all();
        return view('plants.index', compact('plants'));
    }

    public function store(Request $request)
    {
        Plant::create($request->all());
        return redirect(route('plants.index'));
    }

    public function update(Request $request, Plant $plant)
    {
        $plant->update($request->all());
        return redirect(route('plants.index'));
    }

    public function destroy(Plant $plant)
    {
        $plant->delete();
        return redirect(route('plants.index'));
    }
}

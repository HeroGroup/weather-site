<?php

namespace App\Http\Controllers;

use App\Models\Illness;
use Illuminate\Http\Request;

class IllnessController extends Controller
{
    public function index()
    {
        $illnesses = Illness::all();
        return view('illnesses.index', compact('illnesses'));
    }

    public function store(Request $request)
    {
        Illness::create($request->all());
        return redirect(route('illnesses.index'))->with('message', 'ذخیره سازی با موفقیت انجام شد.')->with('type', 'success');
    }

    public function update(Request $request, Illness $illness)
    {
        $illness->update($request->all());
        return redirect(route('illnesses.index'))->with('message', 'بروزرسانی با موفقیت انجام شد.')->with('type', 'success');;
    }

    public function destroy(Illness $illness)
    {
        $illness->delete();
        return redirect(route('illnesses.index'))->with('message', 'حذف با موفقیت انجام شد.')->with('type', 'success');
    }
}

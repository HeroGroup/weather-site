<?php

namespace App\Http\Controllers;

use App\Models\Pest;
use Illuminate\Http\Request;

class PestController extends Controller
{
    public function index() // select * from pests;
    {
        $pests = Pest::all();
        return view('pests.index', compact('pests'));
    }

    public function store(Request $request) // insert into pests
    {
        $validator = $request->validate([
            'name' => 'required|unique:pests|max:50',
            'description' => 'max:150'
        ]);

        Pest::create($request->all());
        return redirect(route('pests.index'))->with('message', 'ذخیره سازی با موفقیت انجام شد')->with('type', 'success');
    }

    public function update(Request $request, Pest $pest) // update pests
    {
        $pest->update($request->all());
        return redirect(route('pests.index'))->with('message', 'بروزرسانی با موفقیت انجام شد')->with('type', 'success');
    }

    public function destroy(Pest $pest) // delete from pest
    {
        $pest->delete();
        return redirect(route('pests.index'))->with('message', ' حذف با موفقیت انجام شد')->with('type', 'success');
    }
}

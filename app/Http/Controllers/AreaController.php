<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\City;

class AreaController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        $cities = City::all();
        
        return view('areas.areaManagment', compact('provinces','cities'));
    }

    public function create()
    {
        return "create";
    }

    public function store(Request $request)
    {
        //  $customMessages = [
        // 'required' => 'The :attribute field is required.'
        // ];

        //  $validator = $request->validate([
        //  'name' => 'required|unique:provinces|max:50',
        //  'description' => 'max:150',
        //  $customMessages,
        //  ]);

        $rules = [
        'name' => 'required|unique:provinces|max:50'
        ];

        $customMessages = [
        'required' => 'نام استان تکراری می باشد.'
        ];

        $this->validate($request, $rules, $customMessages);

        Province::create([
            'name' => $request->name
        ]);
        $msg="استان جدید با موفقیت اضافه شد!";
        // $msg = "این استان قبلا در لیست بوده است!";
        return redirect('admin/areas')->with('message', $msg)->with('type', 'success');
    }
    public function storeCity(Request $request)
    {
       $rules = [
       'name' => 'required|unique:provinces|max:50'
       ];

       $customMessages = [
       'required' => 'این فیلد تکراری می باشد.'
       ];

       $this->validate($request, $rules, $customMessages);

      City::create([
          'province_id' => $request->province_id,
          'name' => $request->name
          ]);
          return redirect('admin/areas');
    }

    // public function edit($id)
    // {
    //    $citycase=City::findOrFail($id);
    //     return view('edit', compact('citycase'));
    // }

    public function update(Request $request, $id)
    {
        Province::find($id)->update(['name' => $request->name]);

          return redirect('admin/areas');
    }
    public function updateCity(Request $request, $id)
    {
    
        City::find($id)->update([
             'name' => $request->name
             ]);
                    return redirect('admin/areas');;
        
    }

    public function destroy($id)
    {
        /*$provincecase = Province::findOrFail($id);
        $provincecase->delete();
        */
        $msg="حذف با موفقیت انجام شد!";
        $msg = "به دلیل وابستگی، حذف امکان پذیر نمی باشد.";
        return redirect('admin/areas')->with('message', $msg)->with('type', 'danger');
    }

    public function destroyCity($id)
    {
        $city = City::findOrFail($id);
        $city->delete();
        
        $msg="حذف با موفقیت انجام شد!";
        return redirect('admin/areas')->with('message', $msg)->with('type', 'success');
    }
}

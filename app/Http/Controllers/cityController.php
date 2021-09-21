<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class cityController extends Controller
{
    public function index(){
        $citys=city::orderBy('id','DESC')->get();
        return view('citys',compact('','citys'));
    }
    public function create(){

    }
    public function store(){

    }
    public function show(){

    }
    public function edit(){

    }
    public function update(){

    }
    public function destroy(){

    }
}

@extends('layouts.admin', ['pageTitle' => 'مانیتورینگ', 'newButton' => false])
@section('content')
<!-- Button trigger modal -->

<div class="row" >
<div class="col-md-3">
<div class="card" style="margin:5px 5px;width: 22rem;border: 2px solid darkgrey;padding: 10px;background-image: linear-gradient(to right, rgba(200, 255, 0, 0.664) , rgba(0, 255, 98, 0.623));">
  <div class="card-body ">
      @foreach ($stations as $station)
        <h4 class="card-title" style="font-weight: bolder;">{{ $station->device_code }}22</h4>
        <td>{{ $station->city->name }}</td>
        <h5 class="card-title" style="font-weight: bolder;"> {{ $station->mobile_number }}</h5>
        <i class="wi wi-night-sleet"></i>
        <span style="font-weight: bolder;">دمای هوا:</span>
        <span style="font-weight: bolder;">20°c</span>
        <hr>
        @endforeach
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
     <i class="fa fa-cloud-sun" style="font-size: 50px"></i>
  </div>
</div>
</div>


</div>

 
@endsection

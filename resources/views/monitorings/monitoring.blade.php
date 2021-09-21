@extends('layouts.admin', ['pageTitle' => 'مانیتورینگ','icon'=>'fa-laptop', 'newButton' => false])
@section('content')
    <!-- Button trigger modal -->
    <style>
        .card {
            box-shadow: 10px 10px 5px grey;
            margin: 5px 5px;
            border: 2px solid darkgrey;
            padding: 25px 30px;
        }

        .card:hover {
            box-shadow:
                0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .actives {
            background-image: linear-gradient(to right, rgba(200, 255, 0, 0.664), rgba(0, 255, 98, 0.623));
        }

        .fiveActives {
            background-image: linear-gradient(to right, rgba(255, 230, 0, 0.664), rgba(255, 136, 0, 0.87));
        }

        .NoActives {
            display: none;
        }

        .inactive {
            background-image: linear-gradient(to right, rgba(123, 124, 118, 0.767), rgba(218, 233, 224, 0.658));
        }

    </style>

    <body>
        <div class="row" style="margin: auto;">
            <ul class="nav nav-tabs" id="ActiveTab" role="tablist">
                <li class="nav-item active">
                    <a class="nav-link" id="allStations-tab" style="border: 2px solid aliceblue;color:black"
                        data-toggle="tab" href="#allStations" role="tab" aria-controls="allStations"
                        aria-selected="false">همه</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="showActives-tab" style="border: 2px solid aliceblue;color:black"
                        data-toggle="tab" href="#showActives" role="tab" aria-controls="showActives"
                        aria-selected="false">فعال در سه روز اخیر</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="showFiveDActives-tab" style="border: 2px solid aliceblue;color:black"
                        data-toggle="tab" href="#showFiveDActives" role="tab" aria-controls="showFiveDActives"
                        aria-selected="false">فعال در پنج روز اخیر</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="showInactives-tab" style="border: 2px solid aliceblue;color:black"
                        data-toggle="tab" href="#showInactives" role="tab" aria-controls="showInactives"
                        aria-selected="false">غیرفعال</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent" style="margin-top: 15px">
                <div class="tab-pane active" id="allStations" style="background-color:transparent" role="tabpanel"
                    aria-labelledby="allStations-tab">
                    <form style="background-color:transparent">
                        <div class="row">
                            <?php $now = date('Y-m-d'); ?>
                            @foreach ($stations as $station)
                                <?php
                                $today = date_create($now);
                                $created = date_create(substr($station->last_online, 0, 10));
                                $diff = date_diff($today, $created);
                                ?>
                                <div class="col-md-3" style="display: block">
                                    <div class="card @if ($diff->format('%a') < 3 && ($station->last_online) != null) actives @else inactive @endif"
                                            onclick="window.location = '{{ route('stations.show', $station->id) }}';"
                                            style="cursor:pointer;">
                                            <div class="card-body">
                                                <h4 class="card-title" style="font-weight: bolder;">
                                                    {{ $station->device_code }}</h4>
                                                <td>{{ $station->city->name }}</td>
                                                <h5 class="card-title" style="font-weight: bolder;">
                                                    {{ $station->mobile_number }}
                                                </h5>
                                                <i class="wi wi-night-sleet"></i>
                                                <span style="font-weight: bolder;">دمای هوا:</span>
                                                <span style="font-weight: bolder;">35</span>
                                                <hr>
                                                <span style="font-weight: bolder;">بروزرسانی:</span>
                                                <span
                                                    style="font-weight: bolder;">{{ $station->last_online ? jdate('Y/m/j H:i', strtotime($station->last_online)) : '-' }}</span>
                                                <i class="fa fa-cloud-sun" style="font-size: 40px;float:left"></i>
                                            </div>
                                            <br>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="showActives" role="tabpanel" aria-labelledby="showActives-tab">
                    <form style="background-color:transparent">
                        <div class="row">
                            <?php $now = date('Y-m-d'); ?>
                            @foreach ($stations as $station)
                                <?php
                                $today = date_create($now);
                                $created = date_create(substr($station->last_online, 0, 10));
                                $diff = date_diff($today, $created);
                                ?>
                                <div class="col-md-3" style="display: block">
                                    <div class="card @if ($diff->format('%a') < 3 && ($station->last_online) != null) actives @else NoActives @endif"
                                     onclick="window.location = '{{ route('stations.show', $station->id) }}';"
                                     style="cursor:pointer;">
                                            <div class="card-body">
                                                <h4 class="card-title" style="font-weight: bolder;">
                                                    {{ $station->device_code }}</h4>
                                                <td>{{ $station->city->name }}</td>
                                                <h5 class="card-title" style="font-weight: bolder;">
                                                    {{ $station->mobile_number }}
                                                </h5>
                                                <i class="wi wi-night-sleet"></i>
                                                <span style="font-weight: bolder;">دمای هوا:</span>
                                                <span style="font-weight: bolder;">35</span>
                                                <hr>
                                                <span style="font-weight: bolder;">بروزرسانی:</span>
                                                <span
                                                    style="font-weight: bolder;">{{ $station->last_online ? jdate('Y/m/j H:i', strtotime($station->last_online)) : '-' }}</span>
                                                <i class="fa fa-cloud-sun" style="font-size: 40px;float:left"></i>
                                            </div>
                                            <br>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="showFiveDActives" role="tabpanel" aria-labelledby="showFiveDActives-tab">
                    <form style="background-color:transparent">
                        <div class="row">
                            <?php $now = date('Y-m-d'); ?>
                            @foreach ($stations as $station)
                                <?php
                                $today = date_create($now);
                                $created = date_create(substr($station->last_online, 0, 10));
                                $diff = date_diff($today, $created);
                                ?>
                                <div class="col-md-3" style="display: block">
                                    <div class="card @if ($diff->format('%a') < 5 && ($station->last_online) != null) fiveActives @else NoActives @endif"
                                         onclick="window.location = '{{ route('stations.show', $station->id) }}';"
                                         style="cursor:pointer;">
                                            <div class="card-body">
                                                <h4 class="card-title" style="font-weight: bolder;">
                                                    {{ $station->device_code }}</h4>
                                                <td>{{ $station->city->name }}</td>
                                                <h5 class="card-title" style="font-weight: bolder;">
                                                    {{ $station->mobile_number }}
                                                </h5>
                                                <i class="wi wi-night-sleet"></i>
                                                <span style="font-weight: bolder;">دمای هوا:</span>
                                                <span style="font-weight: bolder;">35</span>
                                                <hr>
                                                <span style="font-weight: bolder;">بروزرسانی:</span>
                                                <span
                                                    style="font-weight: bolder;">{{ $station->last_online ? jdate('Y/m/j H:i', strtotime($station->last_online)) : '-' }}</span>
                                                <i class="fa fa-cloud-sun" style="font-size: 40px;float:left"></i>
                                            </div>
                                            <br>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="showInactives" role="tabpanel" aria-labelledby="showInactives-tab">
                    <form style="background-color:transparent;">
                        <div class="row">
                            <?php $now = date('Y-m-d'); ?>
                            @foreach ($stations as $station)
                                <?php
                                $today = date_create($now);
                                $created = date_create(substr($station->last_online, 0, 10));
                                $diff = date_diff($today, $created);
                                ?>
                                <div class="col-md-3" style="display: block">
                                    <div class="card @if ($diff->format('%a') > 3  || ($station->last_online) == null) inactive @else NoActives @endif"
                                        onclick="window.location = '{{ route('stations.show', $station->id) }}';"
                                        style="cursor:pointer;">
                                        <div class="card-body">
                                            <h4 class="card-title" style="font-weight: bolder;">
                                                {{ $station->device_code }}</h4>
                                            <td>{{ $station->city->name }}</td>
                                            <h5 class="card-title" style="font-weight: bolder;">
                                                {{ $station->mobile_number }}
                                            </h5>
                                            <i class="wi wi-night-sleet"></i>
                                            <span style="font-weight: bolder;">دمای هوا:</span>
                                            <span style="font-weight: bolder;">35</span>
                                            <hr>
                                            <span style="font-weight: bolder;">بروزرسانی:</span>
                                            <span
                                                style="font-weight: bolder;">{{ $station->last_online ? jdate('Y/m/j H:i', strtotime($station->last_online)) : '-' }}</span>
                                            <i class="fa fa-cloud-sun" style="font-size: 40px;float:left"></i>
                                        </div>
                                        <br>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </body>
@endsection

@extends('layouts.admin', ['pageTitle' => 'امواج سرمایشی', 'newButton' => false])
@section('content')

    <div class="row" style="margin-bottom: 20px;">
        <div id="content">
            <div class="col-md-3" style="">

            </div>
            {{-- <div class="col-md-3" style="margin-top: 24px">
                <button class="btn">جستجو</button>
            </div> --}}
        </div>
    </div>
    <div class="row" style="margin: auto;">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link" id="info-tab" style="border: 2px solid aliceblue;color:black" data-toggle="tab"
                    href="#info" role="tab" aria-controls="info" aria-selected="false">نمایش اطلاعات</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="chart-tab" style="border: 2px solid aliceblue;color:black" data-toggle="tab"
                    href="#chart" role="tab" aria-controls="chart" aria-selected="false">نمودار</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent" style="margin-top: 15px">
            <div class="tab-pane fade" id="info" role="tabpanel" aria-labelledby="info-tab">نمایش اطلاعات</div>
            <div class="tab-pane fade" id="chart" role="tabpanel" aria-labelledby="chart-tab">نمودار</div>
        </div>
    </div>
@endsection

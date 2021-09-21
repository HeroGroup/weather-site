@extends('layouts.admin', ['pageTitle' => 'مخاطرات','icon'=>'fa-exclamation-triangle', 'newButton' => false])
@section('content')

    <link rel="stylesheet" type="text/css" href="/css/css.css" />
    <link href="/css/rtl/customStyle.css?v=2.1.2" rel="stylesheet">
    <link href="/css/rtl/customStyle.css.map" rel="stylesheet">
    <link href="/css/rtl/danger.css" rel="stylesheet">
    <script src="/js/jqueryCustom.min.js"></script>
    <script src="/js/bootstrap-material-design.min.js"></script>
    <script src="/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="/js/bootstrap-selectpicker.js"></script>
    <script src="/js/chartist.min.js"></script>
    <script src="/js/material-dashboard.js"></script>
    <script src="/js/material-dashboard.js.map"></script>


    <body>

        <div class="row" dir="rtl">
            <div class="col-md-4">
                <div class="card card-chart">
                    <a href="{{ route('dangers.CoolWavesReport') }}">
                        <div class="card-header card-header-warning">
                            <div class="icon-block" style="text-align: center;position: relative;">
                                <i class="fas fa-wind fa-5 fa-3dicon" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">امواج سرمایشی</h4>
                            <p class="card-category">
                                <span class="text-warning"><i class="fas fa-info-circle"></i> 55% </span> increase in today
                                sales.
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> آخرین به روز رسانی
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-chart">
                    <a href="{{ route('dangers.RainfallReport') }}">
                        <div class="card-header card-header-warning">
                            <div class="icon-block" style="text-align: center;position: relative;">
                                <i class="fas fa-cloud-showers-heavy fa-5 fa-3dicon" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">بارش</h4>
                            <p class="card-category">
                                <span class="text-warning"><i class="fas fa-info-circle"></i> 55% </span> increase in today
                                sales.
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> آخرین به روز رسانی
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-chart">
                    <a href="{{ route('dangers.glacialReport') }}">
                        <div class="card-header card-header-warning">
                            <div class="icon-block" style="text-align: center;position: relative;">
                                <i class="fas fa-snowflake fa-5 fa-3dicon" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">یخبندان</h4>
                            <p class="card-category">
                                <span class="text-warning"><i class="fas fa-info-circle"></i> 55% </span> increase in today
                                sales.
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> آخرین به روز رسانی
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card card-chart">
                    <a href="{{ route('dangers.HeatWaveReport') }}">
                        <div class="card-header card-header-warning">
                            <div class="icon-block" style="text-align: center;position: relative;">
                                <i class="fas fa-sun fa-5 fa-3dicon" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">موج گرمایی</h4>
                            <p class="card-category">
                                <span class="text-warning"><i class="fas fa-info-circle"></i> 55% </span> increase in today
                                sales.
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> آخرین به روز رسانی
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-chart">
                    <a href="{{ route('dangers.NeedCooling') }}">
                        <div class="card-header card-header-warning">
                            <div class="icon-block" style="text-align: center;position: relative;">
                                <i class="fa fa-asterisk fa-5 fa-3dicon" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">نیاز سرمایشی</h4>
                            <p class="card-category">
                                <span class="text-warning"><i class="fas fa-info-circle"></i> 55% </span> increase in today
                                sales.
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> آخرین به روز رسانی
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card card-chart">
                    <a href="{{ route('dangers.WetTempThreshold') }}">
                        <div class="card-header card-header-warning">
                            <div class="icon-block" style="text-align: center;position: relative;">
                                <i class="fas fa-temperature-high fa-5 fa-3dicon" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">آستانه دما-نمناکی</h4>
                            <p class="card-category">
                                <span class="text-warning"><i class="fas fa-info-circle"></i> 55% </span> increase in today
                                sales.
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> آخرین به روز رسانی
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    @endsection

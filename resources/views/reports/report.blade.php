@extends('layouts.admin', ['pageTitle' => 'گزارش ها', 'icon'=>'fa-file-text', 'newButton' => false])
@section('content')

    <link rel="stylesheet" type="text/css" href="/css/css.css" />
    <link href="/css/rtl/customStyle.css?v=2.1.2" rel="stylesheet">
    <link href="/css/rtl/customStyle.css.map" rel="stylesheet">
    <script src="/js/jqueryCustom.min.js"></script>
    <script src="/js/bootstrap-material-design.min.js"></script>
    <script src="/js/perfect-scrollbar.jquery.min.js"></script>
    <script src="/js/bootstrap-selectpicker.js"></script>
    <script src="/js/chartist.min.js"></script>
    <script src="/js/material-dashboard.js"></script>
    <script src="/js/material-dashboard.js.map"></script>
    <script src="/js/material-dashboard.min.js"></script>
    <style>
        #content {
            display: none;
        }

        a.button {
            -webkit-appearance: button;
            -moz-appearance: button;
            appearance: button;
            text-decoration: none;
            color: initial;


        }

        a.button:hover {
            color: #000000;
            background-color: #FFFFFF;
        }

        @font-face {
            font-family: IRANSans;
            src: url('/fonts/IRANSansFaNum.ttf');

        }

        html,
        body {
            font-family: IRANSans;
            font-size: 14px;
            line-height: 1.42857143;
            direction: rtl;
            text-align: right
        }

        .nav>li>a:hover {
            background-color: rgba(17, 207, 17, 0.493) !important;
        }

        fa,
        .fas {
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
        }



        .fa-5 {
            font-size: 5em;

        }

        .icon-block .fa-3dicon {
            /*transform-style*/
            -webkit-transform-style: preserve-3d;
            -moz-transform-style: preserve-3d;
            -ms-transform-style: preserve-3d;
            -o-transform-style: preserve-3d;
            transform-style: preserve-3d;
            /*perspective*/
            -webkit-perspective: 1000px;
            -moz-perspective: 1000px;
            -ms-perspective: 1000px;
            -o-perspective: 1000px;
            perspective: 1000px;
            /*Webkit*/
            -webkit-animation-name: rotate;
            -webkit-animation-duration: 3s;
            -webkit-animation-timing-function: linear;
            -webkit-animation-iteration-count: infinite;
            -webkit-animation-fill-mode: both;
            /*mozilla*/
            -moz-animation-name: rotate;
            -moz-animation-duration: 3s;
            -moz-animation-timing-function: linear;
            -moz-animation-iteration-count: infinite;
            -moz-animation-fill-mode: both;
            /*Opera*/
            -o-animation-name: rotate;
            -o-animation-duration: 3s;
            -o-animation-timing-function: linear;
            -o-animation-iteration-count: infinite;
            -o-animation-fill-mode: both;
            /*IE 10*/
            -ms-animation-name: rotate;
            -ms-animation-duration: 3s;
            -ms-animation-timing-function: linear;
            -ms-animation-iteration-count: infinite;
            -ms-animation-fill-mode: both;

            /*Default*/
            animation-name: rotate;
            animation-duration: 3s;
            animation-timing-function: linear;
            animation-iteration-count: infinite;
            animation-fill-mode: both;
            /* color:#25405D; */
            margin: 30px;
        }


        @-webkit-keyframes rotate {
            0% {
                text-shadow: 1px 1px 1px #CCC;
                -webkit-transform: rotateY(0deg);
            }

            25% {
                text-shadow: 1px 1px 1px #CCC, -2px 1px 1px #CCC, -3px 1px 1px #CCC, -4px 1px 1px #CCC, -4px 1px 1px #CCC,
                    -5px 1px 1px #CCC, -6px 1px 1px #CCC, -7px 1px 1px #CCC, -8px 1px 1px #CCC, -9px 1px 1px #CCC, -10px 1px 1px #CCC,
                    -11px 1px 1px #CCC, -12px 1px 1px #CCC, -13px 1px 1px #CCC, -14px 1px 1px #CCC, -15px 1px 1px #CCC, -16px 1px 1px #CCC,
                    -17px 1px 1px #CCC, -18px 1px 1px #CCC, -19px 1px 1px #CCC, -20px 1px 1px #CCC;
                -webkit-transform: rotateY(40deg);
            }

            50% {
                text-shadow: 0px 0px 0px #CCC;
                -webkit-transform: rotateY(0deg);
            }

            75% {
                text-shadow: 1px 1px 1px #CCC, 2px 1px 1px #CCC, 3px 1px 1px #CCC, 4px 1px 1px #CCC, 4px 1px 1px #CCC,
                    5px 1px 1px #CCC, 6px 1px 1px #CCC, 7px 1px 1px #CCC, 8px 1px 1px #CCC, 9px 1px 1px #CCC, 10px 1px 1px #CCC,
                    11px 1px 1px #CCC, 12px 1px 1px #CCC, 13px 1px 1px #CCC, 14px 1px 1px #CCC, 15px 1px 1px #CCC, 16px 1px 1px #CCC,
                    17px 1px 1px #CCC, 18px 1px 1px #CCC, 19px 1px 1px #CCC, 20px 1px 1px #CCC;
                -webkit-transform: rotateY(-40deg);
            }

            100% {
                text-shadow: 1px 1px 1px #CCC;
                -webkit-transform: rotateY(0deg);
            }
        }


        @-moz-keyframes rotate {
            0% {
                text-shadow: 1px 1px 1px #CCC;
                -moz-transform: rotateY(0deg);
            }

            25% {
                text-shadow: 1px 1px 1px #CCC, -2px 1px 1px #CCC, -3px 1px 1px #CCC, -4px 1px 1px #CCC, -4px 1px 1px #CCC,
                    -5px 1px 1px #CCC, -6px 1px 1px #CCC, -7px 1px 1px #CCC, -8px 1px 1px #CCC, -9px 1px 1px #CCC, -10px 1px 1px #CCC,
                    -11px 1px 1px #CCC, -12px 1px 1px #CCC, -13px 1px 1px #CCC, -14px 1px 1px #CCC, -15px 1px 1px #CCC, -16px 1px 1px #CCC,
                    -17px 1px 1px #CCC, -18px 1px 1px #CCC, -19px 1px 1px #CCC, -20px 1px 1px #CCC;
                -moz-transform: rotateY(40deg);
            }

            50% {
                text-shadow: 0px 0px 0px #CCC;
                -moz-transform: rotateY(0deg);
            }

            75% {
                text-shadow: 1px 1px 1px #CCC, 2px 1px 1px #CCC, 3px 1px 1px #CCC, 4px 1px 1px #CCC, 4px 1px 1px #CCC,
                    5px 1px 1px #CCC, 6px 1px 1px #CCC, 7px 1px 1px #CCC, 8px 1px 1px #CCC, 9px 1px 1px #CCC, 10px 1px 1px #CCC,
                    11px 1px 1px #CCC, 12px 1px 1px #CCC, 13px 1px 1px #CCC, 14px 1px 1px #CCC, 15px 1px 1px #CCC, 16px 1px 1px #CCC,
                    17px 1px 1px #CCC, 18px 1px 1px #CCC, 19px 1px 1px #CCC, 20px 1px 1px #CCC;
                -moz-transform: rotateY(-40deg);
            }

            100% {
                text-shadow: 1px 1px 1px #CCC;
                -moz-transform: rotateY(0deg);
            }
        }



        @-o-keyframes rotate {
            0% {
                text-shadow: 1px 1px 1px #CCC;
                -o-transform: rotateY(0deg);
            }

            25% {
                text-shadow: 1px 1px 1px #CCC, -2px 1px 1px #CCC, -3px 1px 1px #CCC, -4px 1px 1px #CCC, -4px 1px 1px #CCC,
                    -5px 1px 1px #CCC, -6px 1px 1px #CCC, -7px 1px 1px #CCC, -8px 1px 1px #CCC, -9px 1px 1px #CCC, -10px 1px 1px #CCC,
                    -11px 1px 1px #CCC, -12px 1px 1px #CCC, -13px 1px 1px #CCC, -14px 1px 1px #CCC, -15px 1px 1px #CCC, -16px 1px 1px #CCC,
                    -17px 1px 1px #CCC, -18px 1px 1px #CCC, -19px 1px 1px #CCC, -20px 1px 1px #CCC;
                -o-transform: rotateY(40deg);
            }

            50% {
                text-shadow: 0px 0px 0px #CCC;
                -o-transform: rotateY(0deg);
            }

            75% {
                text-shadow: 1px 1px 1px #CCC, 2px 1px 1px #CCC, 3px 1px 1px #CCC, 4px 1px 1px #CCC, 4px 1px 1px #CCC,
                    5px 1px 1px #CCC, 6px 1px 1px #CCC, 7px 1px 1px #CCC, 8px 1px 1px #CCC, 9px 1px 1px #CCC, 10px 1px 1px #CCC,
                    11px 1px 1px #CCC, 12px 1px 1px #CCC, 13px 1px 1px #CCC, 14px 1px 1px #CCC, 15px 1px 1px #CCC, 16px 1px 1px #CCC,
                    17px 1px 1px #CCC, 18px 1px 1px #CCC, 19px 1px 1px #CCC, 20px 1px 1px #CCC;
                -o-transform: rotateY(-40deg);
            }

            100% {
                text-shadow: 1px 1px 1px #CCC;
                -o-transform: rotateY(0deg);
            }
        }





        @keyframes rotate {
            0% {
                text-shadow: 1px 1px 1px #CCC;
                transform: rotateY(0deg);
            }

            25% {
                text-shadow: 1px 1px 1px #CCC, -2px 1px 1px #CCC, -3px 1px 1px #CCC, -4px 1px 1px #CCC, -4px 1px 1px #CCC,
                    -5px 1px 1px #CCC, -6px 1px 1px #CCC, -7px 1px 1px #CCC, -8px 1px 1px #CCC, -9px 1px 1px #CCC, -10px 1px 1px #CCC,
                    -11px 1px 1px #CCC, -12px 1px 1px #CCC, -13px 1px 1px #CCC, -14px 1px 1px #CCC, -15px 1px 1px #CCC, -16px 1px 1px #CCC,
                    -17px 1px 1px #CCC, -18px 1px 1px #CCC, -19px 1px 1px #CCC, -20px 1px 1px #CCC;
                transform: rotateY(40deg);
            }

            50% {
                text-shadow: 0px 0px 0px #CCC;
                transform: rotateY(0deg);
            }

            75% {
                text-shadow: 1px 1px 1px #CCC, 2px 1px 1px #CCC, 3px 1px 1px #CCC, 4px 1px 1px #CCC, 4px 1px 1px #CCC,
                    5px 1px 1px #CCC, 6px 1px 1px #CCC, 7px 1px 1px #CCC, 8px 1px 1px #CCC, 9px 1px 1px #CCC, 10px 1px 1px #CCC,
                    11px 1px 1px #CCC, 12px 1px 1px #CCC, 13px 1px 1px #CCC, 14px 1px 1px #CCC, 15px 1px 1px #CCC, 16px 1px 1px #CCC,
                    17px 1px 1px #CCC, 18px 1px 1px #CCC, 19px 1px 1px #CCC, 20px 1px 1px #CCC;
                transform: rotateY(-40deg);
            }

            100% {
                text-shadow: 1px 1px 1px #CCC;
                transform: rotateY(0deg);
            }
        }

        .copy {
            text-shadow: 1px 1px 1px #333333;
            color: #FFF;
        }

    </style>

    <div class="row" dir="rtl">
        <div class="col-md-4">
            <div class="card card-chart">
                <a href="{{ route('reports.dailyReport') }}">
                    <div class="card-header card-header-success">
                        <div class="icon-block" style="text-align: center;position: relative;">
                            <i class="fas fa-calendar-day fa-5 fa-3dicon" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">گزارش روزانه</h4>
                        <p class="card-category">
                            <span class="text-success"><i class="fas fa-info-circle"></i> 55% </span> increase in today
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
                <a href="{{ route('reports.periodicReport') }}">
                    <div class="card-header card-header-success">
                        <div class="icon-block" style="text-align: center;position: relative;">
                            <i class="fas fa-chart-pie fa-5 fa-3dicon" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">گزارش دوره ای</h4>
                        <p class="card-category">
                            <span class="text-success"><i class="fas fa-info-circle"></i> 55% </span> increase in today
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
                <a href="{{ route('reports.hourlyReport') }}">
                    <div class="card-header card-header-success">
                        <div class="icon-block" style="text-align: center;position: relative;">
                            <i class="fa fa-clock-o fa-5 fa-3dicon" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">گزارش ساعتی</h4>
                        <p class="card-category">
                            <span class="text-success"><i class="fas fa-info-circle"></i> 55% </span> increase in today
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
                <a href="{{ route('reports.yearReport') }}">
                    <div class="card-header card-header-success">
                        <div class="icon-block" style="text-align: center;position: relative;">
                            <i class="fa fa-file fa-5 fa-3dicon" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">گزارش سالانه</h4>
                        <p class="card-category">
                            <span class="text-success"><i class="fas fa-info-circle"></i> 55% </span> increase in today
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
                <a href="{{ route('reports.DoDreportPlant') }}">
                    <div class="card-header card-header-success">
                        <div class="icon-block" style="text-align: center;position: relative;">
                            <i class="fa fa-leaf fa-5 fa-3dicon" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">گزارش درجه-روز گیاه</h4>
                        <p class="card-category">
                            <span class="text-success"><i class="fas fa-info-circle"></i> 55% </span> increase in today
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
                <a href="{{ route('reports.DoDreportPest') }}">
                    <div class="card-header card-header-success">
                        <div class="icon-block" style="text-align: center;position: relative;">
                            <i class="fas fa-bug fa-5 fa-3dicon" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">گزارش درجه-روز آفت</h4>
                        <p class="card-category">
                            <span class="text-success"><i class="fas fa-info-circle"></i> 55% </span> increase in today
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
                <a href="{{ route('reports.LengthGrowingSeason') }}">
                    <div class="card-header card-header-success">
                        <div class="icon-block" style="text-align: center;position: relative;">
                            <i class="fa fa-line-chart fa-5 fa-3dicon" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">گزارش طول فصل رشد</h4>
                        <p class="card-category">
                            <span class="text-success"><i class="fas fa-info-circle"></i> 55% </span> increase in today
                            sales.
                        </p>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">access_time</i> آخرین به روز رسانی
                        </div>
                    </div>
            </div>
            </a>
        </div>
    </div>
    <script>

    </script>


@endsection
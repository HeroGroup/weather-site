<!DOCTYPE html>
<html class="no-js">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="contor control">
    <meta name="author" content="nHero">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'هواشناسی') }}</title>

    <link href="/css/rtl/bootstrap.min.css" rel="stylesheet">
    <link href="/css/rtl/bootstrap.rtl.css" rel="stylesheet">
    <link href="/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="/css/rtl/sb-admin-2.css" rel="stylesheet">
    <link href="/css/font-awesome/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="/css/font-awesome.css" rel="stylesheet">
    <link href="/css/my.css" rel="stylesheet" type="text/css">
    <link href="/css/jquery.timepicker.css" rel="stylesheet" type="text/css">
    <link href="/css/jquery-ui.css" rel="stylesheet" type="text/css">
    <link href="/css/persian-datepicker.min.css" rel="stylesheet">
    <link href="/css/fontawesome-free-5.15.1-web/css/all.css" rel="stylesheet" type="text/css">
    <script src="/js/modernizr.js" type="text/javascript"></script>
    <script src="/js/jquery-1.11.0.js" type="text/javascript"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/selectize.min.js"></script>
    <link rel="stylesheet" href="/css/selectize.bootstrap3.min.css" />
    <script>
        $(window).load(function() {
            $(".se-pre-con").fadeOut("slow");
        });

    </script>
    <style>
        @font-face {
            font-family: IRANSans;
            src: url('/fonts/IRANSansFaNum.ttf');
        }
        html, body {
            font-family: IRANSans;
        }
        .nav>li>a:hover {
            background-color: rgba(17, 207, 17, 0.493) !important;
        }
        table, th, td {
            border: solid 3px #f1c40f;
            border-collapse: collapse;
            padding: 2px 3px;
            text-align: center;
            background-color: rgb(240, 231, 231)
        }

        input[type='button'] {
            font: 15px IRANSans;
            cursor: pointer;
            border: none;
            color: #FFF;
        }

        input[type='text'],
        select {
            font: 17px IRANSans;
            text-align: center;
            border: solid 1px #CCC;
            /*width: auto;*/
            padding: 2px 3px;
        }


        .swal-footer {
            text-align: center;
        }

        .swal-button {
            border: solid 1 #CCC;
        }


        .no-js #loader {
            display: none;
        }

        .js #loader {
            display: block;
            position: absolute;
            left: 100px;
            top: 0;
        }

        .se-pre-con {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url(/image/Preloader_3.gif) center no-repeat #fff;
        }

    </style>
</head>

<body>
    <div class="se-pre-con"></div>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            @include('layouts.topBar')
            @include('layouts.sidebar')
        </nav>

        <div id="page-wrapper"
            style="background-image: url(/image/Solid-Background.png); background-repeat: no-repeat;background-size: cover;">

            <!-- Page Heading -->

            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        @if (isset($icon))
                            <i class="fa fa-fw {{ $icon }}"></i>
                        @endif
                        {{ $pageTitle }}
                        @if (isset($newButton) && $newButton)
                            @if (isset($newButtonModal))
                                <button type="button" class="pull-left btn btn-primary" data-toggle="modal"
                                    data-target="{{ $newButtonModal }}">
                                    <i class="fa fa-fw fa-plus"></i> {{ $newButtonText }}
                                </button>
                            @else
                                <a class="pull-left btn btn-primary" href="{{ $newButtonUrl }}">
                                    <i class="fa fa-fw fa-plus"></i> {{ $newButtonText }}
                                </a>
                            @endif
                        @endif
                    </h1>
                </div>
            </div>

            @if (\Illuminate\Support\Facades\Session::has('message'))
                @component('components.alert', [
                    'message' => \Illuminate\Support\Facades\Session::get('message'),
                    'type' => \Illuminate\Support\Facades\Session::get('type'),
                    ])
                @endcomponent
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')

        </div>
    </div>

    <script src="/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/js/metisMenu/metisMenu.min.js" type="text/javascript"></script>
    <script src="/js/sb-admin2.js" type="text/javascript"></script>
    <script src="/js/sweetalert.min.js" type="text/javascript"></script>
    <script src="/js/persian-date.min.js"></script>
    <script src="/js/persian-datepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.custom_date_picker').pDatepicker({
                initialValue: false,
                format: 'YYYY-MM-DD',
                autoClose: true,
                // minDate: new persianDate()
            });

            console.log("document ready");

            $('select').selectize({
                sortField: 'text'
            });
        });

        function destroy(itemId) {
            event.preventDefault();

            swal({
                title: "آیا این ردیف حذف شود؟",
                text: "توجه داشته باشید که عملیات حذف غیر قابل بازگشت می باشد.",
                icon: "warning",
                buttons: ["انصراف", "حذف"],
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    document.getElementById('destroy-form-' + itemId).submit();
                }
            });
        }

    </script>
</body>

</html>

@extends('layouts.admin', ['pageTitle' => 'پروفایل', 'icon'=>'fa fa-address-card','newButton' => false])
@section('content')

    <head>
        <meta charset="utf-8" />
        <link href="/css/rtl/customStyle.css?v=2.1.2" rel="stylesheet">
        <link href="/css/rtl/customStyle.css.map" rel="stylesheet">
        <script src="/js/jqueryCustom.min.js"></script>
        <script src="/js/bootstrap-material-design.min.js"></script>
        <script src="/js/perfect-scrollbar.jquery.min.js"></script>
        <script src="/js/bootstrap-selectpicker.js"></script>
        <script src="/js/chartist.min.js"></script>
    </head>

    <div dir="rtl" class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h3 class="card-title">ویرایش پروفایل</h3>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">(شماره موبایل)نام کاربری</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">آدرس ایمیل</label>
                                    <input type="email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">نام ونام خانوادگی</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="bmd-label-floating">تغییر کلمه عبور</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="row" style="justify-content: center;">
                            <button type="submit" style="font-size: 15px" class="btn btn-primary pull-right">ذخیره
                                تغییرات</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

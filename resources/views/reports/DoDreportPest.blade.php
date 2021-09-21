@extends('layouts.admin', ['pageTitle' => 'درجه روز آفت', 'newButton' => false])
@section('content')

    <head>
        <meta charset="utf-8" />
        <script src="/js/selectize.min.js"></script>
        <link rel="stylesheet" href="/css/selectize.bootstrap3.min.css" />

    </head>
    <div class="row">
        <div id="content">

            <div class="col-md-3">
                <label for="city_id">ایستگاه</label>
                {!! Form::select('city_id', $customList, null, ['class' => 'form-control', 'id' => 'city_id']) !!}
                {{-- {!! Form::select('city_id', $customList, null, ['id' => 'city_id', 'class' => 'form-control']) !!} --}}
            </div>
            <div class="col-md-3" style="">

                <label for="pestName">انتخاب آفت</label>
                {!! Form::select('pestName', $pests, null, ['class' => 'form-control']) !!}
                </select>
            </div>
            <div class="col-md-3">
                <label for="datePest">انتخاب تاریخ</label>
                <input type="text" name="datePest" id="datePest" class="custom_date_picker form-control" />
            </div>
            <div class="col-md-3" style="margin-top: 24px">
                <button class="btn">جستجو</button>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('select').selectize({
                sortField: 'text'
            });
        });

    </script>
    <script src="/js/ha-solardate.js"></script>
    <script src="/js/ha-datetimepicker.js"></script>
@endsection

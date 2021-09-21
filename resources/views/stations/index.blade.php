@extends('layouts.admin', ['pageTitle' => ' مدیریت ایستگاه ها','icon'=>'fa-building' , 'newButton' => true, 'newButtonModal' =>
'#createModal','newButtonText' => 'ایستگاه جدید','newButtonUrl' =>
'#createModal'])
@section('content')
    <style>
        * {
            box-sizing: border-box
        }

        .tablink {
            background-color: white;

            float: left;
            border: solid 4px green;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            font-size: 20px;
            font-weight: bold;
            width: 100%;
        }

        .tablink:hover {
            background-color: #adcebb;
        }

        .tabcontent {
            color: black;
            display: none;
            padding: 100px 20px;
            height: 100%;
        }

    </style>

    <div class="panel panel-default" style="border-color: green;">
        <div class="panel-heading" style="background-color: greenyellow">ایستگاه ها</div>
        <div class="panel-body">
            <div class="table table-responsive">
                <table class="table table-bordered">
                    <thead style="font-size: large">
                        <tr>
                            <td>نام شهرستان</td>
                            <td>کد دستگاه</td>
                            <td>شماره همراه</td>
                            <td>تاریخ</td>
                            <td>حذف</td>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($stations as $station)
                            <tr>
                                <td>{{ $station->city->name }}</td>
                                <td>{{ $station->device_code }}</td>
                                <td>{{ $station->mobile_number }}</td>
                                <td style="direction:ltr; text-align:center;">
                                    {{ jdate('Y/m/j H:i', strtotime($station->created_at)) }}
                                </td>
                                <td>
                                    <div class="modal" id="editModal-{{ $station->id }}" tabindex="-1" role="dialog"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">ویرایش اطلاعات ایستگاه</h5>
                                                </div>
                                                {!! Form::model($station, ['route' => ['stations.update', $station],
                                                'method' => 'PUT']) !!}
                                                <div class="modal-body">
                                                    <div class="media" style="justify-content: center;display:flex;">
                                                        <div class="media-right">
                                                            <label for="city_id">نام شهرستان</label>
                                                            {!! Form::select('city_id', $cities, null, ['class' =>
                                                            'form-control']) !!}
                                                            <br>
                                                            <label for="device_code">کد دستگاه</label>
                                                            <input type="text" name="device_code" class="form-control"
                                                                style="width: 100%" value="{{ $station->device_code }}"
                                                                required
                                                                oninvalid="setCustomValidity('این فیلد اجباری است')"
                                                                oninput="setCustomValidity('')" />
                                                            <br>
                                                            <label for="device_type">نوع دستگاه</label>
                                                            {!! Form::select('device_type', config('enums.device_type'),
                                                            null, ['class' => 'form-control']) !!}
                                                            <br>
                                                            <label for="device_title">عنوان دستگاه</label>
                                                            <input type="text" name="device_title" class="form-control"
                                                                style="width: 100%" value="{{ $station->device_title }}" />
                                                            <br>
                                                        </div>
                                                        <div class="media-left">
                                                            <label for="serial_number">شماره سریال</label>
                                                            <input type="text" name="serial_number" class="form-control"
                                                                style="width: 100%" maxlength="150"
                                                                value="{{ $station->serial_number }}" />
                                                            <br>
                                                            <label for="mobile_number">تلفن همراه</label>
                                                            <input type="text" name="mobile_number" class="form-control"
                                                                style="width: 100%" maxlength="150"
                                                                value="{{ $station->mobile_number }}" />
                                                            <br>
                                                            <label for="IP">IP</label>
                                                            <input type="text" name="IP" class="form-control"
                                                                maxlength="150" style="width: 100%"
                                                                value="{{ $station->IP }}" />
                                                            <br>
                                                            <label for="communication_type">نوع ارتباط</label>
                                                            {!! Form::select('communication_type',
                                                            config('enums.communication_type'), null, ['class' =>
                                                            'form-control']) !!}

                                                            <br />
                                                        </div>
                                                    </div>
                                                    <label for="sea_level">ارتفاع از سطح دریا</label>
                                                    <input type="text" name="sea_level" class="form-control"
                                                        style="width: 100%" maxlength="150"
                                                        value="{{ $station->sea_level }}" />
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">ذخیره</button>
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">انصراف</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>

                                    <button type="button" class="btn btn-xs btn-success" data-toggle="modal"
                                        data-target="#editModal-{{ $station->id }}">
                                        <i class="fas fa-edit"></i> ویرایش
                                    </button>
                                    <form id="destroy-form-{{ $station->id }}" method="post"
                                        action="{{ route('stations.destroy', $station) }}" style="display:none">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>

                                    <button onclick='destroy({{ $station->id }});' class="btn btn-xs btn-danger"
                                        data-toggle="tooltip" title="حذف">
                                        <i class="fa fa-trash" aria-hidden="true"></i> حذف
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="modal" id="createModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ایستگاه جدید</h5>
                </div>
                <form method="post" action="{{ route('stations.store') }}">
                    <div class="modal-body">
                        @csrf
                        <div class="media" style="justify-content: center;display:flex;">
                            <div class="media-right">
                                <label for="city_id">شهرستان</label>
                                {!! Form::select('city_id', $cities, null, ['class' => 'form-control']) !!}
                                </select>
                                <br>
                                <label for="device_code">کد دستگاه</label>
                                <input type="text" name="device_code" class="form-control" style="width: 100%" required
                                    oninvalid="setCustomValidity('این فیلد اجباری است')" oninput="setCustomValidity('')"
                                    value="{{ old('device_code') }}" />
                                <br>
                                <label for="device_type">نوع دستگاه</label>
                                {!! Form::select('device_type', config('enums.device_type'), null, ['class' =>
                                'form-control']) !!}
                                <br>
                                <label for="device_title">عنوان دستگاه</label>
                                <input type="text" name="device_title" class="form-control" style="width: 100%" required
                                    oninvalid="setCustomValidity('این فیلد اجباری است')" oninput="setCustomValidity('')"
                                    value="{{ old('device_title') }}" />

                            </div>
                            <div class="media-left">
                                <label for="serial_number">شماره سریال</label>
                                <input type="text" name="serial_number" class="form-control" style="width: 100%"
                                    maxlength="150" required oninvalid="setCustomValidity('این فیلد اجباری است')"
                                    oninput="setCustomValidity('')" value="{{ $station->serial_number }}" />
                                <br>
                                <label for="mobile_number">تلفن همراه</label>
                                <input type="text" name="mobile_number" class="form-control" style="width: 100%"
                                    maxlength="150" required oninvalid="setCustomValidity('این فیلد اجباری است')"
                                    oninput="setCustomValidity('')" value="{{ old('mobile_number') }}" />
                                <br>
                                <label for="IP">IP</label>
                                <input type="text" name="IP" class="form-control" maxlength="150" style="width: 100%"
                                    required oninvalid="setCustomValidity('این فیلد اجباری است')"
                                    oninput="setCustomValidity('')" value="{{ old('IP') }}" />
                                <br>
                                <label for="communication_type">نوع ارتباط</label>
                                {!! Form::select('communication_type', config('enums.communication_type'), null, ['class' =>
                                'form-control']) !!}
                                <br />

                            </div>
                        </div>
                        <label for="sea_level">ارتفاع از سطح دریا</label>
                        <input type="text" name="sea_level" class="form-control" style="width: 100%" maxlength="150"
                            required oninvalid="setCustomValidity('این فیلد اجباری است')" oninput="setCustomValidity('')"
                            value="{{ old('sea_level') }}" />
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">ذخیره</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

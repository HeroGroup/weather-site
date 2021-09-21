@extends('layouts.admin', ['pageTitle' => 'مدیریت آفت ها','icon'=>'fa-bug fa-fw' , 'newButton' => true, 'newButtonUrl' => '#createModal',
'newButtonText' => 'آفت جدید', 'newButtonModal' => '#createModal'])
@section('content')
    <div class="panel panel-default" style="border-color: green;">
        <div class="panel-heading" style="background-color: greenyellow">آفت ها</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="font-size: large">
                        <tr>
                            <th>نام آفت</th>
                            <th>دمای پایه</th>
                            <th>حداکثر دما</th>
                            <th>مجموع دریافت دما</th>
                            <th>توضیحات</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pests as $pest)
                            <tr>
                                <td>{{ $pest->name }}</td>
                                <td>{{ $pest->base_temperature }}</td>
                                <td>{{ $pest->max_temperature }}</td>
                                <td>{{ $pest->total_temperature }}</td>
                                <td>{{ $pest->description }}</td>
                                <td>
                                    <div class="modal" id="editModal-{{ $pest->id }}" tabindex="-1" role="dialog"
                                        aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">ویرایش اطلاعات آفت</h5>
                                                </div>
                                                {!! Form::model($pest, ['route' => ['pests.update', $pest], 'method' =>
                                                'PUT']) !!}
                                                <div class="modal-body">
                                                    <label for="name">نام آفت</label>
                                                    <input type="text" name="name" class="form-control"
                                                        value="{{ $pest->name }}" required
                                                        oninvalid="setCustomValidity('این فیلد اجباری است')"
                                                        oninput="setCustomValidity('')" />
                                                    <br>
                                                    <label for="base_temperature">دمای پایه</label>
                                                    <input type="text" name="base_temperature" class="form-control"
                                                        value="{{ $pest->base_temperature }}" />
                                                    <br>
                                                    <label for="max_temperature">حداکثر دما</label>
                                                    <input type="text" name="max_temperature" class="form-control"
                                                        value="{{ $pest->max_temperature }}" />
                                                    <br>
                                                    <label for="total_temperature">مجموع دریافت دما</label>
                                                    <input type="text" name="total_temperature" class="form-control"
                                                        value="{{ $pest->total_temperature }}" />
                                                    <br>
                                                    <label for="description">توضیحات آفت</label>
                                                    <input type="text" name="description" class="form-control"
                                                        value="{{ $pest->description }}" />
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
                                        data-target="#editModal-{{ $pest->id }}">
                                        <i class="fas fa-edit"></i> ویرایش
                                    </button>

                                    <form id="destroy-form-{{ $pest->id }}" method="post"
                                        action="{{ route('pests.destroy', $pest) }}" style="display:none">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>

                                    <button onclick='destroy({{ $pest->id }});' class="btn btn-xs btn-danger"
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
                    <h5 class="modal-title">آفت جدید</h5>
                </div>
                <form method="post" action="{{ route('pests.store') }}">
                    <div class="modal-body">
                        @csrf
                        <label for="name">نام آفت</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name') }}" maxlength="50"
                            required oninvalid="setCustomValidity('این فیلد اجباری است')" oninput="setCustomValidity('')" />
                        <br>
                        <label for="base_temperature">دمای پایه</label>
                        <input type="text" name="base_temperature" class="form-control"
                            value="{{ old('base_temperature') }}" required
                            oninvalid="setCustomValidity('این فیلد اجباری است')" oninput="setCustomValidity('')" />
                        <br>
                        <label for="max_temperature">حداکثر دما</label>
                        <input type="text" name="max_temperature" class="form-control" value="{{ old('max_temperature') }}"
                            required oninvalid="setCustomValidity('این فیلد اجباری است')" oninput="setCustomValidity('')" />
                        <br>
                        <label for="total_temperature">مجموع دریافت دما</label>
                        <input type="text" name="total_temperature" class="form-control"
                            value="{{ old('total_temperature') }}" required
                            oninvalid="setCustomValidity('این فیلد اجباری است')" oninput="setCustomValidity('')" />
                        <br>
                        <label for="description">توضیحات آفت</label>
                        <input type="text" name="description" class="form-control" maxlength="150"
                            value="{{ old('description') }}" required oninvalid="setCustomValidity('این فیلد اجباری است')"
                            oninput="setCustomValidity('')" />
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
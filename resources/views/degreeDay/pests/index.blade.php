@extends('layouts.admin', ['pageTitle' => 'درجه-روز آفت', 'icon'=>'fa-bug fa-fw','newButton' => true, 'newButtonUrl' => '#createModal', 'newButtonText' => 'ایجاد درجه-روز آفت', 'newButtonModal' => '#createModal'])
@section('content')
    <div class="panel panel-default" style="border-color: green;">
        <div class="panel-heading" style="background-color: greenyellow">لیست درجه-روز آفت</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="font-size: large">
                    <tr>
                        <th>ایستگاه</th>
                        <th>آفت</th>
                        <th>تاریخ شروع</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->station->device_title}}</td>
                            <td>{{$item->pest->name}}</td>
                            <td>{{$item->start_date}}</td>
                            <td>
                                <div class="modal" id="editModal-{{$item->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">ویرایش اطلاعات درجه-روز آفت</h5>
                                            </div>
                                            {!! Form::model($item, array('route' => array('degreeDayPests.update', $item), 'method' => 'PUT')) !!}
                                            <div class="modal-body">
                                                <label for="station_id">ایستگاه</label>
                                                {!! Form::select('station_id', $stations, $item->station_id, array('class' => 'form-control')) !!}
                                                <br>
                                                <label for="pest_id">آفت</label>
                                                {!! Form::select('pest_id', $pests, $item->pest_id, array('class' => 'form-control')) !!}
                                                <br>
                                                <label for="start_date">تاریخ شروع</label>
                                                <input type="text" name="start_date" class="form-control custom_date_picker" value="{{$item->start_date}}" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">ذخیره</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#editModal-{{$item->id}}">
                                     <i class="fas fa-edit"></i> ویرایش
                                </button>

                                <form id="destroy-form-{{$item->id}}" method="post" action="{{route('degreeDayPests.destroy', $item)}}" style="display:none">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>

                                <button onclick='destroy({{$item->id}});' class="btn btn-xs btn-danger" data-toggle="tooltip" title="حذف">
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
                    <h5 class="modal-title">اطلاعات درجه-روز آفت جدید</h5>
                </div>
                <form method="post" action="{{route('degreeDayPests.store')}}">
                    <div class="modal-body">
                        @csrf
                        <label for="station_id">ایستگاه</label>
                        {!! Form::select('station_id', $stations, old('station_id'), array('class' => 'form-control')) !!}
                        <br>
                        <label for="pest_id">آفت</label>
                        {!! Form::select('pest_id', $pests, old('pest_id'), array('class' => 'form-control')) !!}
                        <br>
                        <label for="start_date">تاریخ شروع</label>
                        <input type="text" name="start_date" class="form-control custom_date_picker" value="{{old('start_date')}}" required oninvalid="setCustomValidity('این فیلد اجباری است')" oninput="setCustomValidity('')" />
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
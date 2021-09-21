@extends('layouts.admin', ['pageTitle' => 'بیماری ها','icon'=>'fa-disease', 'newButton' => true, 'newButtonUrl' => '#createModal', 'newButtonText' => 'ایجاد بیماری', 'newButtonModal' => '#createModal'])
@section('content')
    <div class="panel panel-default" style="border-color: green;">
        <div class="panel-heading" style="background-color: greenyellow">بیماری ها</div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead style="font-size: large">
                    <tr>
                        <th>نام بیماری</th>
                        <th>توضیحات</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($illnesses as $illness)
                        <tr>
                            <td>{{$illness->name}}</td>
                            <td>{{$illness->description}}</td>
                            <td>
                                <div class="modal" id="editModal-{{$illness->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">ویرایش اطلاعات بیماری</h5>
                                            </div>
                                            {!! Form::model($illness, array('route' => array('illnesses.update', $illness), 'method' => 'PUT')) !!}
                                            <div class="modal-body">
                                                <label for="name">نام بیماری</label>
                                                <input type="text" name="name" class="form-control" value="{{$illness->name}}" />
                                                <br>
                                                <label for="description">توضیحات بیماری</label>
                                                <input type="text" name="description" class="form-control" value="{{$illness->description}}" />
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">ذخیره</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">انصراف</button>
                                            </div>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                </div>

                                <button type="button" class="btn btn-xs btn-success" data-toggle="modal" data-target="#editModal-{{$illness->id}}">
                                   <i class="fas fa-edit"></i>  ویرایش
                                </button>

                                <form id="destroy-form-{{$illness->id}}" method="post" action="{{route('illnesses.destroy', $illness)}}" style="display:none">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="_method" value="DELETE">
                                </form>

                                <button onclick='destroy({{$illness->id}});' class="btn btn-xs btn-danger" data-toggle="tooltip" title="حذف">
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
                    <h5 class="modal-title">بیماری جدید</h5>
                </div>
                <form method="post" action="{{route('illnesses.store')}}">
                <div class="modal-body">
                    @csrf
                    <label for="name">نام بیماری</label>
                    <input type="text" name="name" class="form-control" value="{{old('name')}}" required oninvalid="setCustomValidity('این فیلد اجباری است')" oninput="setCustomValidity('')"/>
                    <br>
                    <label for="description">توضیحات بیماری</label>
                    <input type="text" name="description" class="form-control" value="{{old('description')}}" required oninvalid="setCustomValidity('این فیلد اجباری است')" oninput="setCustomValidity('')"/>
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

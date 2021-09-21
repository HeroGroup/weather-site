@extends('layouts.admin', ['pageTitle' => 'ایجاد کاربر', 'newButton' => false])
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">ویرایش مشخصات کاربر</div>
                <div class="panel-body">
                    {!! Form::model($user, array('route' => array('users.update', $user), 'method' => 'PUT')) !!}
                    @csrf
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="name" class="col-sm-4 control-label">نام</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-4 control-label">آدرس ایمیل</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="email" name="email" value="{{$user->email}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="mobile" class="col-sm-4 control-label">شماره موبایل (نام کاربری)</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="mobile" minlength="11" maxlength="11" name="mobile" value="{{$user->mobile}}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-8 text-left">
                                <button type="button" class="btn btn-primary" onclick="resetPassword('{{$user->id}}')">بازنشانی رمزعبور</button>
                                <button class="btn btn-default"><a href="{{route('users.index')}}" style="color: black;">انصراف</a></button>
                                <button type="submit" class="btn btn-success">ذخیره</button>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">سطوح دسترسی</div>
                <div class="panel-body">
                    <form method="post" action="{{route('roles.updateUserRoles')}}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        @foreach($roles as $key => $role)
                            <div class="col-sm-4">
                                <label class="custom-checkbox"> {{$role}}
                                    <input type="checkbox" name="roles[{{$key}}]" @if($user->hasRole($role)) checked @endif>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        @endforeach
                        <br>
                        <div class="text-left">
                            <button type="submit" class="btn btn-success">ثبت</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">دسترسی ایستگاه ها</div>
                <div class="panel-body">
                    <table class="table data-table" style="background-color: #c1c1c1; border-radius: 5px;">
                        <thead>
                        <tr>
                            <th></th>
                            <th>شماره سریال</th>
                            <th>شهر</th>
                            <th class="text-center">وضعیت</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($stations as $station)
                            <tr>
                                <td>
                                    @if(\Illuminate\Support\Facades\DB::table('user_stations')->where('user_id', $user->id)->where('station_id', $station->id)->count() > 0)
                                        <i class="fa fa-fw fa-circle text-success"></i>
                                    @else
                                        <i class="fa fa-fw fa-circle-o"></i>
                                    @endif
                                </td>
                                <td>{{$station->device_code}}</td>
                                <td>{{$station->city_id ? $station->city->name : ''}}</td>
                                <td class="text-center">
                                    @if(\Illuminate\Support\Facades\DB::table('user_stations')->where('user_id', $user->id)->where('station_id', $station->id)->count() > 0)
                                        انتساب داده شده
                                    @else
                                        فاقد مجوز
                                    @endif
                                </td>
                                <td class="text-left">
                                    @if(\Illuminate\Support\Facades\DB::table('user_stations')->where('user_id', $user->id)->where('station_id', $station->id)->count() > 0)
                                        <a class="btn btn-danger btn-sm" href="#" onclick="revokeUser('{{csrf_token()}}','{{$station->id}}','{{$user->id}}')">
                                            <i class="fa fa-fw fa-remove"></i> لغو
                                        </a>
                                    @else
                                        <a class="btn btn-info btn-sm" href="#" onclick="assignUser('{{csrf_token()}}', '{{$station->id}}', '{{$user->id}}')">
                                            <i class="fa fa-fw fa-check"></i> انتساب
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function resetPassword(userId) {
            console.log(userId);
            $.ajax("{{route('users.resetPassword', $user->id)}}", {
                type: "get",
                success: function(response) {
                    swal(response.message);
                }
            })
        }
        function assignUser(csrf, stationId, userId) {
            event.preventDefault();

            $.ajax('{{route('stations.assignUser')}}', {
                method: 'post',
                data: {
                    _token: csrf,
                    station_id: stationId,
                    user_id: userId
                },
                success: function(response) {
                    if (response.status === 1)
                        window.location.reload();
                    else
                        alert(response.message);
                }
            }).fail(function (err) {
                console.log(err);
                alert('خطایی رخ داده است');
            });
        }

        function revokeUser(csrf, stationId, userId) {
            event.preventDefault();

            $.ajax('{{route('stations.revokeUser')}}', {
                method: 'post',
                data: {
                    _token: csrf,
                    station_id: stationId,
                    user_id: userId
                },
                success: function(response) {
                    if (response.status === 1)
                        window.location.reload();
                    else
                        alert(response.message);
                }
            }).fail(function (err) {
                console.log(err);
                alert('خطایی رخ داده است');
            });
        }
    </script>
@endsection

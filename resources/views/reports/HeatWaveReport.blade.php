@extends('layouts.admin', ['pageTitle' => 'امواج گرمایی', 'newButton' => false])
@section('content')

    <div class="row">
        <div id="content">

            <div class="col-md-3" style="">

                <label for="city_id">ایستگاه</label>
                {!! Form::select('city_id', $customList, null, ['class' => 'form-control']) !!}
                </select>

            </div>
            <div class="col-md-3" style="margin-top: 24px">
                <button class="btn">جستجو</button>
            </div>

        </div>
    </div>
@endsection

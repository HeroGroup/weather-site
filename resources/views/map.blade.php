@extends('layouts.admin', ['pageTitle' => 'نقشه', 'icon'=>'fa-map','newButton' => false])
@section('content')
    @component('components.map')@endcomponent
@endsection

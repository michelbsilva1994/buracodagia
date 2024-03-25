@extends('layout.app')
@section('content')
    <div class="col-6">
        {!! $dashboard->container() !!}
    </div>
    {!! $dashboard->script() !!}
@endsection

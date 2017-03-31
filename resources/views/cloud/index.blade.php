@extends('master')

@section('speed-dial')
    <quick-action></quick-action>
@stop

@section('content')

    <secure-cloud :initial-files="{{ $files }}"></secure-cloud>

    @yield('speed-dial')

@stop
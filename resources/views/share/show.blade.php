@extends('master')

@section('content')

    <secure-cloud :initial-files="{{ $files }}" share-id="{{ $hash }}" user-name="{{ $username }}"></secure-cloud>

@stop
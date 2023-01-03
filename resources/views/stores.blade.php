@extends('layout')

@section('title', 'Ligen & Spielorte')

@section('content')

@foreach ($stores as $store)
    <div class="store">
        {{ $store }}
    </div>
@endforeach

@endsection

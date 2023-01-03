@extends('layout')

@section('title', 'Bevorstehende Turniere')

@section('content')

@foreach ($tournaments as $tournament)
    <div class="tournament">
        {{ $tournament }}
    </div>
@endforeach

@endsection

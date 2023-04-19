@extends('layout')

@section('title', 'Ligen & Spielorte')

@section('content')

<p>Auf dieser Seite findest du alle aktiven Spielorte und Ligen in der Region.</p>

<table class="data-table striped">
    <tr>
        <th class="sort" data-sort="name">Name</th>
        <th class="sort" data-sort="city">Stadt</th>
    </tr>
    @foreach ($stores as $row)
        <tr data-name="{{ $row->name }}" data-city="{{ $row->zip_code }}">
            <td><a href="{{ route('store', [ 'id' => $row->id ]) }}">{{ $row->name }}</a></td>
            <td><a href="{{ route('store', [ 'id' => $row->id ]) }}">{{ $row->zip_code }} {{ $row->city }}</a></td>
        </tr>
    @endforeach
</table>

@endsection

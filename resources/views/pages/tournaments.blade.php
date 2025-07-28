@extends('layout')

@section('title', 'Bevorstehende Turniere')

@section('content')

<p>Auf dieser Seite findest du alle bevorstehenden Turniere in der Region.</p>

<table class="data-table striped">
    <tr>
        <th class="sort" data-sort="date">Datum</th>
        <th class="sort" data-sort="type">Turnier</th>
        <th class="sort" data-sort="city">Ort</th>
    </tr>
    @foreach ($tournaments as $row)
        <tr data-date="{{ $row->date }}" data-type="{{ $row->type }}" data-city="{{ $row->store->city }}">

            <td><a href="{{ route('tournament', [ 'id' => $row->id ]) }}">{{ full_date($row->date) }}</a></td>
            <td><a href="{{ route('tournament', [ 'id' => $row->id ]) }}">{{ tournament_name($row) }}</a></td>
            <td><a href="{{ route('store', [ 'id' => $row->store->id ]) }}">{{ $row->store->name }} {{ $row->store->city }}</a></td>
        </tr>
    @endforeach
</table>

@endsection

@extends('layout')

@section('title', 'Bevorstehende Turniere')

@section('content')

<table class="data-table striped">
    <tr>
        <th class="sort" data-sort="date">Datum</th>
        <th class="sort" data-sort="type">Turnier</th>
        <th class="sort" data-sort="city">Ort</th>
    </tr>
    @foreach ($tournaments as $row)
        <tr data-date="{{ $row->date }}" data-type="{{ $row->type }}" data-city="{{ $row->store->city }}">

            <td><a href="{{ route('tournament', [ 'id' => $row->id ]) }}">{{ full_date($row->date) }}</a></td>
            <td><a href="{{ route('tournament', [ 'id' => $row->id ]) }}">{{ __("pokemon.$row->type") }}</a></td>
            <td><a href="{{ route('tournament', [ 'id' => $row->id ]) }}">{{ $row->store->name }} {{ $row->store->city }}</a></td>
        </tr>
    @endforeach
</table>

@endsection

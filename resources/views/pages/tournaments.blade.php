@extends('layout')

@section('title', 'Bevorstehende Turniere')

@section('content')

<p>Auf dieser Seite findest du alle bevorstehenden Turniere in der Region.</p>

<form method="GET" action="{{ url()->current() }}">
    <select name="type" onchange="this.form.submit()" class="tournament-filter">
        <option value="">Alle Turniere</option>
        <option value="prerelease" {{ $type === 'prerelease' ? 'selected' : '' }}>{{ __('pokemon.prerelease') }}</option>
        <option value="challenge" {{ $type === 'challenge' ? 'selected' : '' }}>{{ __('pokemon.challenge') }}</option>
        <option value="cup" {{ $type === 'cup' ? 'selected' : '' }}>{{ __('pokemon.cup') }}</option>
        <option value="locals" {{ $type === 'locals' ? 'selected' : '' }}>{{ __('pokemon.locals') }}</option>
        <option value="vg_challenge" {{ $type === 'vg_challenge' ? 'selected' : '' }}>{{ __('pokemon.vg_challenge') }}</option>
        <option value="vg_cup" {{ $type === 'vg_cup' ? 'selected' : '' }}>{{ __('pokemon.vg_cup') }}</option>
        <option value="go_challenge" {{ $type === 'go_challenge' ? 'selected' : '' }}>{{ __('pokemon.go_challenge') }}</option>
        <option value="go_cup" {{ $type === 'go_cup' ? 'selected' : '' }}>{{ __('pokemon.go_cup') }}</option>
    </select>
</form>

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

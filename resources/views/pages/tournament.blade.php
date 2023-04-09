@extends('layout')

@section('title', join(' ', [__("pokemon.$tournament->type"), $tournament->store->name, $tournament->store->city, date_only($tournament->date)]))

@section('content')

@section('scripts')
    @parent
    @vite('resources/scripts/registration.js')
@endsection

<ul>
    <li>{{ __("pokemon.$tournament->type") }}</li>
    <li>{{ $tournament->store->name}} {{ $tournament->store->city }}</li>
    <li>{{ $tournament->date }}</li>
    <li>Format: {{ __("pokemon.$tournament->format") }}</li>
    @if ($tournament->cap) <li>Max. {{ $tournament->cap }} Plätze</li> @endif
    @if ($tournament->cost)<li>Anmeldegebühr: {{ $tournament->cost }}€</li> @endif
    @if ($tournament->notes) <li>{{ $tournament->notes }}</li> @endif
</ul>

<h2>Anmeldeformular</h2>

<form action="post" class="registration-form" data-id="{{ $tournament->id }}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="response"></div>

    <input type="hidden" name="deck">

    <div class="row">
        <label for="name">Email</label>
        <input type="email" id="email" name="email" required>
    </div>

    <hr>

    <div class="row">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div class="row">
        <div class="split">
            <label for="id">Player ID</label>
            <input type="text" id="id" name="id">
        </div>
        <div class="split">
            <label for="bd">Geburtsdatum</label>
            <input id="bd" name="bd" type="date" max="{{ date('Y-m-d') }}" required>
        </div>
    </div>

    <button data-submit>Absenden</button>
</form>

@endsection

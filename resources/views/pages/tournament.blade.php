@extends('layout')

@section('title', join(' ', [__("pokemon.$tournament->type"), $tournament->store->name, $tournament->store->city, date_only($tournament->date)]))

@section('content')

@section('scripts')
    @parent
    @vite('resources/scripts/registration.js')
@endsection

<h2>{{ __("pokemon.$tournament->type") }} {{ $tournament->store->city }}</h2>

<div class="tournament-info">
    <table class="info-table">
        <tr>
            <td>Wo?</td>
            <td><a href="{{ route('store', [ 'id' => $tournament->store->id ]) }}">{{ $tournament->store->name}} {{ $tournament->store->city }}</a></td>
        </tr>
        <tr>
            <td>Wann?</td>
            <td>{{ full_date($tournament->date) }}</td>
        </tr>
        @if ($tournament->format)
            <tr>
                <td>Format</td>
                <td>{{ __("pokemon.$tournament->format") }}</td>
            </tr>
        @endif
        @if ($tournament->cap || $tournament->cost)
            <tr>
                <td>Anmeldung</td>
                <td>
                    @if ($tournament->cost) {{ $tournament->cost }}€ @endif
                    @if ($tournament->cap && $tournament->cost) - @endif
                    @if ($tournament->cap) Max. {{ $tournament->cap }} Plätze @endif
                </td>
            </tr>
        @endif
    </table>

    @if ($tournament->notes) <p>{{ $tournament->notes }}</p> @endif
</div>

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
        <div class="split">
            <label for="first_name">Vorname</label>
            <input id="first_name" name="first_name" type="text" required>
        </div>
        <div class="split">
            <label for="last_name">Nachname</label>
            <input id="last_name" name="last_name" type="text">
        </div>
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

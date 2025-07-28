@extends('layout')

@section('title', 'Anmeldung')

@section('content')

@section('scripts')
    @parent
    @vite('resources/scripts/registration.js')
@endsection

<p>
    <a href="{{ route('tournament', [ 'id' => $tournament->id ]) }}" class="underline">
        {{ tournament_name($tournament) }} {{ $tournament->store->name }} {{ $tournament->store->city }}<br>
        {{ full_date($tournament->date) }}
    </a><br>
</p>

<p>
    {{ $registration->first_name }} {{ $registration->last_name }} ({{ $registration->playerid }})
</p>

<p>Du bist derzeit auf Platz <b>{{ $position }}</b> der Anmeldeliste (max. {{ $tournament->cap }} Plätze).</p>

<div class="response"></div>

<p>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <button class="danger" data-unregister="{{ $registration->code }}" @if (!$can_unregister) disabled @endif>Abmelden</button>
</p>

<p class="text-sm">Abmeldung möglich bis 24 Stunden vor Turnierbeginn.</p>

@endsection

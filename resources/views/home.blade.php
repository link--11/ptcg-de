@extends('layout')

@section('content')

<div class="home">
    <div class="upcoming">
        <h2>Bevorstehende Turniere</h2>
        <div>
            @foreach ($upcoming as $row)
                <a class="tournament" href="{{ route('tournament', [ 'id' => $row->id ]) }}">
                    <div class="info">
                        <div class="name">{{ tournament_name($row) }} {{ $row->store->city }}</div>
                        <div class="date">{{ short_date($row->date) }}</div>
                    </div>
                    @if ($row->type === 'cup' || $row->type === 'challenge')
                        <img src="/pics/{{ $row->type }}.png" alt="{{ __("pokemon.$row->type") }}">
                    @endif
                </a>
            @endforeach
        </div>

        <a class="view-all" href="{{ route('tournaments') }}">Alle Turniere</a>

        <a class="discord" href="http://discord.gg/3dKHst4HnB">
            <img src="/pics/discord.png" alt="Discord">
            Trete der Play! Pokémon NRW Discord Community bei um immer auf dem Laufenden zu bleiben!
        </a>
    </div>
    <div class="recent">
        <h2>Aktuelle Ergebnisse</h2>
        <div>
            <img src="/under_construction.gif">
        </div>
    </div>
</div>

@endsection

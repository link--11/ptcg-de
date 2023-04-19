@extends('layout')

@section('title', "$store->name $store->city")

@section('content')

<h1>{{ $store->name }} {{ $store->city }}</h1>

<div class="store-info">
    @if ($store->picture)
        <div class="profile-picture">
            <img src="/upload/stores/{{ $store->id }}/{{ $store->picture}}" alt="{{ $store->name }}">
        </div>
    @endif

    <div>
        <table class="info-table">
            <tr>
                <td>Adresse</td>
                <td>
                    {{ $store->address }} <br>
                    {{ $store->zip_code}} {{ $store->city }}
                </td>
            </tr>
            @if ($store->email)
                <tr>
                    <td>Email</td>
                    <td><a href="mailto:{{ $store->email }}">{{ $store->email }}</a></td>
                </tr>
            @endif
            @if ($store->phone)
                <tr>
                    <td>Telefon</td>
                    <td>{{ $store->phone }}</td>
                </tr>
            @endif
            @if ($store->website)
                <tr>
                    <td>Website</td>
                    <td><a target="_blank" href="{{ $store->website }}">{{ $store->website }}</a></td>
                </tr>
            @endif
            @if ($store->league)
                <tr>
                    <td>Liga</td>
                    <td>{{ $store->league }}</td>
                </tr>
            @endif
        </table>

        @if ($store->notes) <p>{{ $store->notes }}</p> @endif
    </div>
</div>

<h2>Bevorstehende Turniere</h2>

@if (count($tournaments))
    <table class="data-table striped">
        <tr>
            <th class="sort" data-sort="date">Datum</th>
            <th class="sort" data-sort="type">Turnier</th>
        </tr>
        @foreach ($tournaments as $row)
            <tr data-date="{{ $row->date }}" data-type="{{ $row->type }}">
                <td><a href="{{ route('tournament', [ 'id' => $row->id ]) }}">{{ full_date($row->date) }}</a></td>
                <td><a href="{{ route('tournament', [ 'id' => $row->id ]) }}">{{ __("pokemon.$row->type") }}</a></td>
            </tr>
        @endforeach
    </table>
@else
    <p>Derzeit keine Turniere geplant.</p>
@endif

@endsection

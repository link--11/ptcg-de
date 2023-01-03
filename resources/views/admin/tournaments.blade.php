<x-admin-layout title="Turniere">

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <h2 class="font-bold text-xl p-4">Bevorstehende Turniere</h2>
        <div class="px-5 py-3 text-gray-900">

            <x-primary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add-new-tournament')">Turnier hinzufügen</x-primary-button>

            <x-modal name="add-new-tournament" focusable>
                <form method="post" action="{{ route('admin.tournaments.create') }}" class="p-6 flex flex-col gap-3">
                    @csrf

                    <div>
                        <x-input-label for="store_id" value="Store" />
                        <x-selection id="store_id" name="store_id" class="mt-1 block w-full">
                            @foreach ($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }} {{ $store->city }}</option>
                            @endforeach
                        </x-selection>
                    </div>

                    <div>
                        <x-input-label for="date" value="Datum & Zeit" />
                        <input class="input mt-1 block w-full" type="datetime-local" id="date" name="date">
                    </div>

                    <x-tournament-selection />

                    <div class="mt-2 flex gap-2 justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </div>
                </form>
            </x-modal>

        </div>

        <table class="w-full">
            <tr>
                <th>Datum</th>
                <th>Turniertyp</th>
                <th>Store</th>
            </tr>

            @foreach ($upcoming as $tournament)
                <tr>
                    <td><a href="{{ route('admin.tournament', [ 'id' => $tournament->id ]) }}">{{ $tournament->date }}</a></td>
                    <td><a href="{{ route('admin.tournament', [ 'id' => $tournament->id ]) }}">{{ __("pokemon.$tournament->type") }}</a></td>
                    <td><a href="{{ route('admin.tournament', [ 'id' => $tournament->id ]) }}">{{ $tournament->store->name }} {{ $tournament->store->city }}</a></td>
                </tr>

            @endforeach
        </table>

    </div>

    <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <h2 class="font-bold text-xl p-4">Vergangene Turniere</h2>
        <table class="w-full">
            <tr>
                <th>Datum</th>
                <th>Turniertyp</th>
                <th>Store</th>
            </tr>

            @foreach ($past as $tournament)
                <tr>
                    <td><a href="{{ route('admin.tournament', [ 'id' => $tournament->id ]) }}">{{ $tournament->date }}</a></td>
                    <td><a href="{{ route('admin.tournament', [ 'id' => $tournament->id ]) }}">{{ __("pokemon.$tournament->type") }}</a></td>
                    <td><a href="{{ route('admin.tournament', [ 'id' => $tournament->id ]) }}">{{ $tournament->store->name }} {{ $tournament->store->city }}</a></td>
                </tr>

            @endforeach
        </table>
    </div>

</x-admin-layout>

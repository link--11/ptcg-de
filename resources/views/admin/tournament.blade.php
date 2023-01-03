<x-admin-layout :title="'Turniere > ' . $store->name . ' ' .  __('pokemon.' . $tournament->type)">

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

            <form method="post" action="{{ route('admin.tournament.update', [ 'id' => $tournament->id ]) }}" class="flex flex-col gap-4">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="date" value="Datum & Zeit" />
                    <input value="{{ $tournament->date }}" id="date" name="date" type="datetime-local" class="input mt-1 block w-full">
                </div>

                <div class="flex gap-3">
                    <div class="flex-1">
                        <x-tournament-selection :selected="$tournament->type" />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="format" value="Format" />
                        <x-selection id="format" name="format" class="mt-1 block w-full">
                            <option value=""></option>
                            <option value="standard" {{ $tournament->format === 'standard' ? 'selected' : '' }}>{{ __('pokemon.standard') }}</option>
                            <option value="expanded" {{ $tournament->format === 'expanded' ? 'selected' : '' }}>{{ __('pokemon.expanded') }}</option>
                            <option value="glc" {{ $tournament->format === 'glc' ? 'selected' : '' }}>{{ __('pokemon.glc') }}</option>
                        </x-selection>
                    </div>
                </div>

                <div class="flex gap-3">
                    <div class="flex-1">
                        <x-input-label for="cost" value="Teilnahme in €" />
                        <x-text-input :value="$tournament->cost" id="cost" name="cost" type="number" class="mt-1 block w-full" />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="cap" value="Max. Teilnehmer" />
                        <x-text-input :value="$tournament->cap" id="cap" name="cap" type="number" class="mt-1 block w-full" />
                    </div>
                </div>

                <div>
                    <x-input-label for="notes" value="Anmerkungen" />
                    <textarea id="notes" name="notes" :value="$tournament->notes" rows=4 class="input">{{ $tournament->notes }}</textarea>
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'tournament-updated')
                        <p
                            x-data="{ show: true }"
                            x-show="show"
                            x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600"
                        >{{ __('Saved.') }}</p>
                    @endif
                </div>
            </form>

        </div>
    </div>

    <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <h2 class="font-bold text-xl p-4">Anmeldeliste</h2>
        <table class="w-full">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Player ID</th>
                <th>Division</th>
            </tr>

            @php $i = 1 @endphp
            @foreach ($registrations as $player)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $player->name }}</td>
                    <td>{{ $player->playerid }}</td>
                    <td>{{ $player->division }}</td>
                </tr>

                @php $i++ @endphp
            @endforeach
        </table>
    </div>

    <div class="mt-6 p-6 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            <x-danger-button
                x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-tournament-deletion')"
            >Turnier löschen</x-danger-button>

            <x-modal name="confirm-tournament-deletion" focusable>
                <form method="post" action="{{ route('admin.tournament.delete', [ 'id' => $tournament->id ]) }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900">
                        Bist du sicher dieses Turnier löschen zu wollen?
                    </h2>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ml-3">
                            Turnier löschen
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>

</x-admin-layout>

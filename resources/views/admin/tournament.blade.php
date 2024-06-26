<x-admin-layout :title="'Turniere > ' . $store->name . ' ' .  __('pokemon.' . $tournament->type)">

    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

            <form method="post" action="{{ route('admin.tournament.update', [ 'id' => $tournament->id ]) }}" class="flex flex-col gap-4">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="date" value="Datum & Zeit" />
                    <input value="{{ $tournament->date }}" id="date" name="date" type="datetime-local" step=900 class="block w-full mt-1 input">
                </div>

                <div class="flex gap-3">
                    <div class="flex-1">
                        <x-tournament-selection :selected="$tournament->type" />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="format" value="Format" />
                        <x-selection id="format" name="format" class="block w-full mt-1">
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
                        <x-text-input :value="$tournament->cost" id="cost" name="cost" type="number" step=0.5 class="block w-full mt-1" />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="cap" value="Max. Teilnehmer" />
                        <x-text-input :value="$tournament->cap" id="cap" name="cap" type="number" class="block w-full mt-1" />
                    </div>
                </div>

                <div>
                    <x-input-label for="notes" value="Anmerkungen" />
                    <textarea id="notes" name="notes" :value="$tournament->notes" rows=4 class="input">{{ $tournament->notes }}</textarea>
                </div>

                <label for="enable_registration" class="inline-flex items-center">
                    <input id="enable_registration" type="checkbox" @if ($tournament->registration) checked @endif class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500" name="registration">
                    <span class="ml-2">Anmeldeliste aktivieren</span>
                </label>

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

    @if ($tournament->registration)

        <div class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <h2 class="p-4 text-xl font-bold">Anmeldeliste</h2>
            <table class="w-full">
                <tr>
                    <th>#</th>
                    <th>Vorname</th>
                    <th>Nachname</th>
                    <th>Player ID</th>
                    <th>Geburtsjahr</th>
                    <th>Angemeldet</th>
                </tr>

                @php $i = 1 @endphp
                @foreach ($registrations as $player)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $player->first_name }}</td>
                        <td>{{ $player->last_name }}</td>
                        <td>{{ $player->playerid }}</td>
                        <td>{{ substr($player->birthdate, 0, 4) }}</td>
                        <td>{{ $player->created_at }}</td>
                    </tr>

                    @php $i++ @endphp
                @endforeach
            </table>
        </div>

    @endif

    <div class="p-6 mt-6 bg-white shadow sm:rounded-lg">
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

                    <div class="flex justify-end mt-6">
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

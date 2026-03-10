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
                            <option value="limited" {{ $tournament->format === 'limited' ? 'selected' : '' }}>{{ __('pokemon.limited') }}</option>
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

    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <h2 class="p-4 text-xl font-bold">Turnierergebnisse</h2>

        <form method="POST" action="{{ route('admin.tournament.tdf', [ 'id' => $tournament->id ]) }}" enctype="multipart/form-data" class="px-4 pt-1 pb-3" x-data="{ hasFile: false }">
            @csrf
            <input type="file" name="tdf_file" accept=".tdf" @change="hasFile = $event.target.files.length > 0">
            <button :disabled="!hasFile" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                TDF Datei hochladen
            </button>
        </form>

        @if (count($standings) > 1)
            <table class="w-full">
                <tr>
                    <th></th>
                    <th>#</th>
                    <th>Name</th>
                </tr>

                @php $i = 1 @endphp
                @foreach ($standings as $player)
                    <tr>
                        <td>{{ $player->division }}</td>
                        <td>{{ $player->place }}</td>
                        <td>{{ $player->name }}</td>
                    </tr>

                    @php $i++ @endphp
                @endforeach
            </table>

            <div class="p-4">
                <x-danger-button
                    x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-results-deletion')"
                >Ergebnisse löschen</x-danger-button>
            </div>

            <x-modal name="confirm-results-deletion" focusable>
                <form method="post" action="{{ route('admin.tournament.reset', [ 'id' => $tournament->id ]) }}" class="p-6">
                    @csrf

                    <h2 class="text-lg font-medium text-gray-900">
                        Alle Ergebnisse dieses Turniers löschen?
                    </h2>

                    <div class="flex justify-end mt-6">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ml-3">
                            Ergebnisse löschen
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        @endif
    </div>

    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <h2 class="p-4 text-xl font-bold">Fotos</h2>

        <form method="post" action="{{ route('admin.tournament.photos', [ 'id' => $tournament->id ]) }}" enctype="multipart/form-data" class="px-4 pt-1 pb-3">
            @csrf
            <input type="file" name="files[]" multiple accept=".jpg,.jpeg,.png">
            <x-primary-button>Hochladen</x-primary-button>
        </form>

        @if (count($photos) > 1)
            <script>
                function imageClickHandler () {
                    const route = '{{ route('admin.tournament.photos', [ 'id' => $tournament->id ]) }}'

                    return {
                        async deleteImage (photoId, $el) {
                            if (!window.confirm('Dieses Foto löschen?')) return

                            const res = await fetch(`${route}/${photoId}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })

                            if (res.ok) {
                                $el.remove()
                            }
                        }
                    }
                }
            </script>

            <div class="grid grid-cols-3 md:grid-cols-5" x-data="imageClickHandler()">
                @foreach ($photos as $photo)
                    <img
                        src="/upload/tournaments/{{ $tournament->id }}/{{ $photo->id }}.webp" alt="" class="cursor-pointer"
                        @click="deleteImage('{{ $photo->id }}', $el)"
                    >
                @endforeach
            </div>
        @endif
    </div>

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

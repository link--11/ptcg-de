<x-admin-layout :title="'Stores > ' . $store->name">

    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

            <form method="post" action="{{ route('admin.store.update', [ 'id' => $store->id ]) }}" class="flex flex-col gap-4">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" :value="$store->name" class="block w-full mt-1" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div>
                    <x-input-label for="address" value="Adresse" />
                    <x-text-input :value="$store->address" id="address" name="address" type="text" class="block w-full mt-1" />
                </div>

                <div class="flex gap-3">
                    <div class="flex-1">
                        <x-input-label for="zip_code" value="PLZ" />
                        <x-text-input :value="$store->zip_code" id="zip_code" name="zip_code" type="text" class="block w-full mt-1" />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="city" value="Stadt" />
                        <x-text-input :value="$store->city" id="city" name="city" type="text" class="block w-full mt-1" />
                    </div>
                </div>

                <div class="flex gap-3">
                    <div class="flex-1">
                        <x-input-label for="email" value="Email" />
                        <x-text-input :value="$store->email" id="email" name="email" type="text" class="block w-full mt-1" />
                    </div>
                    <div class="flex-1">
                        <x-input-label for="phone" value="Telefon" />
                        <x-text-input :value="$store->phone" id="phone" name="phone" type="text" class="block w-full mt-1" />
                    </div>
                </div>

                <div>
                    <x-input-label for="website" value="Website" />
                    <x-text-input :value="$store->website" id="website" name="website" type="text" class="block w-full mt-1" />
                </div>

                <hr>

                <div>
                    <x-input-label for="league" value="Liga" />
                    <x-text-input :value="$store->league" id="league" name="league" type="text" class="block w-full mt-1" />
                </div>

                <div>
                    <x-input-label for="notes" value="Zusätzliche Informationen" />
                    <textarea id="notes" name="notes" :value="$store->notes" rows=4 class="mt-1 input">{{ $store->notes }}</textarea>
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'store-updated')
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

    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h2 class="pb-2 text-lg font-bold">Profilbild</h2>

            <form method="post" action="{{ route('admin.store.picture', [ 'id' => $store->id ]) }}" enctype="multipart/form-data">
                @csrf
                <input type="file" name="fileToUpload" id="fileToUpload" accept=".jpg,.jpeg,.png">
                <x-primary-button>Hochladen</x-primary-button>
            </form>

            @if ($store->picture)
                <img class="max-w-lg mt-4" src="/upload/stores/{{ $store->id }}/{{ $store->picture}}" alt="{{ $store->name }}">
            @endif

    </div>
</x-admin-layout>

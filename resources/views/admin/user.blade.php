<x-admin-layout :title="'User > ' . $user->email">

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

            <form method="post" action="{{ route('admin.user.update', [ 'id' => $user->id ]) }}" class="flex flex-col gap-4">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" name="name" type="text" :value="$user->name" class="mt-1 block w-full" required />
                    <x-input-error class="mt-2" :messages="$errors->get('name')" />
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'user-updated')
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

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <h2 class="font-bold text-xl p-4">Storezugriff</h2>
        <div class="px-6 text-gray-900">
            <ul>
                @foreach ($user->stores as $store)
                    <li><a href="/admin/stores/{{ $store->id }}">{{ $store->name }} {{ $store->city }}</a></li>
                @endforeach
            </ul>

        </div>

        <div class="p-6">
            <x-primary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'attach-store')">Store hinzufügen</x-primary-button>

            <x-primary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'detach-store')">Store entfernen</x-primary-button>

            <x-modal name="attach-store" focusable>
                <form method="post" action="{{ route('admin.user.attach', [ 'id' => $user->id ]) }}" class="p-6 flex flex-col gap-3">
                    @csrf

                    <div>
                        <x-input-label for="store_id_1" value="Store" />
                        <x-selection id="store_id_1" name="store_id" class="mt-1 block w-full">
                            @foreach ($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }} {{ $store->city }}</option>
                            @endforeach
                        </x-selection>
                    </div>

                    <div class="mt-2 flex gap-2 justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button>Store hinzufügen</x-primary-button>
                    </div>
                </form>
            </x-modal>

            <x-modal name="detach-store" focusable>
                <form method="post" action="{{ route('admin.user.detach', [ 'id' => $user->id ]) }}" class="p-6 flex flex-col gap-3">
                    @csrf

                    <div>
                        <x-input-label for="store_id_2" value="Store" />
                        <x-selection id="store_id_2" name="store_id" class="mt-1 block w-full">
                            @foreach ($user->stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }} {{ $store->city }}</option>
                            @endforeach
                        </x-selection>
                    </div>

                    <div class="mt-2 flex gap-2 justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-primary-button>Store entfernen</x-primary-button>
                    </div>
                </form>
            </x-modal>
        </div>

    </div>

    {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            >User löschen</x-danger-button>

        </div>
    </div> --}}
</x-admin-layout>

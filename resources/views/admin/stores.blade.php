<x-admin-layout title="Stores">

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            @if ($user->admin)

                <x-primary-button x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'add-new-store')">Store hinzufügen</x-primary-button>

                <x-modal name="add-new-store" focusable>
                    <form method="post" action="{{ route('admin.stores.create') }}" class="p-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="mt-6 flex gap-2 justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>

                            <x-primary-button>{{ __('Save') }}</x-primary-button>
                        </div>
                    </form>
                </x-modal>

            @endif
        </div>

        <table class="w-full">
            <tr>
                <th>Name</th>
                <th>Stadt</th>
            </tr>

            @foreach ($stores as $store)
                <tr>
                    <td><a href="/admin/stores/{{ $store->id }}">{{ $store->name }}</a></td>
                    <td><a href="/admin/stores/{{ $store->id }}">{{ $store->city }}</a></td>
                </tr>

            @endforeach
        </table>

    </div>
</x-admin-layout>

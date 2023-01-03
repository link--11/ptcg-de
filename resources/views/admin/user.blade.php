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

    {{-- <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <x-danger-button
                x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            >User löschen</x-danger-button>

        </div>
    </div> --}}
</x-admin-layout>

<x-admin-layout title="User">

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <x-primary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add-new-user')">User hinzufügen</x-primary-button>

            <x-modal name="add-new-user" focusable>
                <form method="post" action="{{ route('admin.users.create') }}" class="p-6">
                    @csrf

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" required autofocus />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="mt-6 flex gap-2 justify-end">
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
                <th>Email</th>
                <th>Name</th>
            </tr>

            @foreach ($users as $user)
                <tr>
                    <td><a href="/admin/users/{{ $user->id }}">{{ $user->email }}</a></td>
                    <td><a href="/admin/users/{{ $user->id }}">{{ $user->name }}</a></td>
                </tr>

            @endforeach
        </table>

    </div>
</x-admin-layout>

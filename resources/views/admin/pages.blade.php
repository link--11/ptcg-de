<x-admin-layout title="Inhalte">

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-5 text-gray-900">

            <x-primary-button x-data=""
                x-on:click.prevent="$dispatch('open-modal', 'add-new-page')">Inhalt hinzufügen</x-primary-button>

            <x-modal name="add-new-page" focusable>
                <form method="post" action="{{ route('admin.pages.create') }}" class="p-6">
                    @csrf

                    <div>
                        <x-input-label for="title" value="Titel" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" required autofocus />
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
                <th>Titel</th>
                <th>Zuletzt geändert</th>
            </tr>

            @foreach ($pages as $page)
                <tr>
                    <td><a href="/admin/pages/{{ $page->id }}">{{ $page->title }}</a></td>
                    <td><a href="/admin/pages/{{ $page->id }}">{{ $page->updated_at }}</a></td>
                </tr>

            @endforeach
        </table>

    </div>
</x-admin-layout>

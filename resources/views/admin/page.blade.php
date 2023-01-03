<x-admin-layout :title="'Inhalte > ' . $page->title">

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">

            <form method="post" action="{{ route('admin.page.update', [ 'id' => $page->id ]) }}" class="flex flex-col gap-4">
                @csrf
                @method('patch')

                <div>
                    <x-input-label for="title" value="Titel" />
                    <x-text-input id="title" name="title" type="text" :value="$page->title" class="mt-1 block w-full" required />
                </div>

                <div>
                    <x-input-label for="slug" value="Pfad" />
                    <x-text-input id="slug" name="slug" type="text" :value="$page->slug" class="mt-1 block w-full" />
                </div>

                <div>
                    <x-input-label for="content" value="Inhalt" />
                    <textarea id="content" name="content" :value="$page->content" rows=20 class="mt-1 input">{{ $page->content }}</textarea>
                </div>

                <div class="flex items-center gap-4">
                    <x-primary-button>{{ __('Save') }}</x-primary-button>

                    @if (session('status') === 'page-updated')
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

    <div class="p-6 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            <x-danger-button
                x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-page-deletion')"
            >Inhalt löschen</x-danger-button>

            <x-modal name="confirm-page-deletion" focusable>
                <form method="post" action="{{ route('admin.page.delete', [ 'id' => $page->id ]) }}" class="p-6">
                    @csrf
                    @method('delete')

                    <h2 class="text-lg font-medium text-gray-900">
                        Bist du sicher diesen Inhalt löschen zu wollen?
                    </h2>

                    <div class="mt-6 flex justify-end">
                        <x-secondary-button x-on:click="$dispatch('close')">
                            {{ __('Cancel') }}
                        </x-secondary-button>

                        <x-danger-button class="ml-3">
                            Inhalt löschen
                        </x-danger-button>
                    </div>
                </form>
            </x-modal>
        </div>
    </div>

</x-admin-layout>

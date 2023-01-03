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
                    <textarea id="content" name="content" :value="$page->content" rows=20 class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $page->content }}</textarea>
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
</x-admin-layout>

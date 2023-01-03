@props([ 'selected' => 'prerelease' ])

<div>
    <x-input-label for="type" value="Turniertyp" />
    <x-selection id="type" name="type" class="mt-1 block w-full">
        <option value="prerelease" {{ $selected === 'prerelease' ? 'selected' : '' }}>{{ __('pokemon.prerelease') }}</option>
        <option value="challenge" {{ $selected === 'challenge' ? 'selected' : '' }}>{{ __('pokemon.challenge') }}</option>
        <option value="cup" {{ $selected === 'cup' ? 'selected' : '' }}>{{ __('pokemon.cup') }}</option>
    </x-selection>
</div>

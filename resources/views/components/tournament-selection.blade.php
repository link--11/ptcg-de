@props([ 'selected' => 'prerelease' ])

<div>
    <x-input-label for="type" value="Turniertyp" />
    <x-selection id="type" name="type" class="block w-full mt-1">
        <option value="prerelease" {{ $selected === 'prerelease' ? 'selected' : '' }}>{{ __('pokemon.prerelease') }}</option>
        <option value="challenge" {{ $selected === 'challenge' ? 'selected' : '' }}>{{ __('pokemon.challenge') }}</option>
        <option value="cup" {{ $selected === 'cup' ? 'selected' : '' }}>{{ __('pokemon.cup') }}</option>
        <option value="locals" {{ $selected === 'locals' ? 'selected' : '' }}>{{ __('pokemon.locals') }}</option>
        <option value="vg_challenge" {{ $selected === 'vg_challenge' ? 'selected' : '' }}>{{ __('pokemon.vg_challenge') }}</option>
        <option value="vg_cup" {{ $selected === 'vg_cup' ? 'selected' : '' }}>{{ __('pokemon.vg_cup') }}</option>
        <option value="go_challenge" {{ $selected === 'go_challenge' ? 'selected' : '' }}>{{ __('pokemon.go_challenge') }}</option>
        <option value="go_cup" {{ $selected === 'go_cup' ? 'selected' : '' }}>{{ __('pokemon.go_cup') }}</option>
    </x-selection>
</div>

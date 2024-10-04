<div>
    @if ($variations->count() > 0)
        <select wire:model="product_variation" class="flex appearance-none items-center text-sm text-heading transition duration-300 ease-in-out focus:outline-0 focus:ring-0 border border-border-base rounded focus:border-accent h-12">
            @foreach ($variations as $variation)
                <option value="">{{ __trans('choose_variant') }}</option>
                <option value="{{ $variation->id }}">{{ $variation->name }}</option>
            @endforeach
        </select>
    @endif
</div>

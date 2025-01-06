<div>
    {{ __userCurrencySymbol() }} {{ $price }}
    @if($price != $original_price)
    <del class="font-medium text-gray-500 text-sm mr-2">
        {{ $original_price }}
    </del>
    @endif
</div>

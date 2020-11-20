@props([
    'id',
    'options' => null,
    'placeholder' => false,
])
<div class="col-span-6 sm:col-span-3">
    <select id="{{ $id }}" {{ $attributes['wire:model'] }} {{ $attributes->merge(['class' => 'mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm']) }}>
        @if ($placeholder) <option value="" disabled selected>{{ $placeholder }}</option> @endif
        @if ($options && is_array($options))
            @foreach($options as $option)
                <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
            @endforeach
        @else
            {{ $options }}
        @endif
    </select>
</div>

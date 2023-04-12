@props(['name'])

<x-form.field>
    <x-form.label name="{{ $name }}" />

    <textarea
            class="form-control"
            name="{{ $name }}"
            id="{{ $name }}"
            {{ $attributes }}
    >{{ $slot ?? old($name) }}</textarea>

    <x-form.error name="{{ $name }}" />
</x-form.field>
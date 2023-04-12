@props(['name'])

<x-form.field>
    <x-form.label name="{{ $name }}"/>

    <input class="form-control"
           name="{{ $name }}"
           id="{{ $name }}"
           placeholder="Enter the {{ $name }}"
           {{ $attributes(['value' => old($name)])}}
    >

    <x-form.error name="{{ $name }}"/>
</x-form.field>
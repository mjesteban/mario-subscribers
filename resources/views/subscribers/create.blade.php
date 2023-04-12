<x-layout>
    <x-banner name="Add Subscriber"/>
    <x-flash />
    <form method="POST" action="{{ route('subscribers.store') }}">
{{--        normally I'd set type="email" required, but as part of the requirement, validation is through the API.--}}
        <x-form.input name="email" />
        <x-form.input name="name" />
        <x-form.input name="last_name" />
        <x-form.input name="country" />
        <x-form.button>Submit</x-form.button>
    </form>
</x-layout>
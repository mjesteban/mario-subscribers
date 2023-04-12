<x-layout>
    <x-banner name="Edit Subscriber"/>
    <x-flash />
    <form method="POST" action="/subscribers/{{ $subscriber['id'] }}">
        @method('PUT')
        <x-form.input name="email" :value="old('email', $subscriber['email'])" readonly=""/>
        <x-form.input name="name" :value="old('name', $subscriber['fields']['name'])"/>
        <x-form.input name="last_name" :value="old('last_name', $subscriber['fields']['last_name'])"/>
        <x-form.input name="country" :value="old('country', $subscriber['fields']['country'])"/>
        <x-form.button>Submit</x-form.button>
    </form>
</x-layout>
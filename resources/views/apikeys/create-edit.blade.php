<x-layout>
    <x-banner name="MailerLite API key"/>
    <x-flash />
    <form method="POST" action="{{ route('api-keys.store') }}">
        <x-form.textarea name="key" required rows="12"/>
        <x-form.button>Submit</x-form.button>
    </form>
</x-layout>
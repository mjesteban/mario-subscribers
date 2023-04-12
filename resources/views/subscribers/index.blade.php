<x-layout>
    <x-banner name="List of Subscribers"/>
    <x-flash />
    <table id="subscribers" class="display" style="width:100%">
        <thead>
            @include ('subscribers._thead')
        </thead>
        <tfoot>
            @include ('subscribers._thead')
        </tfoot>
    </table>
    <script src="{{ asset('js/app.js') }}"></script>
</x-layout>
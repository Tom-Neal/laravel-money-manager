@if(auth()->user())
    <script src="{{ asset('js/bootstrap-5.0.0/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/flatpickr-4.6.3/flatpickr.js') }}"></script>
    <script src="{{ asset('js/fontawesome-5.14.0/js/all.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/filepond-4.27.0/filepond.js') }}"></script>
    <script src="{{ asset('js/filepond-4.27.0/filepond-plugin-file-validate-size.js') }}"></script>
    <script src="{{ asset(mix('js/app.js')) }}"></script>
    <x-notification></x-notification>
    @stack('js')
@endif

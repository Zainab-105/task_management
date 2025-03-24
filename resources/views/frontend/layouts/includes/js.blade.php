<script src="{{ asset('assets/frontend/js/jquery-3.7.0.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/slick.js') }}"></script>
<script src="{{ asset('assets/frontend/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/custom-script.js') }}"></script>
<script src="{{ asset('assets/frontend/js/google-translate.js') }}"></script>
<script>
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif
    @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
    @endif
    @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
    @endif
    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif

    
</script>
{{ Session::forget('success') }} {{ Session::forget('info') }} {{ Session::forget('warning') }} {{ Session::forget('error') }}

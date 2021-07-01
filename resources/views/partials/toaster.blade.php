@if(session('success'))
<script>
    toastr.success("{{ Session::get('success') }}");
</script>
@endif

@if(session('info'))
<script>
    toastr.info("{{ Session::get('info') }}");
</script>
@endif

@if(session('warning'))
<script>
    toastr.warning("{{ Session::get('warning') }}");
</script>
@endif

@if(session('error'))
<script>
    toastr.error("{{ Session::get('error') }}");
</script>
@endif

@if($errors->any())
    @foreach ($errors->all() as $error)
        <script>
            toastr.error("{{ $error }}");
        </script>
    @endforeach
@endif

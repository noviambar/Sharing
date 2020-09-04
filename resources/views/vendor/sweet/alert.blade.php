@if (Session::has('sweet_alert.alert'))
    <script>
        swal("Update!", "File has been Updated", "success");
    </script>
@endif

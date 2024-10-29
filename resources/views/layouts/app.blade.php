<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@lang('panel.site_title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon_techwiz.ico') }}">
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    {{-- <link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/dropzone/min/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- constructor --}}
    {{-- <link href="{{asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/libs/spectrum-colorpicker2/spectrum.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/libs/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.css')}}">
    {{-- constructor end --}}


   
</head>
<body>
    
    @yield('styles')

    <style>
        .wizard>.actions a, .wizard>.actions a:active, .wizard>.actions a:hover {

    display: none !important;
}
    </style>
</head>
<body style="overflow-x: scroll">
    <div class="account-pages ">
        <div class="px-2 mx-2 my-5 pt-sm-5">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    
            <div class="row px-2 justify-content-center">
                @yield('content')
            </div>
        </div>
    </div>

  {{-- constructor --}}
  {{-- <script src="{{asset('assets/libs/select2/js/select2.min.js')}}"></script> --}}
  <script src="{{asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
  <script src="{{asset('assets/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
  {{-- constructor end--}}

  <!-- JAVASCRIPT -->

  <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
  {{-- <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script> --}}
  {{-- <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script> --}}
  <!-- Select2 -->
  {{-- <script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script> --}}
  <!-- Required datatable js -->
  <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
  <!-- Buttons examples -->
  <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('assets/libs/jszip/jszip.min.js') }}"></script>
  <script src="{{ asset('assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
  <script src="{{ asset('assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

  <!-- Responsive examples -->
  <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>

  <!-- Datatable init js -->
  <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
  <!-- form advanced init -->
  <script src="{{ asset('assets/js/pages/form-advanced.init.js') }}"></script>
  <script src="{{ asset('assets/js/pages/job-list.init.js') }}"></script>
  <script src="{{ asset('assets/js/pages/job-list.init.js') }}"></script>

  <!-- App js -->
  <script src="{{ asset('assets/js/app.js') }}"></script>

  <!-- bootstrap datepicker -->
  <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

  <!-- dropzone plugin -->
  <script src="{{ asset('assets/libs/dropzone/min/dropzone.min.js') }}"></script>    


  {{-- <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>  --}}

  <script>
      $("#reset_form").on('click', function() {
          $('form :input').val('');
          $("form :input[class*='like-operator']").val('like');
          $("div[id*='_pair']").hide();
      });
  </script>

  <script>
      function togglePassword(inputId, toggleIconId) {
          var passwordInput = document.getElementById(inputId);
          var toggleIcon = document.getElementById(toggleIconId);

          if (passwordInput.type === "password") {
              passwordInput.type = "text";
              toggleIcon.classList.remove("mdi-eye-outline");
              toggleIcon.classList.add("mdi-eye-off-outline");
          } else {
              passwordInput.type = "password";
              toggleIcon.classList.remove("mdi-eye-off-outline");
              toggleIcon.classList.add("mdi-eye-outline");
          }
      }
  </script>
  @if (session('_message'))
      <script>
          Swal.fire({
              position: 'top-end',
              icon: "{{ session('_type') }}",
              title: "{{ session('_message') }}",
              showConfirmButton: false,
              timer: {{ session('_timer') ?? 5000 }}
          });
      </script>
      @php(message_clear())
  @endif
  @yield('scripts')

</html>

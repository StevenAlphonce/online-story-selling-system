<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Online Story Selling System</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    {{-- <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">


    <!-- Vendor CSS Files -->
    <link href="{{ url('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ url('vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ url('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ url('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ url('vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ url('vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ url('css/style.css') }}" rel="stylesheet">
    <link href="{{ url('css/welcome.css') }}" rel="stylesheet">
    <link href="{{ url('css/story.css') }}" rel="stylesheet">
    @stack('style')
</head>

<body>

    @yield('content')

    <a href="#" style="background-color: var(--green)"
        class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ url('vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ url('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ url('vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ url('vendor/quill/quill.min.js') }}"></script>
    <script src="{{ url('vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ url('vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ url('vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ url('js/main.js') }}"></script>

    <!--Jquery 3.6.0 for auto events on the website -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script type="text/javascript">
        $(document).ready(function(e) {

            $('#image').change(function() {

                let reader = new FileReader();

                reader.onload = (e) => {

                    $('#image-preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(this.files[0]);

            });

        });
    </script>
    @stack('scripts')
</body>

</html>

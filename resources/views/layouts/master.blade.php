<!doctype html>
<html class="no-js " lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="description" content="LIMO APP.">
{{--    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}">--}}

    <title>LIMO APP</title>
    <!-- Favicon-->
    <link rel="icon" href="{{asset('assets/images/favicon.ico')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}">
    <link href="{{asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    @stack('styles')
    <!-- Custom Css -->
    <link rel="stylesheet" href="{{asset('assets/css/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/color_skins.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
</head>
<body class="theme-black">
<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
            <div class="m-t-30"><img src="{{asset('assets/images/logo.png')}}" width="165" height="76" alt="LIMO APP"></div>
        <p>Please wait...</p>
    </div>
</div>
<div class="overlay"></div><!-- Overlay For Sidebars -->

<!-- Left Sidebar -->
@include('layouts.sidebar')

<!-- Main Content -->
<section class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-12">
                @yield('content')
            </div>
        </div>
    </div>
</section>
<!-- Jquery Core Js -->
<script src="{{asset('assets/bundles/libscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->
<script src="{{asset('assets/bundles/vendorscripts.bundle.js')}}"></script> <!-- Lib Scripts Plugin Js -->

<script src="{{asset('assets/bundles/mainscripts.bundle.js')}}"></script>
<script src="{{asset('assets/plugins/tinymce/tinymce.min.js')}}" referrerpolicy="origin"></script>
<script src="{{asset('assets/plugins/select2/js/select2.js')}}" referrerpolicy="origin"></script>
<script src="{{asset('assets/js/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>
<script>
    @if(session()->has("success"))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
    toastr.success(`{{ session('success') }}`);
    @elseif(session()->has("danger"))
        toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
    toastr.error(`{{ session('danger') }}`);
    @endif
    $(document).ready(function() {
        $('.select2').select2({
            placeholder:"Choose..."
        });
        $(".select2-autocomplete").select2({
            placeholder:"Choose...",
            tags:true,
            createTag: function (params) {
                var term = $.trim(params.term);

                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term,
                    newTag: true // add additional parameters
                }
            }
        });

    });
</script>
</script>
@stack('scripts')
</body>
</html>

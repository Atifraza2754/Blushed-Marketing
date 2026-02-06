<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Blushed</title>
    <link rel="icon" type="image/x-icon" href="{{ URL::to('/assets/images/favicons/favicon.png') }}" />

    {{-- Bootstrap5 --}}
    <link rel="stylesheet" href="{{ URL::to('assets/bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {{-- manrop fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">

        {{-- evo calendar --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/css/evo-calendar.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
            integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="https://unpkg.com/tippy.js@6.3.3/dist/tippy.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">


    {{-- css --}}
    <link rel="stylesheet" href="{{ URL::to('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::to('assets/css/select2.min.css') }}">

    <style>
        .selected-tab{
            border-bottom: 2px solid #CD7FAF !important;
        }
        a {
            text-decoration: none;
        }
    </style>
  <style>
    .swiper-slide {
        max-width: 25%;
        /* padding: 15px; */
    }
    .card {
        width: 100%;
    }
</style>
    {{-- includes page specific styles --}}
    @yield('customStyles')
</head>

<body>
    <div class="dashboard-frame">

        {{-- include siderbar --}}
        @include('layouts.sidebar')

        <main class="main-area">

            {{-- include header --}}
            @include('layouts.header')

            <div class="main-content">

                {{-- yield content section --}}
                @yield('content')

            </div>
        </main>
    </div>
    <div class="overlay"></div>

    {{-- Jquery --}}
    <script src="{{ URL::to('/assets/Js/jquery.js') }}"></script>
    {{-- Popper --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"
        integrity="sha512-nnzkI2u2Dy6HMnzMIkh7CPd1KX445z38XIu4jG1jGw7x5tSL3VBjE44dY4ihMU1ijAQV930SPM12cCFrB18sVw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- bootstrap5 --}}
    <script src="{{ URL::to('/assets/bootstrap5/js/bootstrap.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>
    <script src="{{ URL::to('/assets/Js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    {{-- <script src="{{ URL::to('/assets/Js/calendar.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/js/evo-calendar.min.js"></script>
    {{-- includes page specific scripts --}}
    <script src="{{ URL::to('/user-assets/Js/sweetalert.js') }}"></script>
    <script src="{{ URL::to('/assets/Js/select2.full.min.js') }}"></script>

    {{-- <script src="{{ URL::to('/user-assets/Js/select2.full.min.js') }}"></script> --}}
 <script>
    $(document).ready(function () {
        $('.select2').select2({

        });

        $('.dselect2').select2({
        dropdownParent: $('#exampleModal')
    });
    });

    </script>
    @yield('customScripts')

</body>

</html>

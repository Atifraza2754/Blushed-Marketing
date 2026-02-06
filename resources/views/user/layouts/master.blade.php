<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap5 -->
    <link rel="stylesheet" href="{{ URL::to('/user-assets/bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- manrop fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!--evo calendar  -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/css/evo-calendar.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- datatable --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    {{-- css --}}
    <link rel="stylesheet" href="{{ URL::to('/user-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ URL::to('/user-assets/css/intlTelInput.css') }}">

    <title>@yield('title') - User Panel | Blushed</title>

    <style>
        .selected-tab{
            border-bottom: 2px solid #CD7FAF !important;
        }
        a {
            text-decoration: none;
        }
        .calendar-sidebar>span#sidebarToggler,.calendar-sidebar > .calendar-year{
            background: #CD7FAF !important;
        }
        th[colspan="7"]{
            color : #C92085 !important;
        }
    </style>

    {{-- yield page specific styles --}}
    @yield('customStyles')
</head>

<body>
    <div class="dashboard-frame">

        {{-- include sidebar --}}
        @include('user.layouts.sidebar')


        <main class="main-area">
            {{-- include header --}}
            @include('user.layouts.header')

            {{-- yield content --}}
            @yield('content')
        </main>
    </div>

    <div class="overlay"></div>

    <!-- Jquery -->
    <script src="{{ URL::to('/user-assets/Js/jquery.js') }}"></script>

    <!-- Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"
        integrity="sha512-nnzkI2u2Dy6HMnzMIkh7CPd1KX445z38XIu4jG1jGw7x5tSL3VBjE44dY4ihMU1ijAQV930SPM12cCFrB18sVw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- bootstrap5 --}}
    <script src="{{ URL::to('/user-assets/bootstrap5/js/bootstrap.min.js') }}"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>

    <script src="{{ URL::to('/user-assets/Js/app.js') }}"></script>
    <script src="{{ URL::to('/user-assets/Js/sweetalert.js') }}"></script>
    {{-- <script src="{{ URL::to('/user-assets/Js/calendar.js') }}"></script> --}}

    {{-- <!-- select 2 --> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- datatable --}}
    <script src="https://cdn.sheetjs.com/xlsx-0.20.0/package/dist/xlsx.full.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/evo-calendar@1.1.3/evo-calendar/js/evo-calendar.min.js"></script>
    <script src="{{ URL::to('/user-assets/Js/webcam.js') }}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script> --}}

    <script>
        function settings(evt, cityName) {
            // Declare all variables
            var i, tabcontent, tablinks;

            // Get all elements with class="tabcontent" and hide them
            tabcontent = document.getElementsByClassName("tabcontent-side");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Get all elements with class="tablinks" and remove the class "active"
            tablinks = document.getElementsByClassName("tab-li");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active-side2", "");
            }

            // Show the current tab, and add an "active" class to the button that opened the tab
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active-side2";
        }
        document.getElementById("defaultOpen-side").click();
    </script>

    <script src="{{ URL::to('/user-assets/Js/intlTelInput.js') }}"></script>
    <script>
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
            event.stopPropagation();
        };
    </script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            utilsScript: "user-assets/Js/utils.js",
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.togglePassword').click(function(e) {
                const $password = $(this).siblings('.id_password');
                const type = $password.attr('type') === 'password' ? 'text' : 'password';
                $password.attr('type', type);
                $(this).toggleClass('bi-eye-slash-fill');
            });
        });
    </script>
    <!-- select2 -->
    <script>
        $(document).ready(function() {
            $('.js-example-basic-multiple').select2({
                placeholder: 'Select Role',
                allowClear: true

            });
        });
    </script>
    <!-- image upload1 -->
    <script>
        var loadFile1 = function(event) {
            var image = document.getElementById('output1');
            image.src = URL.createObjectURL(event.target.files[0]);
            $(".remove-picture1").removeClass("d-none")
            event.stopPropagation();
        };

        $(".remove-picture1").click(function() {
            $("#output1").attr('src', 'user-assets/images/Asset 2.png')
            $(this).addClass("d-none")
        })
    </script>

    <!-- image upload2 -->
    <script>
        var loadFile2 = function(event) {
            var image = document.getElementById('output2');
            image.src = URL.createObjectURL(event.target.files[0]);
            $(".remove-picture2").removeClass("d-none")
            event.stopPropagation();
        };

        $(".remove-picture2").click(function() {
            $("#output2").attr('src', 'user-assets/images/Asset 2.png')
            $(this).addClass("d-none")
        })
    </script>

    <!-- image upload3 -->
    <script>
        var loadFile3 = function(event) {
            var image = document.getElementById('output3');
            image.src = URL.createObjectURL(event.target.files[0]);
            $(".remove-picture3").removeClass("d-none")
            event.stopPropagation();
        };

        $(".remove-picture3").click(function() {
            $("#output3").attr('src', 'user-assets/images/Asset 2.png')
            $(this).addClass("d-none")
        })
    </script>

    <!-- image upload4-->
    <script>
        var loadFile4 = function(event) {
            var image = document.getElementById('output4');
            image.src = URL.createObjectURL(event.target.files[0]);
            $(".remove-picture4").removeClass("d-none")
            event.stopPropagation();
        };

        $(".remove-picture4").click(function() {
            $("#output4").attr('src', 'user-assets/images/Asset 2.png')
            $(this).addClass("d-none")
        })
    </script>

    {{-- yield page specific scripts --}}
    @yield('customScripts')
</body>

</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Blushed</title>
    <link rel="icon" type="image/x-icon" href="{{ URL::to('/assets/images/favicons/favicon.png') }}" />

    {{-- Bootstrap5 --}}
    <link rel="stylesheet" href="{{ URL::to('assets/bootstrap5/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">

    {{-- manrop fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    {{-- css --}}
    <link rel="stylesheet" href="{{ URL::to('assets/css/style.css') }}">


    {{-- include page specific styles --}}
    @yield('customStyles')
</head>

<body>
    <div class="sign__frame">

        <div class="sign__frame-left">
            <img src="{{ URL::to('/assets/images/blush.jpg') }}" alt="">
            {{-- <img src="{{ URL::to('/assets/images/sign-img.png') }}" alt=""> --}}
            <div class="sign__frame-left--logo">
                {{-- <h1>Blushed</h1> --}}
            </div>
        </div>

        {{-- yield page content --}}
        @yield('content')

    </div>

    {{-- Jquery --}}
    <script src="{{ URL::to('/assets/Js/jquery.js') }}"></script>
    {{-- Popper --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js') }}"
        integrity="sha512-nnzkI2u2Dy6HMnzMIkh7CPd1KX445z38XIu4jG1jGw7x5tSL3VBjE44dY4ihMU1ijAQV930SPM12cCFrB18sVw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- bootstrap5 --}}
    <script src="{{ URL::to('/assets/bootstrap5/js/bootstrap.min.js') }}"></script>
    <script>
        // Login
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#id_password');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>

    {{-- include page specific scripts --}}
    @yield('customScripts')
</body>
</html>

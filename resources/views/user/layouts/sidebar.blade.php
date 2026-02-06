<aside class="sidebar">
    <div class="side-logo">
        <a href="{{URL::to('/user/dashboard')}}">
        <img src="{{ URL::to('/assets/images/logo-black.png') }}" alt="" class="">

            {{-- <img src="{{ URL::to('/assets/images/blushed.png') }}" alt="Logo" class=""> --}}
        </a>
    </div>

    <div class="side-nav">
        <ul class="ms-0 ps-0">
            <li class="{{ $module == 'dashboard' ? 'active-side' : '' }}">
                <a href="{{ URL::to('/user/dashboard') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 13H11V3H3V13ZM3 21H11V15H3V21ZM13 21H21V11H13V21ZM13 3V9H21V3H13Z" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="{{ $module == 'recaps' ? 'active-side' : '' }}">
                <a href="{{ URL::to('/user/recaps') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.65 6.35C16.2 4.9 14.21 4 12 4C7.58001 4 4.01001 7.58 4.01001 12C4.01001 16.42 7.58001 20 12 20C15.73 20 18.84 17.45 19.73 14H17.65C16.83 16.33 14.61 18 12 18C8.69001 18 6.00001 15.31 6.00001 12C6.00001 8.69 8.69001 6 12 6C13.66 6 15.14 6.69 16.22 7.78L13 11H20V4L17.65 6.35Z" />
                    </svg>
                    Recaps
                </a>
            </li>
            <li class="{{ $module == 'team-recap' ? 'active-side' : '' }}">
                <a href="{{ URL::to('user/team-recap') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M16.5 12C17.88 12 18.99 10.88 18.99 9.5C18.99 8.12 17.88 7 16.5 7C15.12 7 14 8.12 14 9.5C14 10.88 15.12 12 16.5 12ZM9 11C10.66 11 11.99 9.66 11.99 8C11.99 6.34 10.66 5 9 5C7.34 5 6 6.34 6 8C6 9.66 7.34 11 9 11ZM16.5 14C14.67 14 11 14.92 11 16.75V19H22V16.75C22 14.92 18.33 14 16.5 14ZM9 13C6.67 13 2 14.17 2 16.5V19H9V16.75C9 15.9 9.33 14.41 11.37 13.28C10.5 13.1 9.66 13 9 13Z" />
                    </svg>
                    Team Recap
                </a>
            </li>
            <li class="{{ $module == 'payments' ? 'active-side' : '' }}">
                <a href="{{ URL::to('/user/payments') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M20 4H4C2.89 4 2.01 4.89 2.01 6L2 18C2 19.11 2.89 20 4 20H20C21.11 20 22 19.11 22 18V6C22 4.89 21.11 4 20 4ZM20 18H4V12H20V18ZM20 8H4V6H20V8Z" />
                    </svg>
                    Pay
                </a>
            </li>

            <li class="{{ $module == 'shifts' ? 'active-side' : '' }}">
                <a href="{{ URL::to('/user/shifts') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M11.99 2C6.47 2 2 6.48 2 12C2 17.52 6.47 22 11.99 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 11.99 2ZM12 20C7.58 20 4 16.42 4 12C4 7.58 7.58 4 12 4C16.42 4 20 7.58 20 12C20 16.42 16.42 20 12 20Z" />
                        <path d="M12.5 7H11V13L16.25 16.15L17 14.92L12.5 12.25V7Z" />
                    </svg>
                    Shifts/Schedule
                </a>
            </li>
             @php
                $form=null;
                // dd(Auth::user()->form_type);
                    if(Auth::user()->is_w9){
                        $form ='w9form';
                    }
                    if(Auth::user()->is_ic){
                        $form ='ic-aggrement';
                    }if(Auth::user()->is_pr){
                        $form ='payroll';
                    }
                @endphp
            @if(isset($form) && $form != null)
            <li class="{{ $module == 'onboarding' ? 'active-side' : '' }}">

                <a href="{{ URL::to('/user/onboarding/'.$form) }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M19 3H14.82C14.4 1.84 13.3 1 12 1C10.7 1 9.6 1.84 9.18 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM12 3C12.55 3 13 3.45 13 4C13 4.55 12.55 5 12 5C11.45 5 11 4.55 11 4C11 3.45 11.45 3 12 3ZM12 7C13.66 7 15 8.34 15 10C15 11.66 13.66 13 12 13C10.34 13 9 11.66 9 10C9 8.34 10.34 7 12 7ZM18 19H6V17.6C6 15.6 10 14.5 12 14.5C14 14.5 18 15.6 18 17.6V19Z" />
                    </svg>
                    Onboarding
                </a>
            </li>
            @endif
            <li class="{{ $module == 'learning-center' ? 'active-side' : '' }}">
                <a href="{{ URL::to('/user/learning-center/trainings') }}">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M15.5 13.5C15.5 15.5 13 17 13 18.5H11C11 17 8.5 15.5 8.5 13.5C8.5 11.57 10.07 10 12 10C13.93 10 15.5 11.57 15.5 13.5ZM13 19.5H11V21H13V19.5ZM19 13C19 14.68 18.41 16.21 17.42 17.42L18.84 18.84C20.18 17.27 21 15.23 21 13C21 10.26 19.77 7.81 17.84 6.16L16.42 7.58C17.99 8.86 19 10.82 19 13ZM16 5L12 1V4C7.03 4 3 8.03 3 13C3 15.23 3.82 17.27 5.16 18.84L6.58 17.42C5.59 16.21 5 14.68 5 13C5 9.14 8.14 6 12 6V9L16 5Z" />
                    </svg>
                    Learning Center
                </a>
            </li>
            <li class="{{ $module == 'quizzes' ? 'active-side' : '' }}">
                <a href="{{ URL::to('/user/quizzes') }}">
                    <svg width="25" height="24" viewBox="0 0 25 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M21.3223 6H19.3223V15H6.32227V17C6.32227 17.55 6.77227 18 7.32227 18H18.3223L22.3223 22V7C22.3223 6.45 21.8723 6 21.3223 6ZM17.3223 12V3C17.3223 2.45 16.8723 2 16.3223 2H3.32227C2.77227 2 2.32227 2.45 2.32227 3V17L6.32227 13H16.3223C16.8723 13 17.3223 12.55 17.3223 12Z" />
                    </svg>
                    Quiz & Info
                </a>
            </li>
            <li class="{{ $module == 'clock-time' ? 'active-side' : '' }}">
                <a href="{{ URL::to('/user/clock-time') }}">
                    <svg width="24" height="24" viewBox="0 0 25 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13.5117 3C8.54172 3 4.51172 7.03 4.51172 12H1.51172L5.40172 15.89L5.47172 16.03L9.51172 12H6.51172C6.51172 8.13 9.64172 5 13.5117 5C17.3817 5 20.5117 8.13 20.5117 12C20.5117 15.87 17.3817 19 13.5117 19C11.5817 19 9.83172 18.21 8.57172 16.94L7.15172 18.36C8.78172 19.99 11.0217 21 13.5117 21C18.4817 21 22.5117 16.97 22.5117 12C22.5117 7.03 18.4817 3 13.5117 3ZM12.5117 8V13L16.7917 15.54L17.5117 14.33L14.0117 12.25V8H12.5117Z" />
                    </svg>
                    Check in
                </a>
            </li>
            <li class="{{ $module == 'coverage' ? 'active-side' : '' }}">
                <a href="{{ URL::to('/user/shifts/coverage') }}">
                    <svg width="24" height="24" viewBox="0 0 25 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M13.5117 3C8.54172 3 4.51172 7.03 4.51172 12H1.51172L5.40172 15.89L5.47172 16.03L9.51172 12H6.51172C6.51172 8.13 9.64172 5 13.5117 5C17.3817 5 20.5117 8.13 20.5117 12C20.5117 15.87 17.3817 19 13.5117 19C11.5817 19 9.83172 18.21 8.57172 16.94L7.15172 18.36C8.78172 19.99 11.0217 21 13.5117 21C18.4817 21 22.5117 16.97 22.5117 12C22.5117 7.03 18.4817 3 13.5117 3ZM12.5117 8V13L16.7917 15.54L17.5117 14.33L14.0117 12.25V8H12.5117Z" />
                    </svg>
                    Coverage
                </a>
            </li>
        </ul>
    </div>
</aside>

@extends('layouts.master', ['module' => 'shifts'])

@section('title')
    Shifts
@endsection

@section('customStyles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <form action="{{ URL::to('/job/import') }}" method="post" enctype="multipart/form-data">
                @csrf

                <input type="file" name="jobs">
                <button class="btn btn-primary" type="submit">Upload</button>
            </form>
        </div>
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="d-flex justify-content-between flex-lg-row flex-column ">
                <h1 class="f-32 w-600 text-bl">
                    Shifts/Schedule
                </h1>
                <div
                    class="d-flex align-items-center my-lg-0 my-3 justify-content-lg-end justify-content-around flex-md-row flex-column ">
                    <div class="d-flex w-100">
                        <div class="dropdown ">
                            <button class=" dropdown-toggle align-dropdown" type="button" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                <!-- id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" -->
                                <svg width="25" height="25" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2.5 10.8333H4.16667V9.16668H2.5V10.8333ZM2.5 14.1667H4.16667V12.5H2.5V14.1667ZM2.5 7.50001H4.16667V5.83334H2.5V7.50001ZM5.83333 10.8333H17.5V9.16668H5.83333V10.8333ZM5.83333 14.1667H17.5V12.5H5.83333V14.1667ZM5.83333 5.83334V7.50001H17.5V5.83334H5.83333Z"
                                        fill="#84818A" />
                                </svg>

                            </button>

                        </div>

                        <div class="table-search">
                            <input type="text" placeholder="Search Payroll" class="">
                            <i class="bi-search"></i>

                        </div>


                    </div>
                    <div class="d-flex mt-md-0 mt-3 justify-content-end align-items-center w-100">
                        <button class=" download-dropdown shift-upload" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path
                                    d="M15.8337 12.5H12.5003V17.5H7.50033V12.5H4.16699L10.0003 6.66667L15.8337 12.5ZM4.16699 5V3.33333H15.8337V5H4.16699Z"
                                    fill="white" />
                            </svg>
                            <input type="file">
                        </button>
                        <button id="publish-btn" class="refresh-btn w-auto border-0 f-14 px-3  " type="button" disabled
                            data-bs-toggle="modal" data-bs-target="#publishModal" style="font-weight: 600;">
                            Publish (<span id="publish-count">0</span>)
                        </button>

                        <div class="dropdown ms-1 ">
                            <button class="  p-0 border-0 bg-transparent" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M15 10C16.375 10 17.5 8.875 17.5 7.5C17.5 6.125 16.375 5 15 5C13.625 5 12.5 6.125 12.5 7.5C12.5 8.875 13.625 10 15 10ZM15 12.5C13.625 12.5 12.5 13.625 12.5 15C12.5 16.375 13.625 17.5 15 17.5C16.375 17.5 17.5 16.375 17.5 15C17.5 13.625 16.375 12.5 15 12.5ZM15 20C13.625 20 12.5 21.125 12.5 22.5C12.5 23.875 13.625 25 15 25C16.375 25 17.5 23.875 17.5 22.5C17.5 21.125 16.375 20 15 20Z"
                                        fill="#84818A" />
                                </svg>


                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                                <li class="text-center"><a class="dropdown-item" href="sign-in.html">
                                        Menu Option</a>
                                </li>
                                <li class="text-center"><a class="dropdown-item" href="sign-in.html">
                                        Menu Option</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- cards -->
        <div class="blushed-card"
            style="border-radius: 4px;
    border: 1px solid var(--fill-dark-dark-5, #EBEAED);
    background: var(--fill-white-white, #FFF);">


            <h1 class="f-18 w-600">
                Available for shifts
            </h1>


            <div class="available-shifts ">
                <div class=" shift-card ms-2">
                    <div class="d-flex align-items-center ">
                        <img src="assets/images/User.png" alt="">
                        <div class="ms-3">
                            <h3 class="f-14 w-600 text-dark mb-0 pb-0">Maria Roselia</h3>
                            <p class="mb-0 pb-0 f-12 w-500 text-gray">0.00 Hrs / $0.00</p>
                        </div>
                    </div>
                </div>

                <div class=" shift-card ms-2">
                    <div class="d-flex align-items-center ">
                        <img src="assets/images/User.png" alt="">
                        <div class="ms-3">
                            <h3 class="f-14 w-600 text-dark mb-0 pb-0">Maria Roselia</h3>
                            <p class="mb-0 pb-0 f-12 w-500 text-gray">0.00 Hrs / $0.00</p>
                        </div>
                    </div>
                </div>

                <div class="shift-card ms-2">
                    <div class="d-flex align-items-center ">
                        <img src="assets/images/User.png" alt="">
                        <div class="ms-3">
                            <h3 class="f-14 w-600 text-dark mb-0 pb-0">Maria Roselia</h3>
                            <p class="mb-0 pb-0 f-12 w-500 text-gray">0.00 Hrs / $0.00</p>
                        </div>
                    </div>
                </div>


                <div class=" shift-card ms-2">
                    <div class="d-flex align-items-center ">
                        <img src="assets/images/User.png" alt="">
                        <div class="ms-3">
                            <h3 class="f-14 w-600 text-dark mb-0 pb-0">Maria Roselia</h3>
                            <p class="mb-0 pb-0 f-12 w-500 text-gray">0.00 Hrs / $0.00</p>
                        </div>
                    </div>
                </div>

                <div class="shift-card ms-2">
                    <div class="d-flex align-items-center ">
                        <img src="assets/images/User.png" alt="">
                        <div class="ms-3">
                            <h3 class="f-14 w-600 text-dark mb-0 pb-0">Maria Roselia</h3>
                            <p class="mb-0 pb-0 f-12 w-500 text-gray">0.00 Hrs / $0.00</p>
                        </div>
                    </div>
                </div>

                <div class=" shift-card ms-2">
                    <div class="d-flex align-items-center ">
                        <img src="assets/images/User.png" alt="">
                        <div class="ms-3">
                            <h3 class="f-14 w-600 text-dark mb-0 pb-0">Maria Roselia</h3>
                            <p class="mb-0 pb-0 f-12 w-500 text-gray">0.00 Hrs / $0.00</p>
                        </div>
                    </div>
                </div>

                <div class="shift-card ms-2">
                    <div class="d-flex align-items-center ">
                        <img src="assets/images/User.png" alt="">
                        <div class="ms-3">
                            <h3 class="f-14 w-600 text-dark mb-0 pb-0">Maria Roselia</h3>
                            <p class="mb-0 pb-0 f-12 w-500 text-gray">0.00 Hrs / $0.00</p>
                        </div>
                    </div>
                </div>

                <div class=" shift-card ms-2">
                    <div class="d-flex align-items-center ">
                        <img src="assets/images/User.png" alt="">
                        <div class="ms-3">
                            <h3 class="f-14 w-600 text-dark mb-0 pb-0">Maria Roselia</h3>
                            <p class="mb-0 pb-0 f-12 w-500 text-gray">0.00 Hrs / $0.00</p>
                        </div>
                    </div>
                </div>

                <div class="shift-card ms-2">
                    <div class="d-flex align-items-center ">
                        <img src="assets/images/User.png" alt="">
                        <div class="ms-3">
                            <h3 class="f-14 w-600 text-dark mb-0 pb-0">Maria Roselia</h3>
                            <p class="mb-0 pb-0 f-12 w-500 text-gray">0.00 Hrs / $0.00</p>
                        </div>
                    </div>
                </div>


                <div class=" shift-card ms-2">
                    <div class="d-flex align-items-center ">
                        <img src="assets/images/User.png" alt="">
                        <div class="ms-3">
                            <h3 class="f-14 w-600 text-dark mb-0 pb-0">Maria Roselia</h3>
                            <p class="mb-0 pb-0 f-12 w-500 text-gray">0.00 Hrs / $0.00</p>
                        </div>
                    </div>
                </div>

                <div class="shift-card ms-2">
                    <div class="d-flex align-items-center ">
                        <img src="assets/images/User.png" alt="">
                        <div class="ms-3">
                            <h3 class="f-14 w-600 text-dark mb-0 pb-0">Maria Roselia</h3>
                            <p class="mb-0 pb-0 f-12 w-500 text-gray">0.00 Hrs / $0.00</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="blushed-card mt-4 mb-5"
            style="border-radius: 4px;
    border: 1px solid var(--fill-dark-dark-5, #EBEAED);
    background: var(--fill-white-white, #FFF);">
            <div class="table-responsive">
                <div id='calendar' class="dashboard-table-lg"></div>
            </div>

        </div>

    </div>


    <!--publish Modal -->
    <div class="modal fade" id="publishModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header mt-2 me-2">
                    <button type="button" class="btn-close f-16" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">
                    <h5 class="f-22" style="color: #F34F4F; font-weight: 600; " id="exampleModalLabel">Alert</h5>
                    <p class="mb-0 pb-0 f-600 text-gray f-14">You didn’t create quiz/info/recap for this brands</p>
                    <hr class="my-5">
                    <div class="d-flex justify-content-center mt-4">
                        <button type="button" class="sign-btn " data-bs-dismiss="modal">Create Now</button>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <!--add memebre Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header mt-2 me-2 align-items-start">
                    <div>
                        <h5 class="f-22" style=" font-weight: 600; " id="exampleModalLabel">Add members to this job
                        </h5>
                        <p class="mb-0 pb-0 f-600 text-gray f-14">Enter email with hour rate job</p>
                    </div>
                    <button type="button" class="btn-close f-16" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0 mt-3">
                    <form action="" class="sign__frame-right--form">
                        <div class="row w-100 align-items-center">
                            <div class="col-lg-5 col-md-5 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="email" class="form-control sign-input " id="floatingInput">
                                    <label for="floatingInput" class="sign-label">Email address</label>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-10">
                                <div class="form-floating mb-4 w-100">
                                    <input type="email" class="form-control sign-input " id="floatingInput">
                                    <label for="floatingInput" class="sign-label">Flat rate</label>
                                </div>
                            </div>
                            <div class="col-2 ">
                                <div class="d-flex align-items-end  justify-content-md-start justify-content-center">
                                    <svg class="me-2 cursor-pointer add-role" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM17 13H13V17H11V13H7V11H11V7H13V11H17V13Z"
                                            fill="#CD7FAF" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <div class=" appended-row w-100 ">

                        </div>
                        <hr class="sign-line">
                        <div class="col-lg-12">
                            <div class="d-flex mt-4">
                                <button class="sign-btn">Assign</button>
                            </div>
                        </div>


                    </form>
                </div>

            </div>
        </div>
    </div>

    <script type="text/template" id="add-role">
<div class="row align-items-center w-100">
    <div class="col-lg-5 col-md-5 col-12">
        <div class="form-floating mb-4 w-100">
            <input type="email" class="form-control sign-input " id="floatingInput"
                >
            <label for="floatingInput" class="sign-label">Email address</label>
        </div>
    </div>
    <div class="col-lg-5 col-md-5 col-10">
        <div class="form-floating mb-4 w-100">
            <input type="email" class="form-control sign-input " id="floatingInput"
                >
            <label for="floatingInput" class="sign-label">Flat rate</label>
        </div>
    </div>
    <div class="col-2">
    <div class="d-flex align-items-end justify-content-md-start justify-content-center">
        <svg class="delete-appended-element" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M14.5 3L15.5 4H19V6H5V4H8.5L9.5 3H14.5ZM6 18.9999C6 20.0999 6.9 20.9999 8 20.9999H16C17.1 20.9999 18 20.0999 18 18.9999V6.9999H6V18.9999ZM8.0001 9H16.0001V19H8.0001V9Z" fill="#FC3400"/>
          </svg>
    </div>
   </div>
</div>
</script>


    <!--view-brand-details Modal -->
    <div class="modal fade" id="event-details" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="f-18 w-600 text-center w-100 mt-1" id="exampleModalLabel">All shift details</h5>
                    <button type="button" class="btn-close f-12" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0">

                    <div class="accordion shift-accordian" id="myAccordion">
                        <div class="accordion-item shift-detail-box accordion-item-red">
                            <div class="accordian-header" id="headingOne">
                                <button
                                    class="d-flex align-items-start flex-wrap accordion-button collapsed accordion-button-red"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    <div class="">
                                        <p class="mb-0 pb-0 f-14 w-600">6pm - 09pm &nbsp;&nbsp;&nbsp; <span
                                                class="text-primary">9</span> /10 Staff</p>
                                        <p class="mb-0 pb-0 f-14 w-600">Nichlos Floor &nbsp;&nbsp; (BA - Nash)</p>
                                    </div>

                                </button>
                            </div>

                            <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#myAccordion">
                                <hr class="sign-line my-3">

                                <div
                                    class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap">
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Account:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">Green Meadows</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Brand:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">Junction 35</p>
                                    </div>
                                    <div class="mt-2">
                                        <button style="background-color: transparent; border: none;"
                                            data-bs-toggle="modal" data-bs-target="#noteModal" data-bs-dismiss="modal">
                                            <img src="assets/images/btn.svg" alt="">
                                        </button>
                                        <button style="background-color: transparent; border: none;">
                                            <img src="assets/images/edit-details.svg" alt="" class="me-2">
                                        </button>
                                    </div>
                                </div>

                                <div
                                    class="d-flex justify-content-between align-items-start  mt-3 flex-md-row flex-column flex-wrap">
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Address:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">1147 Hunters Crossing, Alcoa, TN
                                            37701</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Phone #:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">541 533 2551</p>
                                    </div>
                                </div>

                                <div
                                    class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap mt-3">
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Email:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">Rebecca@gmai.com</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Contact:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">Rebecca</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Communication via:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">call</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="mb-0 pb-0 f-14 w-600 text-gray">Skus</p>
                                    <p class="mb-0 pb-0 f-14 w-600 text-black">Bam , Straight Bourbon</p>
                                </div>

                                <hr class="sign-line my-3">

                                <h1 class="f-14 w-700 mb-3">Other Shift Staff</h1>
                                <div class="satff-div-responsive">
                                    <div class="satff-div">
                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">Maria Roselia</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="hover-btn"><img src="assets/images/view.svg"
                                                        alt=""></button>
                                                <button class="hover-btn delete-detail"><img
                                                        src="assets/images/delete.svg" alt=""></button>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <img src="assets/images/accepted.svg" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">2.00 Hrs / $22.00</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="main-btn-blank">Paid</button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">Maria Roselia</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="hover-btn"><img src="assets/images/view.svg"
                                                        alt=""></button>
                                                <button class="hover-btn delete-detail"><img
                                                        src="assets/images/delete.svg" alt=""></button>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <img src="assets/images/accepted.svg" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">2.00 Hrs / $22.00</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="main-btn">Pay Now</button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">Maria Roselia</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="hover-btn"><img src="assets/images/view.svg"
                                                        alt=""></button>
                                                <button class="hover-btn delete-detail"><img
                                                        src="assets/images/delete.svg" alt=""></button>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <img src="assets/images/accepted.svg" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">2.00 Hrs / $22.00</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="main-btn">Pay Now</button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">Abhoy Latif</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="hover-btn"><img src="assets/images/view.svg"
                                                        alt=""></button>
                                                <button class="hover-btn delete-detail"><img
                                                        src="assets/images/delete.svg" alt=""></button>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <img src="assets/images/pending.svg" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Pending</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">2.00 Hrs / $22.00</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="main-btn">Pay Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>



                    <!-- accordian 2 -->
                    <div class="accordion shift-accordian mt-3" id="myAccordion">
                        <div class="accordion-item shift-detail-box accordion-item-blue">
                            <div class="accordian-header" id="heading2">
                                <button
                                    class="d-flex align-items-start flex-wrap accordion-button collapsed accordion-button-blue"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                    <div class="">
                                        <p class="mb-0 pb-0 f-14 w-600">6pm - 09pm &nbsp;&nbsp;&nbsp; <span
                                                class="text-primary">9</span> /10 Staff</p>
                                        <p class="mb-0 pb-0 f-14 w-600">Nichlos Floor &nbsp;&nbsp; (BA - Nash)</p>
                                    </div>

                                </button>
                            </div>

                            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#myAccordion">
                                <hr class="sign-line my-3">

                                <div
                                    class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap">
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Account:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">Green Meadows</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Brand:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">Junction 35</p>
                                    </div>
                                    <div class="mt-2">
                                        <button style="background-color: transparent; border: none;"
                                            data-bs-toggle="modal" data-bs-target="#noteModal" data-bs-dismiss="modal">
                                            <img src="assets/images/btn.svg" alt="">
                                        </button>
                                        <button style="background-color: transparent; border: none;">
                                            <img src="assets/images/edit-details.svg" alt="" class="me-2">
                                        </button>
                                    </div>
                                </div>

                                <div
                                    class="d-flex justify-content-between align-items-start  mt-3 flex-md-row flex-column flex-wrap">
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Address:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">1147 Hunters Crossing, Alcoa, TN
                                            37701</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Phone #:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">541 533 2551</p>
                                    </div>
                                </div>

                                <div
                                    class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap mt-3">
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Email:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">Rebecca@gmai.com</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Contact:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">Rebecca</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Communication via:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">call</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="mb-0 pb-0 f-14 w-600 text-gray">Skus</p>
                                    <p class="mb-0 pb-0 f-14 w-600 text-black">Bam , Straight Bourbon</p>
                                </div>

                                <hr class="sign-line my-3">

                                <h1 class="f-14 w-700 mb-3">Other Shift Staff</h1>
                                <div class="satff-div-responsive">
                                    <div class="satff-div">
                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">Maria Roselia</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="hover-btn"><img src="assets/images/view.svg"
                                                        alt=""></button>
                                                <button class="hover-btn delete-detail"><img
                                                        src="assets/images/delete.svg" alt=""></button>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <img src="assets/images/accepted.svg" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">2.00 Hrs / $22.00</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="main-btn-blank">Paid</button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">Maria Roselia</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="hover-btn"><img src="assets/images/view.svg"
                                                        alt=""></button>
                                                <button class="hover-btn delete-detail"><img
                                                        src="assets/images/delete.svg" alt=""></button>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <img src="assets/images/accepted.svg" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">2.00 Hrs / $22.00</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="main-btn">Pay Now</button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">Maria Roselia</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="hover-btn"><img src="assets/images/view.svg"
                                                        alt=""></button>
                                                <button class="hover-btn delete-detail"><img
                                                        src="assets/images/delete.svg" alt=""></button>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <img src="assets/images/accepted.svg" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">2.00 Hrs / $22.00</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="main-btn">Pay Now</button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">Abhoy Latif</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="hover-btn"><img src="assets/images/view.svg"
                                                        alt=""></button>
                                                <button class="hover-btn delete-detail"><img
                                                        src="assets/images/delete.svg" alt=""></button>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <img src="assets/images/pending.svg" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Pending</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">2.00 Hrs / $22.00</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="main-btn">Pay Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <!-- accordian 3 -->
                    <div class="accordion shift-accordian mt-3" id="myAccordion">
                        <div class="accordion-item shift-detail-box">
                            <div class="accordian-header" id="heading2">
                                <button class="d-flex align-items-start flex-wrap accordion-button  accordion-button"
                                    type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                    <div class="">
                                        <p class="mb-0 pb-0 f-14 w-600">6pm - 09pm &nbsp;&nbsp;&nbsp; <span
                                                class="text-primary">9</span> /10 Staff</p>
                                        <p class="mb-0 pb-0 f-14 w-600">Nichlos Floor &nbsp;&nbsp; (BA - Nash)</p>
                                    </div>
                                    <div class="complete-shift-caption ms-3">
                                        Complete Shift
                                    </div>
                                </button>
                            </div>

                            <div id="collapse3" class="accordion-collapse collapse show" data-bs-parent="#myAccordion">
                                <hr class="sign-line my-3">

                                <div
                                    class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap">
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Account:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">Green Meadows</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Brand:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">Junction 35</p>
                                    </div>
                                    <div class="mt-2">
                                        <button style="background-color: transparent; border: none;"
                                            data-bs-toggle="modal" data-bs-target="#noteModal" data-bs-dismiss="modal">
                                            <img src="assets/images/btn.svg" alt="">
                                        </button>
                                        <button style="background-color: transparent; border: none;">
                                            <img src="assets/images/edit-details.svg" alt="" class="me-2">
                                        </button>
                                    </div>
                                </div>

                                <div
                                    class="d-flex justify-content-between align-items-start  mt-3 flex-md-row flex-column flex-wrap">
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Address:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">1147 Hunters Crossing, Alcoa, TN
                                            37701</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Phone #:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">541 533 2551</p>
                                    </div>
                                </div>

                                <div
                                    class="d-flex justify-content-between align-items-start flex-md-row flex-column flex-wrap mt-3">
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Email:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">Rebecca@gmai.com</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Contact:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">Rebecca</p>
                                    </div>
                                    <div class="mt-2">
                                        <p class="mb-0 pb-0 f-14 w-600 text-gray">Communication via:</p>
                                        <p class="mb-0 pb-0 f-14 w-600 text-black">call</p>
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <p class="mb-0 pb-0 f-14 w-600 text-gray">Skus</p>
                                    <p class="mb-0 pb-0 f-14 w-600 text-black">Bam , Straight Bourbon</p>
                                </div>

                                <hr class="sign-line my-3">

                                <h1 class="f-14 w-700 mb-3">Other Shift Staff</h1>
                                <div class="satff-div-responsive">
                                    <div class="satff-div">
                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">Maria Roselia</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="hover-btn"><img src="assets/images/view.svg"
                                                        alt=""></button>
                                                <button class="hover-btn delete-detail"><img
                                                        src="assets/images/delete.svg" alt=""></button>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <img src="assets/images/accepted.svg" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">2.00 Hrs / $22.00</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="main-btn-blank">Paid</button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">Maria Roselia</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="hover-btn"><img src="assets/images/view.svg"
                                                        alt=""></button>
                                                <button class="hover-btn delete-detail"><img
                                                        src="assets/images/delete.svg" alt=""></button>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <img src="assets/images/accepted.svg" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">2.00 Hrs / $22.00</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="main-btn">Pay Now</button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">Maria Roselia</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="hover-btn"><img src="assets/images/view.svg"
                                                        alt=""></button>
                                                <button class="hover-btn delete-detail"><img
                                                        src="assets/images/delete.svg" alt=""></button>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <img src="assets/images/accepted.svg" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Accepted</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">2.00 Hrs / $22.00</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="main-btn">Pay Now</button>
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center mb-2 shift-staf-row justify-content-between">
                                            <div class="dp-div" style="min-width: 150px;">
                                                <img src="assets/images/Avatar.png" alt="" class="dp-img">
                                                <div class="ms-2">
                                                    <h4 class="mb-0 pb-0 ">Abhoy Latif</h4>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="hover-btn"><img src="assets/images/view.svg"
                                                        alt=""></button>
                                                <button class="hover-btn delete-detail"><img
                                                        src="assets/images/delete.svg" alt=""></button>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <img src="assets/images/pending.svg" alt="" width="20">
                                                <p class="mb-0 pb-0 f-14 w-600 ms-1">Pending</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <p class="mb-0 pb-0 f-12 text-gray w-600 ms-1">2.00 Hrs / $22.00</p>
                                            </div>
                                            <div class="d-flex align-items-center ms-3">
                                                <button class="main-btn">Pay Now</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <!--note Modal -->
    <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header mt-2 me-2 align-items-start">
                    <div>
                        <h5 class="f-18" style=" font-weight: 600; " id="exampleModalLabel">Shift notes</h5>
                    </div>
                </div>
                <div class="modal-body pt-0">
                    <form class="sign__frame-right--form">
                        <div class="">
                            <p class="mb-0 pb-0 f-14 w-600">03-22-2023 &nbsp;&nbsp;&nbsp; 6pm - 09pm &nbsp;&nbsp;&nbsp;
                                <span class="text-primary">9</span> /10 Staff
                            </p>
                            <p class="mb-0 pb-0 f-14 w-600">Nichlos Floor &nbsp;&nbsp; </p>
                        </div>
                        <div class="form-floating mb-4 w-100">
                            <textarea class="form-control  sign-input" placeholder="Leave a comment here" id="floatingTextarea2"
                                style="height: 100px"></textarea>
                            <label for="floatingTextarea2 " class="sign-label">Note</label>
                        </div>

                    </form>
                    <div class="d-flex justify-content-end mt-4">
                        <a type="button" class="main-btn-blank ms-3 text-white bg-primary" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#event-details">Send</a>
                        <button type="button" class="main-btn-blank text-dark border-dark  ms-3" data-bs-dismiss="modal"
                            data-bs-toggle="modal" data-bs-target="#event-details">Close</button>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.pay-table').DataTable({
                paging: true,
                language: {
                    searchPlaceholder: "Search brands..."
                }
            });
        });
    </script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
        integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script src="{{ URL::to('/assets/Js/calendar-full.js') }}"></script>
    <script>
        $('.available-shifts').slick({
            slidesToShow: 4.2,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            arrows: false,
            variableWidth: true,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,

                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    </script>
    <script>
        $(document).ready(function() {
            // Function to append the template when .add-role is clicked
            function appendRoleTemplate() {
                // Clone the template content
                const template = $("#add-role").html();

                // Append the template to the form
                $(".appended-row").append(template);
            }

            // Add a click event listener to the .add-role element
            $(".add-role").on("click", appendRoleTemplate);
        });

        // Event delegation for deleting appended elements
        $(".appended-row").on("click", ".delete-appended-element", function() {
            // Remove the corresponding parent element when the delete icon is clicked
            $(this).closest(".row").remove();
        });
    </script>
    <script>
        // Add a click event listener to the delete buttons
        $(document).ready(function() {
            $(".delete-detail").click(function() {
                // Find the parent .shift-staf-row and remove it
                $(this).closest(".shift-staf-row").remove();
            });
        });

        // Active publish on checkbox checked
        $(document).on('change', '.event-checkbox', function() {
            var publishCount = $(".event-checkbox:checked").length;
            $("#publish-count").text(publishCount);

            if (publishCount == 0) {
                $("#publish-btn").attr("disabled", true)
            } else {
                $("#publish-btn").attr("disabled", false)
            }
        })
    </script>
@endsection

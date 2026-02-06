{{-- Failed --}}
@if (Session::has('Alert') && Session::get('Alert')['status'] == 100)
    <div class="alert alert-danger alert-dismissible text-bg-danger border-0 fade show" role="alert">
        {{-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"
            fdprocessedid="w40b6k"></button> --}}
        <strong>Sorry !!! </strong> {{ Session::get('Alert')['message'] }}
    </div>
@endif

{{-- Successful --}}
@if (Session::has('Alert') && Session::get('Alert')['status'] == 200)
    <div class="alert alert-success alert-dismissible text-bg-success border-0 fade show" role="alert">
        {{-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"
            fdprocessedid="w40b6k"></button> --}}
        <strong>Success !!! </strong> {{ Session::get('Alert')['message'] }}
    </div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="alert alert-danger fade show px-3" role="alert">
        <p class="mb-0"><strong>Please Fix These</strong></p>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

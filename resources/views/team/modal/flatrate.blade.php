{{-- flat-rate modal --}}
<div class="modal fade" id="flat-rate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header mt-1">
                <h5 class="f-18 w-600" id="exampleModalLabel">Set Shift Flat Rate</h5>
            </div>
            <div class="modal-body pt-0">
                <form class="sign__frame-right--form" action="{{ URL::to('/team/flat-rate') }}" method="POST">
                    @csrf

                    <input type="hidden" class="user_id" name="user_id" value="">

                    <div class="form-floating mb-4 w-100">
                        <div class="form-floating">
                            <input class="form-control sign-input flat-user-name" placeholder="Client Name" id="floatinput"
                                name="name" value="" readonly>
                            <label for="floatinput sign-label">Name</label>
                        </div>
                    </div>

                    <div class="form-floating mb-4 w-100">
                        <div class="form-floating">
                            <input class="form-control sign-input flat-price" placeholder="" id="floatinginput" name="flat_rate"
                                required>
                            <label for="floatinginput sign-label">Rate ($)
                                <sup><strong>*</strong></sup>
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-md-end justify-content-center flex-wrap mt-4">
                        <button type="submit" class="main-btn-blank text-white bg-primary">Done</button>
                        <button type="button" class="main-btn-blank ms-3" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

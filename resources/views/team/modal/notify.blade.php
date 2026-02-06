{{-- notify modal --}}
<div class="modal fade" id="notify" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header mt-1">
                <h5 class="f-18 w-600" id="exampleModalLabel">Notify user</h5>
            </div>
            <div class="modal-body pt-0">

                <form class="sign__frame-right--form" action="{{ URL::to('/team/notify') }}" method="POST">
                    @csrf

                    <input type="hidden" name="user_id" value="" class="user_id">



                    <div class="form-floating mb-4 w-100">
                        <div class="form-floating">
                            <textarea class="form-control  sign-input" placeholder="Leave a comment here" id="floatingTextarea2"
                               name="feedback" style="height: 100px"></textarea>
                            <label for="floatingTextarea2 sign-label">Message</label>
                        </div>
                    </div>

                <div class="d-flex justify-content-md-end justify-content-center flex-wrap mt-4">
                    <button type="submit" class="main-btn-blank text-white bg-primary "
                        data-bs-dismiss="modal">Done</button>
                    <button type="button" class="main-btn-blank ms-3" data-bs-dismiss="modal">Close</button>
                </div>
            </form>

            </div>

        </div>
    </div>
</div>

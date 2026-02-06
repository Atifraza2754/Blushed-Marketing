{{-- delete user modal --}}
<div class="modal fade" id="delete-member" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header mt-1 pb-0">
                <h5 class="f-18 w-600" id="exampleModalLabel" style="color: #F00;">Terminate user</h5>
                <button type="button" class="btn-close f-12 text-primary" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <p class="f-14 w-500 text-gray">
                    Terminated user will not access your software again.
                </p>

                <form action="{{ URL::to('/team/terminate') }}" method="post">
                    @csrf

                    <input type="hidden" class="user_id" name="user_id" value="">

                    <div class="d-flex justify-content-center mt-4 pt-3">
                        <button type="button" class="main-btn-blank bg-primary text-white"
                            data-bs-dismiss="modal">NO</button>
                        <button type="submit" class="main-btn-blank ms-3" data-bs-dismiss="modal">Yes</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>

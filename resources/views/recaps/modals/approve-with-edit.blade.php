{{-- Aprrove With Edit Modal --}}
<div class="modal fade" id="exampleModal-approve-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header mt-1">
                <h5 class="f-18 w-600" id="exampleModalLabel">Approve with edit</h5>
            </div>
            <div class="modal-body pt-0">
                <form class="sign__frame-right--form" action='{{ URL::to("/recap/$user_recap->id/approve-with-edit") }}'
                    method="POST">
                    @csrf

                    {{-- user_id --}}
                    <input type="hidden" name="user_id" value="{{ $user_recap->user_id }}">

                    {{-- user_name --}}

                    <div class="form-floating w-100 mb-4">
                        <input class="form-control  sign-input" placeholder="Name" id="floating-input2"
                            value="{{ $user_recap->user->name }}">
                        <label for="floating-input2 sign-label">Client Name</label>
                    </div>

                    {{-- feedback --}}
                    <div class="form-floating mb-4 w-100">
                        <div class="form-floating">
                            <textarea class="form-control  sign-input" placeholder="Leave a comment here" id="floatingTextarea2"
                                style="height: 100px" name="feedback">{{ $user_recap->feedback }}</textarea>
                            <label for="floatingTextarea2 sign-label">Feedback</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="main-btn" data-bs-dismiss="modal">Done</button>
                        <button type="button" class="main-btn-white ms-3" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

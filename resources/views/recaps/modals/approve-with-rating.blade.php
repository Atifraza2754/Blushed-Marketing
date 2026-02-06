{{-- Approve With Rating Modal --}}
<div class="modal fade" id="exampleModal-approve" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header mt-1">
                <h5 class="f-18 w-600" id="exampleModalLabel">Rating</h5>
            </div>
            <div class="modal-body pt-0">
                <form class="sign__frame-right--form"
                    action='{{ URL::to("/recap/$user_recap->id/approve-with-rating") }}' method="POST">
                    @csrf

                    {{-- user_id --}}
                    <input type="hidden" name="user_id" value="{{ $user_recap->user_id }}">

                    {{-- user_name --}}
                    <div class="form-floating w-100 mb-4">
                        <input class="form-control  sign-input" placeholder="Name" id="floating-input2"
                            value="{{ $user_recap->user->name }}">
                        <label for="floating-input2 sign-label">Client Name</label>
                    </div>

                    {{-- rating stars --}}
                    <div class="rating">
                        <i class="rating__star far fa-star" data-value="1"></i>
                        <i class="rating__star far fa-star" data-value="2"></i>
                        <i class="rating__star far fa-star" data-value="3"></i>
                        <i class="rating__star far fa-star" data-value="4"></i>
                        <i class="rating__star far fa-star" data-value="5"></i>
                        <div class="ms-4">
                            <span class="rating__result"></span>
                        </div>
                    </div>

                    {{-- rating --}}
                    <input type="hidden" id="rating" name="rating" value="">

                    {{-- feedback --}}
                    <div class="form-floating mb-4 w-100">
                        <div class="form-floating">
                            <textarea class="form-control sign-input" placeholder="Leave a comment here" id="floatingTextarea2"
                                style="height: 100px" name="feedback">{{ $user_recap->feedback }}</textarea>
                            <label for="floatingTextarea2 sign-label">Feedback</label>
                        </div>
                    </div>

                    {{-- btns --}}
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="main-btn">Done</button>
                        <button type="button" class="main-btn-white ms-3" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle star rating click event
        $('.rating__star').on('click', function() {
            // Get the rating value from the clicked star
            var ratingValue = $(this).data('value');

            // Highlight stars up to the selected one
            $('.rating__star').removeClass('fas').addClass('far'); // Reset all stars
            $(this).prevAll().addBack().removeClass('far').addClass('fas'); // Highlight selected stars

            // Set the rating value in the hidden input
            $('#rating').val(ratingValue);

            // Optionally show the rating value in a result span (if you want)
            $('.rating__result').text('Rating: ' + ratingValue);
        });
    });
</script>

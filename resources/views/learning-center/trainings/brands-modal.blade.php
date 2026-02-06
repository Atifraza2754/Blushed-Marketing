{{-- Modal --}}
<div class="modal fade" id="create-training" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header mt-1">
                <h5 class="f-18 w-600" id="exampleModalLabel">Select Brand Name for Training</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body pt-0">
                <form action="{{ URL::to('/learning-center/training/create') }}" method="get"
                    class="sign__frame-right--form">
                    @csrf

                    <div class="form-floating w-100 mb-4">
                        <select class="form-select w-100 sign-input px-2 " id="floatingSelect" name="brand_id"
                            aria-label="Floating label select example" required>
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                                @if (!$brand->is_training_uploaded)
                                    <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                                @endif
                            @endforeach
                        </select>
                        <label for="floatingSelect sign-label">Available Brand</label>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="main-btn-blank text-dark border-dark  "
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="main-btn-blank ms-3 text-white bg-primary">Done</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

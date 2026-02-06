@extends('layouts.master', ['module' => 'shifts'])

@section('title')
    Edit shift detail
@endsection

@section('customStyles')
    {{-- dropzone --}}
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css" />
    <style>
        .blushed-card {
            height: auto !important;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="col-md-12 mx-auto">

                {{-- include alerts --}}
                @include('common.alerts')

                <h1 class="f-32 w-600 ">Shifts</h1>
                <div class="blushed-card mt-3 py-lg-4 px-lg-4">
                    <div class="row align-items-center">  <!-- Added align-items-center -->
                        <div class="col-md-10">
                            <h1 class="f-24 w-600">Edit Shift Detail</h1>
                            <p class="f-18 w-500" style="color: #84818A !important;">
                                Update the specified shift detail
                            </p>
                        </div>

                        <div class="col-md-2 d-flex justify-content-end gap-2">  <!-- Modified this div -->
                            <form action='{{ URL::to('/shift/publish') }}' method="POST">
                                @csrf
                                <input type="hidden" name="job_ids[]" value="{{ $shift->id }}">
                                @if($shift->is_published == 1)
                                    <button class="sign-btn" disabled>Published</button>
                                @else
                                    <button class="sign-btn">Publish This Job</button>
                                @endif
                            </form>
                            @if($shift->is_published != 1)
                            <button type="submit" class="btn btn-sm btn-danger "
                                    onclick="deletefunction({{ $shift->id }})"
                                    {{ $shift->is_published ? 'disabled' : '' }}>
                                Delete
                            </button>
                            @endif
                        </div>
                    </div>
                    <form action='{{ URL::to("/shift/$shift->id/update") }}' method="POST" class="sign__frame-right--form">
                        @csrf

                        <div class="row w-100 align-items-center">
                            {{-- account --}}
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="account" name="account"
                                        value="{{ $shift->account }}">
                                    <label for="floatingInput" class="sign-label">Account</label>
                                </div>
                            </div>
                            {{-- brand --}}
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="brand" name="brand"
                                        value="{{ $shift->brand }}">
                                    <label for="floatingInput" class="sign-label">Brand</label>
                                </div>
                            </div>
                            {{-- contact --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="contact" name="contact"
                                        value="{{ $shift->contact }}">
                                    <label for="floatingInput" class="sign-label">Contact</label>
                                </div>
                            </div>
                            {{-- phone --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="phone" name="phone"
                                        value="{{ $shift->phone }}">
                                    <label for="floatingInput" class="sign-label">Phone</label>
                                </div>
                            </div>
                            {{-- email --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="email" class="form-control sign-input " id="email" name="email"
                                        value="{{ $shift->email }}">
                                    <label for="floatingInput" class="sign-label">Email</label>
                                </div>
                            </div>
                            {{-- method_of_communication --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="method_of_communication"
                                        name="method_of_communication" value="{{ $shift->method_of_communication }}">
                                    <label for="floatingInput" class="sign-label">Method of Communication</label>
                                </div>
                            </div>
                            {{-- address --}}
                            <div class="col-md-12 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <textarea class="form-control sign-input" placeholder="address here" id="address"
                                        name="address" style="height: 100px">{{ $shift->address }}</textarea>
                                    <label for="floatingTextarea2 " class="sign-label">Address</label>
                                </div>
                            </div>
                            {{-- skus --}}
                            <div class="col-md-12 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <textarea class="form-control sign-input" placeholder="skus" id="skus" name="skus"
                                        style="height: 100px">{{ $shift->skus }}</textarea>
                                    <label for="floatingTextarea2 " class="sign-label">Brands And Product </label>
                                </div>
                            </div>
                            {{-- date --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="date" class="form-control sign-input " id="date" name="date"
                                        value="{{ $shift->date }}">
                                    <label for="floatingInput" class="sign-label">Date</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="test" class="form-control sign-input " id="attire" name="attire"
                                        value="{{ $shift->attire }}">
                                    <label for="floatingInput" class="sign-label">Attire</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="how_to_serve" name="how_to_serve"
                                        value="{{ $shift->how_to_serve }}">
                                    <label for="floatingInput" class="sign-label">How to Serve</label>
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="supplies_needed" name="supplies_needed"
                                        value="{{ $shift->supplies_needed }}">
                                    <label for="floatingInput" class="sign-label">suuplies Needed</label>
                                </div>
                            </div>
                            {{-- timezone --}}
                            <div class="col-md-2 col-12">
                                <div class="form-floating w-100 mb-4">
                                    <select class="form-select w-100 sign-input px-2 " id="timezone" name="timezone"
                                        aria-label="Floating label select example">
                                        <option value="EST" {{ $shift->timezone == 'EST' ? 'selected' : '' }}>EST
                                        </option>
                                        <option value="CST" {{ $shift->timezone == 'CST' ? '' : 'selected' }}>CST
                                        </option>
                                        <option value="MST" {{ $shift->timezone == 'MST' ? '' : 'selected' }}>MST
                                        </option>
                                        <option value="PST" {{ $shift->timezone == 'PST' ? '' : 'selected' }}>PST
                                        </option>
                                    </select>
                                    <label for="floatingSelect sign-label">Timezone</label>
                                </div>
                            </div>

                            {{-- scheduled_time --}}
                            <div class="col-md-5 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="scheduled_time"
                                        name="scheduled_time" value="{{ $shift->scheduled_time }}">
                                    <label for="floatingInput" class="sign-label">Scheduled Time</label>
                                </div>
                            </div>

                            {{-- samples_requested --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating w-100 mb-4">
                                    <select class="form-select w-100 sign-input px-2 " id="samples_requested"
                                        name="samples_requested" aria-label="Floating label select example">
                                        <option value="1" {{ $shift->samples_requested ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0" {{ $shift->samples_requested ? '' : 'selected' }}>No
                                        </option>
                                    </select>
                                    <label for="floatingSelect sign-label">Samples Requested?</label>
                                </div>
                            </div>
                            {{-- reschedule --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating w-100 mb-4">
                                    <select class="form-select w-100 sign-input px-2 " id="reschedule" name="reschedule"
                                        aria-label="Floating label select example">
                                        <option value="1" {{ $shift->reschedule ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0" {{ $shift->reschedule ? '' : 'selected' }}>No
                                        </option>
                                    </select>
                                    <label for="floatingSelect sign-label">Reschedule?</label>
                                </div>
                            </div>
                            {{-- added_to_homebase --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating w-100 mb-4">
                                    <select class="form-select w-100 sign-input px-2 " id="added_to_homebase"
                                        name="added_to_homebase" aria-label="Floating label select example">
                                        <option value="1" {{ $shift->added_to_homebase ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0" {{ $shift->added_to_homebase ? '' : 'selected' }}>No
                                        </option>
                                    </select>
                                    <label for="floatingSelect sign-label">Added To Homebase?</label>
                                </div>
                            </div>
                            {{-- confirmed --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating w-100 mb-4">
                                    <select class="form-select w-100 sign-input px-2 " id="confirmed" name="confirmed"
                                        aria-label="Floating label select example">
                                        <option value="1" {{ $shift->confirmed ? 'selected' : '' }}>Yes
                                        </option>
                                        <option value="0" {{ $shift->confirmed ? '' : 'selected' }}>No
                                        </option>
                                    </select>
                                    <label for="floatingSelect sign-label">Confirmed?</label>
                                </div>
                            </div>

                            {{-- is_published --}}
                            <div class="col-md-6 col-12">
                                <div class="form-floating w-100 mb-4">
                                    <select class="form-control w-100 sign-input px-2 " id="is_published"
                                        name="is_published" aria-label="Floating label select example" disabled>
                                        <option value="1" {{ $shift->is_published ? 'selected' : '' }}>Published
                                        </option>
                                        <option value="0" {{ $shift->is_published ? '' : 'selected' }}>Unpublished
                                        </option>
                                    </select>
                                    <label for="floatingSelect sign-label">Job Status</label>
                                </div>

                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="d-flex" style="float:right;">
                                <button class="sign-btn">Update shift</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
    <script src="https://rawgit.com/enyo/dropzone/master/dist/dropzone.js"></script>

    <script>
        // ==================================dropzone
        class DropZone {
            constructor() {
                this.dropZone = $('.drop-zone');

                // Add/Remove .is-dragover when hover/leave
                this.dropZone.on('dragover dragenter', () => this.dropZone.addClass('is-dragover'));
                this.dropZone.on('dragleave dragend drop', () => this.dropZone.removeClass('is-dragover'));

                this.dropZone.on('change', this.onchange.bind(this));

                // TODO: .has-image has to be removed when remove all images
                // TODO: Generate uniq id and add to input.has-image and .preview
                //       in order to remove them both when click on .remove
            }

            // Hide input.receiver and insert the new one
            onchange(e) {
                this.dropZone.addClass('has-images');

                // Rename input.receiver => input.has-image
                const $receiver = $(e.target);
                $receiver.removeClass('receiver').addClass('has-image');

                // Add new .receiver
                $('<input type="file" class="receiver" multiple>').prependTo(this.dropZone);

                // Event delegation for remove clicks
                this.dropZone.on('click', '.preview .remove', this.onRemove.bind(this));

                // Preview
                const files = $receiver[0].files;
                this.displayPreview(files);
            }

            displayPreview(files) {
                for (const file of files) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const url = e.currentTarget.result;
                        this.template(url).appendTo(this.dropZone);
                    };
                    reader.readAsDataURL(file);
                }
            }

            onRemove(e) {
                // Get the parent .preview element
                const $preview = $(e.target).closest('.preview');

                // Find the associated input element
                const $input = $preview.find('.has-image');

                // Remove both the .preview and .has-image elements
                $preview.remove();
                $input.remove();

                // Check if there are no more images, and remove the "has-images" class
                if (this.dropZone.find('.preview').length === 0) {
                    this.dropZone.removeClass('has-images');
                }
            }

            template(url) {
                return $(`
          <div class="preview">
            <div class="image">
              <img src="${url}">
            </div>
            <div class="details">
              <div class="remove">
                <span class="bi bi-trash3-fill text-white"></span>
              </div>
            </div>
          </div>
        `);
            }
        }

        new DropZone();


        function deletefunction(id) {

Swal.fire({
    title: 'Are you sure To Confirm This Shift?',
    // text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Submit'
}).then((result) => {
    if (result.isConfirmed) {

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({

            type: "get",
            url: "shift/delete/" + id,

            success: function (response) {
                // console.log(response);
                // return;
                let status = response.status;

                if (status == 200) {
                    Swal.fire({
                        title: response.message,
                        // text: "You won't be able to revert this!",
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ok'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });
                } else {
                    console.log("Something went wrong!!!");
                }
            },
        });
    }
})
}


    </script>
@endsection

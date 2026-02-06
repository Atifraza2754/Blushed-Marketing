 @extends('user.layouts.master', ['module' => 'shifts'])

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
                    <div class="row">
                        <div class="col-md-10">
                            <h1 class="f-24 w-600">Shift Detail</h1>
                            <p class="f-18 w-500 " style="color: #84818A !important;">
                                Update the specified shift detail
                            </p>
                        </div>

                    </div>

                    <form action='{{ URL::to("/shift/$shift->id/update") }}' method="POST" class="sign__frame-right--form">
                        @csrf

                        <div class="row w-100 align-items-center">
                            {{-- account --}}
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="account" name="account" readonly
                                        value="{{ $shift->account }}">
                                    <label for="floatingInput" class="sign-label">Account</label>
                                </div>
                            </div>
                            {{-- brand --}}
                            <div class="col-md-6 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="brand" name="brand" readonly
                                        value="{{ $shift->brand }}">
                                    <label for="floatingInput" class="sign-label">Brand</label>
                                </div>
                            </div>
                            {{-- contact --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="contact" name="contact" readonly
                                        value="{{ $shift->contact }}">
                                    <label for="floatingInput" class="sign-label">Contact</label>
                                </div>
                            </div>
                            {{-- phone --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="phone" name="phone" readonly
                                        value="{{ $shift->phone }}">
                                    <label for="floatingInput" class="sign-label">Phone</label>
                                </div>
                            </div>
                            {{-- email --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="email" class="form-control sign-input " id="email" name="email" readonly
                                        value="{{ $shift->email }}">
                                    <label for="floatingInput" class="sign-label">Email</label>
                                </div>
                            </div>
                            {{-- method_of_communication --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="method_of_communication" readonly
                                        name="method_of_communication" value="{{ $shift->method_of_communication }}">
                                    <label for="floatingInput" class="sign-label">Method of Communication</label>
                                </div>
                            </div>
                            {{-- address --}}
                            <div class="col-md-12 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <textarea class="form-control sign-input" placeholder="address here" id="address" name="address" readonly
                                        style="height: 100px">{{ $shift->address }}</textarea>
                                    <label for="floatingTextarea2 " class="sign-label">Address</label>
                                </div>
                            </div>
                            {{-- skus --}}
                            <div class="col-md-12 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <textarea class="form-control sign-input" placeholder="skus" readonly
                                    id="skus" name="skus" style="height: 100px">{{ $shift->skus }}</textarea>
                                    <label for="floatingTextarea2 " class="sign-label">SKU's</label>
                                </div>
                            </div>
                            {{-- date --}}
                            <div class="col-md-5 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="date" class="form-control sign-input " id="date" name="date" readonly
                                        value="{{ $shift->date }}">
                                    <label for="floatingInput" class="sign-label">Date</label>
                                </div>
                            </div>
                            {{-- timezone --}}
                            <div class="col-md-2 col-12">
                                <div class="form-floating w-100 mb-4">
                                    <select class="form-control w-100 sign-input px-2 " id="timezone" name="timezone" readonly
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
                                    <input type="text" class="form-control sign-input " id="scheduled_time" readonly
                                        name="scheduled_time" value="{{ $shift->time }}">
                                    <label for="floatingInput" class="sign-label">Scheduled Time</label>
                                </div>
                            </div>

                            {{-- samples_requested --}}
                            <div class="col-md-3 col-12">
                                <div class="form-floating w-100 mb-4">
                                    <select class="form-control w-100 sign-input px-2 " id="samples_requested" disabled
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
                                    <select class="form-control w-100 sign-input px-2 " id="reschedule" name="reschedule" disabled
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
                                    <select class="form-control w-100 sign-input px-2 " id="added_to_homebase" disabled
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
                                    <select class="form-control w-100 sign-input px-2 " id="confirmed" name="confirmed" disabled
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

                             <div class="col-md-5 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="attire" readonly
                                        name="attire" value="{{ $shift->attire }}">
                                    <label for="floatingInput" class="sign-label">Attire</label>
                                </div>
                            </div>
                             <div class="col-md-5 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="scheduled_time" readonly
                                        name="scheduled_time" value="{{ $shift->supplies_needed }}">
                                    <label for="floatingInput" class="sign-label">Supplies Needed</label>
                                </div>
                            </div>
                             <div class="col-md-5 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="scheduled_time" readonly
                                        name="scheduled_time" value="{{ $shift->how_to_serve }}">
                                    <label for="floatingInput" class="sign-label">How To Serve</label>
                                </div>
                            </div>
                             <div class="col-md-5 col-12">
                                <div class="form-floating mb-4 w-100">
                                    <input type="text" class="form-control sign-input " id="scheduled_time" readonly
                                        name="scheduled_time" value="{{ $shift->notes }}">
                                    <label for="floatingInput" class="sign-label">Notes</label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="col-lg-12">
                            <div class="d-flex col-md-4" style="float:right;">

                                <div class=" form-floating w-100 mb-4">
                                    <select class="form-select w-100 sign-input px-2 " id="is_published"
                                        name="is_published" aria-label="Floating label select example" onchange="changeStatus(this.value)">
                                        <option value="pending" {{ isset($jobMembers->status) && $jobMembers->status == 'pending' ? 'selected' : '' }} disabled>Pending
                                        </option>
                                        <option value="approved" {{ isset($jobMembers->status) && $jobMembers->status == 'approved' ? 'selected' : '' }}>Approved
                                        </option>
                                        <option value="reject" {{ isset($jobMembers->status) && $jobMembers->status == 'reject' ? 'selected' : '' }}>Reject
                                        </option>
                                    </select>
                                    <label for="floatingSelect sign-label">Status</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('customScripts')
<script>

function changeStatus(status){
                 var status = status;
                 var JobId = @json($shift->id ?? '');
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({

                type: "GET",
                url: "/update/user/job" ,
                data: {
                    'status': status,
                    'JobId' : JobId,
                },
                success: function(response) {
                    // console.log(response);
                    // return;

                    let status = response.status;

                    if (status == 200) {
                      location.reload();
                    } else {
                        console.log("Something went wrong!!!");
                    }
                },
            });
        }

</script>
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

    </script>
@endsection

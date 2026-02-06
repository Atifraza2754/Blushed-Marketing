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

        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
        }

        /* Form Field Styles */
        .form-label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.5);
        }

        /* Add spacing between rows */
        .mb-4 {
            margin-bottom: 1.5rem;
        }

        /* Adjusting for better layout */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-md-6,
        .col-12 {
            padding-left: 15px;
            padding-right: 15px;
        }

        @media (max-width: 768px) {
            .col-md-6 {
                flex: 0 0 100%;
            }
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
                    <div>
                        <div class="row">
                            {{-- Account --}}
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="account" class="form-label">Account</label>
                                    <input type="text" class="form-control" id="account" name="account"
                                        value="{{ $shift->account }}" readonly>
                                </div>
                            </div>

                            {{-- Brand --}}
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="brand" class="form-label">Brand</label>
                                    <input type="text" class="form-control" id="brand" name="brand"
                                        value="{{ $shift->brand }}" readonly>
                                </div>
                            </div>

                            {{-- Contact --}}
                            {{-- <div class="col-md-4 col-12 mb-4">
                                <div class="form-group">
                                    <label for=" " class="form-label">Contact</label>

                                    <input type="text" class="form-control" id=" " name=" " value="{{ $shift->contact }}"
                                        readonly>
                                </div>
                            </div> --}}

                            {{-- Phone --}}
                            {{-- <div class="col-md-4 col-12 mb-4">
                                <div class="form-group">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" class="form-control" id=" " name="phone" value="{{ $shift->phone }}"
                                        readonly>
                                </div>
                            </div> --}}

                            {{-- Email --}}
                            {{-- <div class="col-md-4 col-12 mb-4">
                                <div class="form-group">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ $shift->email }}" readonly>
                                </div>
                            </div> --}}

                            {{-- Method of Communication --}}
                            {{-- <div class="col-md-4 col-12 mb-4">
                                <div class="form-group">
                                    <label for="method_of_communication" class="form-label">Method of Communication</label>
                                    <input type="text" class="form-control" id="method_of_communication"
                                        name="method_of_communication" value="{{ $shift->method_of_communication }}"
                                        readonly>
                                </div>
                            </div> --}}

                            {{-- Address --}}
                            <div class="col-12 mb-4">
                                <div class="form-group">
                                    <label for="address" class="form-label">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3"
                                        readonly>{{ $shift->address }}</textarea>
                                </div>
                            </div>

                            {{-- SKU's --}}
                            <div class="col-12 mb-4">
                                <div class="form-group">
                                    <label for="skus" class="form-label">Brands And Product</label>
                                    <textarea class="form-control" id="skus" name="skus" rows="3"
                                        readonly>{{ $shift->skus }}</textarea>
                                </div>
                            </div>

                            {{-- Date --}}
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="date" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date" name="date" value="{{ $shift->date }}"
                                        readonly>
                                </div>
                            </div>

                            {{-- Timezone --}}
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="timezone" class="form-label">Timezone</label>
                                    <select class="form-control" id="timezone" name="timezone" readonly>
                                        <option value="EST" {{ $shift->timezone == 'EST' ? 'selected' : '' }}>EST</option>
                                        <option value="CST" {{ $shift->timezone == 'CST' ? 'selected' : '' }}>CST</option>
                                        <option value="MST" {{ $shift->timezone == 'MST' ? 'selected' : '' }}>MST</option>
                                        <option value="PST" {{ $shift->timezone == 'PST' ? 'selected' : '' }}>PST</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Scheduled Time --}}
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="scheduled_time" class="form-label">Scheduled Time</label>
                                    <input type="text" class="form-control" id="scheduled_time" name="scheduled_time"
                                        value="{{ $shift->scheduled_time }}" readonly>
                                </div>
                            </div>

                            {{-- Samples Requested --}}
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="samples_requested" class="form-label">Samples Requested?</label>
                                    <select class="form-control" id="samples_requested" name="samples_requested" disabled>
                                        <option value="1" {{ $shift->samples_requested ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ !$shift->samples_requested ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Reschedule --}}
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="reschedule" class="form-label">Reschedule?</label>
                                    <select class="form-control" id="reschedule" name="reschedule" disabled>
                                        <option value="1" {{ $shift->reschedule ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ !$shift->reschedule ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>

                            {{-- Added to Homebase --}}
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="added_to_homebase" class="form-label">Added to Homebase?</label>
                                    <select class="form-control" id="added_to_homebase" name="added_to_homebase" disabled>
                                        <option value="1" {{ $shift->added_to_homebase ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ !$shift->added_to_homebase ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                            {{-- Confirmed --}}
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="confirmed" class="form-label">Confirmed?</label>
                                    <select class="form-control" id="confirmed" name="confirmed" disabled>
                                        <option value="1" {{ $shift->confirmed ? 'selected' : '' }}>Yes</option>
                                        <option value="0" {{ !$shift->confirmed ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                            {{-- Job Status --}}
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="is_published" class="form-label">Job Status</label>
                                    <select class="form-control" id="is_published" name="is_published" disabled>
                                        <option value="1" {{ $shift->is_published ? 'selected' : '' }}>Published</option>
                                        <option value="0" {{ !$shift->is_published ? 'selected' : '' }}>Unpublished</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="" class="form-label">Attire</label>
                                    <input type="text" class="form-control  " id="attire" readonly name="attire"
                                        value="{{ $shift->attire }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="" class="form-label">Supplies Needed</label>
                                    <input type="text" class="form-control  " id="scheduled_time" readonly
                                        name="scheduled_time" value="{{ $shift->supplies_needed }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="" class="form-label">How To Serve</label>
                                    <input type="text" class="form-control  " id="scheduled_time" readonly
                                        name="scheduled_time" value="{{ $shift->how_to_serve }}">
                                </div>
                            </div>
                            <div class="col-md-6 col-12 mb-4">
                                <div class="form-group">
                                    <label for="" class="form-label">Notes</label>
                                    <input type="text" class="form-control  " id="scheduled_time" readonly
                                        name="scheduled_time" value="{{ $shift->notes }}">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('customScripts')
    <script>

        function changeStatus(status) {
            var status = status;
            var JobId = @json($shift->id ?? '');
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
            });

            $.ajax({

                type: "GET",
                url: "/update/user/job",
                data: {
                    'status': status,
                    'JobId': JobId,
                },
                success: function (response) {
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

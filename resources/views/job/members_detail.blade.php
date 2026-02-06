@extends('layouts.master', ['module' => 'shifts'])

@section('title')
    User detail
@endsection

@section('customStyles')
    {{-- dropzone --}}
    <link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css" />
    <style>
        .blushed-card {
            height: auto !important;
        }
        .profile-picture {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 10px;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
            <div class="col-md-12 mx-auto">

                {{-- include alerts --}}
                @include('common.alerts')

                <div class="blushed-card mt-3 py-lg-4 px-lg-4">

                    <div class="row w-100 align-items-center">
                        <div class="row justify-content-center">
                            <div class="col-md-8 text-center">
                                <h2 class="mb-4">User Details</h2>

                                <!-- Profile Picture -->
                                <img src="{{ $users->profile_picture ?? null }}" alt="Profile Picture" class="profile-picture"
                                    onerror="this.onerror=null; this.src='{{ URL::to('/assets/images/asset2.png') }}';">
                                 <!-- Status Badge -->
                                <div class="mb-4">
                                    <h5>Status</h5>
                                    <span
                                        class="badge
                                   {{ $users->status == 'Active' ? 'bg-success' : ($users->status == 'Inactive' ? 'bg-secondary' : 'bg-warning') }}">
                                        {{ ucfirst($users->status) }}
                                    </span>
                                </div>


                                <!-- Account Name Field -->
                                <div class="mb-4 text-start">
                                    <h5>Account Name</h5>
                                    <p class="form-control-plaintext">{{ $users->name }}</p>
                                </div>

                                <!-- Email Field -->
                                <div class="mb-4 text-start">
                                    <h5>Email</h5>
                                    <p class="form-control-plaintext">{{ $users->email }}</p>
                                </div>

                                <!-- Phone Number Field -->
                                <div class="mb-4 text-start">
                                    <h5>Phone Number</h5>
                                    <p class="form-control-plaintext">{{ $users->mobile_no }}</p>
                                </div>

                                <!-- Address Field -->
                                <div class="mb-4 text-start">
                                    <h5>Address</h5>
                                    <p class="form-control-plaintext">{{ $users->address }}</p>
                                </div>
                                <div class="mb-4 text-start">
                                    <h5>Country</h5>
                                    <p class="form-control-plaintext">{{ $users->country   }}</p>
                                </div>
                                <div class="mb-4 text-start">
                                    <h5>Flat Rate</h5>
                                    <p class="form-control-plaintext">{{ $users->flat_rate }}</p>
                                </div>
                            </div>
                        </div>
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
        </script>
    @endsection

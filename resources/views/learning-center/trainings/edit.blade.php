@extends('layouts.master', ['module' => 'learning-center'])

@section('title')
    Edit Training Info - Learning Center
@endsection

@section('customStyles')

    <style>
        .has-file {
            display: none;
        }

        .drop-zone {
            position: relative;
            border: 2px dashed #e0b1cb;
            background-color: #fef5f9;
            padding: 2rem;
            text-align: center;
            border-radius: 12px;
            transition: border-color 0.3s ease-in-out;
        }

        .drop-zone.is-dragover {
            border-color: #d66ba0;
            background-color: #fff0f7;
        }

        /* .drop-zone input[type="file"] {
                display: none;
            } */

        .drop-zone .msg {
            font-size: 14px;
            color: #666;
        }

        .drop-zone.has-files .msg {
            display: none;
        }

        /* Remove button */
        .preview .remove {
            margin-top: 5px;
            background-color: #e74c3c;
            border: none;
            color: #fff;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .preview .remove:hover {
            background-color: #c0392b;
            /* border:1px solid #c0392b; */
        }

        .file-preview {
            border: 2px solid #cd7faf;
            background: white;
            padding: 6px;
            border-radius: 7px;
        }

        .preview p {
            font-size: 11.5px;
            margin: 0;
            color: #333;
            /* word-break: break-all; */
            font-weight: 500;

        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">

            <div class="col-lg-12">
                <h1 class="f-32 mb-0 w-600 ">Learning Center</h1>
                <p class="f-14 text-gray w-500 mt-1">Update and manage your account</p>
            </div>

            {{-- include menu --}}
            <div class="col-lg-3">
                @include('learning-center.menu')
            </div>

            {{-- main content --}}
            <div class="col-lg-8 ">
                <div class="row">
                    <div class="col-lg-12 ">

                        {{-- include alerts --}}
                        @include('common.alerts')

                        <h1 class="f-22 w-600 text-black text-center">{{ $training->brand->title }}</h1>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="f-22 w-600 text-bl">Edit Training Info</h1>
                        </div>

                        <!-- Tab content -->
                        <div class="tab-content-learinig">
                            <form action='{{ URL::to("/learning-center/training/$training->id") }}' method="POST"
                                enctype="multipart/form-data" class="sign__frame-right--form">
                                @csrf
                                @method('PUT')

                                {{-- brand_id --}}
                                <input type="hidden" name="brand_id" value="{{ $training->brand->id }}">

                                {{-- title --}}
                                <div class="col-md-12 form-floating mb-4">
                                    <input type="text" class="form-control sign-input" id="floatingInput" name="title"
                                        placeholder="" value="{{ $training->title }}" required>
                                    <label for="floatingInput" class="sign-label">Training Title</label>
                                </div>

                                {{-- description --}}
                                <div class="col-md-12 form-floating mb-4">
                                    <textarea class="form-control sign-input" placeholder="Leave a comment here"
                                        id="floatingTextarea2" name="description"
                                        style="height:100px">{{ $training->description }}</textarea>
                                    <label for="floatingTextarea2 " class="sign-label">Description</label>
                                </div>

                            <div class="row col-md-12">
									<h1 class="f-32 w-600 text-black">{{ 'Files' }}</h1>

                                @forelse ($trainingFile as $f)
                                    <div class="col-lg-4 mb-3">
                                        <div class="file-card position-relative">
                                            <a type="button"
                                                class="badge bg-danger text-white file-delete-btn position-absolute top-0 end-0 m-1"
                                                data-file-id="{{ $f->id }}" data-file-path="{{ $f->files }}"
                                                onclick="deletefunction({{$f->id}})" title="Delete File"
                                                style="transform: translate(5px, -5px); z-index: 2; border:none;">
                                                {{-- <i class="fas fa-trash-alt fa-xs"></i> --}}
                                                X
                                            </a>

                                            <!-- File content with improved layout -->
                                            <a href="{{ URL::to('storage/files/trainings/' . $f->files) }}"
                                                class="d-flex flex-column align-items-center text-decoration-none text-dark h-100 p-3">
                                                @php
                                                    $extension = pathinfo($f->files, PATHINFO_EXTENSION);
                                                    $icon = match (strtolower($extension)) {
                                                        'pdf' => 'fa-file-pdf',
                                                        'doc', 'docx' => 'fa-file-word',
                                                        'xls', 'xlsx' => 'fa-file-excel',
                                                        'jpg', 'jpeg', 'png', 'gif' => 'fa-file-image',
                                                        default => 'fa-file'
                                                    };
                                                @endphp
                                                <i class="fas {{ $icon }} fa-2x text-primary mb-2"></i>

                                                <!-- File Name (Truncated) -->
                                                <span class="file-name text-truncate w-100 px-2" title="{{ $f->files }}">
                                                    {{ basename($f->name) }}
                                                </span>

                                                <!-- File Size (Optional - if you have this data) -->
                                                @if(isset($f->size))
                                                    <small class="text-muted mt-1">{{ formatFileSize($f->size) }}</small>
                                                @endif
                                            </a>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="col-lg-4 mb-3">
                                        <div class="file-card position-relative">
                                            No File Found !
                                        </div></div>
                                    @endforelse

                                </div>

                                {{-- file --}}
                                <div class="col-md-12 mb-4">
                                    <div class="col-md-12 mb-4">
                                        <h1 class="text-gray f-16 w-500">Upload your info (mp4/mkv)*</h1>
                                        <p class="f-12 w-500 sign-label text-gray">Maximum size: 2 MB • Maximum
                                            attachments allowed: 1</p>
                                        <div class="mb-lg-4 mb-3 pb-2 w-100">
                                            <div class="drop-zone p-3 rounded">
                                                <!-- Allow multiple files by adding 'multiple' attribute -->
                                                <input type="file" class="receiver" name="file[]" multiple />
                                                <div class="msg">
                                                    <svg class="mb-3" width="39" height="39" viewBox="0 0 39 39" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <g clip-path="url(#clip0_483_13565)">
                                                            <path
                                                                d="M29.2078 11.6123C28.6699 11.505 28.2295 11.1687 28.002 10.6877C25.4833 5.37229 19.6446 2.40017 13.8092 3.47592C8.49225 4.45092 4.32413 8.69542 3.43525 14.04C3.172 15.6179 3.1915 17.1974 3.48888 18.7363C3.58638 19.2384 3.37025 19.7974 2.92663 20.2004C1.066 21.892 0 24.3019 0 26.8142C0 31.7412 4.00887 35.7517 8.9375 35.7517H26.8125C33.5335 35.7517 39 30.2852 39 23.5642C39 17.771 34.8823 12.7433 29.2078 11.6123ZM26.8125 32.5H8.9375C5.80125 32.5 3.25 29.9488 3.25 26.8125C3.25 25.2152 3.92925 23.6795 5.11225 22.6038C6.3895 21.4419 6.98913 19.7227 6.67713 18.1139C6.45288 16.9569 6.43988 15.7658 6.63812 14.5698C7.293 10.634 10.4812 7.38567 14.391 6.66904C15.0166 6.55529 15.639 6.50004 16.2533 6.50004C20.0103 6.50004 23.4114 8.59467 25.064 12.0803C25.7351 13.4973 27.014 14.4885 28.5708 14.7989C32.7308 15.6293 35.7484 19.3148 35.7484 23.5642C35.7484 28.4912 31.7379 32.5017 26.8109 32.5017L26.8125 32.5ZM24.5716 19.9762C25.207 20.6115 25.207 21.6385 24.5716 22.2739C24.2548 22.5908 23.8387 22.75 23.4227 22.75C23.0068 22.75 22.5907 22.5908 22.2739 22.2739L19.5 19.5V27.625C19.5 28.5237 18.772 29.25 17.875 29.25C16.978 29.25 16.25 28.5237 16.25 27.625V19.5L13.4761 22.2739C12.8408 22.9093 11.8138 22.9093 11.1784 22.2739C10.543 21.6385 10.543 20.6115 11.1784 19.9762L15.5773 15.5773C16.2045 14.95 17.0284 14.6348 17.8522 14.6299L17.875 14.625L17.8978 14.6299C18.7232 14.6348 19.5455 14.95 20.1727 15.5773L24.5716 19.9762Z"
                                                                fill="#2E2C34" />
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_483_13565">
                                                                <rect width="39" height="39" fill="white" />
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                    <p class="w-100 f-14 w-500">
                                                        Drag and drop here or <a class="text-primary mx-2">browse</a> video
                                                        to
                                                        attach
                                                    </p>
                                                    <p class="mb-0 pb-0 f-12 w-600 text-gray">Maximum size: 2 MB • Maximum
                                                        attachments allowed: 1</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--
                                <div class="row w-100">
                                    <div class="col-md-6 form-floating mb-4">
                                        <input type="date" class="form-control sign-input" id="floatingInput"
                                            name="start_date" placeholder="" value="{{ $training->start_date }}" required>
                                        <label for="floatingInput" class="sign-label">Start Date</label>
                                    </div>

                                    <div class="col-md-6 form-floating mb-4">
                                        <input type="date" class="form-control sign-input" id="floatingInput"
                                            name="end_date" placeholder="" value="{{ $training->end_date }}" required>
                                        <label for="floatingInput" class="sign-label">End Date</label>
                                    </div>
                                </div> --}}

                                <div class="form-floating mb-4 w-100">
                                    <button class="main-btn" type="subit" style="float: right;">Save</button>
                                </div>
                            </form>
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
                this.files = []; // Array to store all selected files
                this.currentInput = null; // Reference to current file input

                this.initializeEvents();
                this.createFileInput();
            }

            initializeEvents() {
                this.dropZone.on('dragover dragenter', () => this.dropZone.addClass('is-dragover'));
                this.dropZone.on('dragleave dragend drop', () => this.dropZone.removeClass('is-dragover'));
                this.dropZone.on('change', '.receiver', this.onchange.bind(this));
                this.dropZone.on('click', '.preview .remove', this.onRemove.bind(this));

                // Handle click on drop zone to trigger file input
                this.dropZone.on('click', (e) => {
                    if ($(e.target).closest('.preview').length === 0 &&
                        $(e.target).closest('.remove').length === 0) {
                        this.currentInput.click();
                    }
                });
            }

            createFileInput() {
                // Remove existing input if any
                if (this.currentInput) {
                    this.currentInput.remove();
                }

                // Create new file input
                this.currentInput = $('<input type="file" class="receiver" multiple>');
                this.dropZone.prepend(this.currentInput);
            }

            onchange(e) {
                const $receiver = $(e.target);
                const newFiles = Array.from($receiver[0].files);

                if (newFiles.length === 0) return;

                // Add new files to our collection
                this.files = [...this.files, ...newFiles];
                this.dropZone.addClass('has-files');

                // Create new input for future selections
                this.createFileInput();

                // Display previews for all files
                this.displayAllPreviews();
            }

            displayAllPreviews() {
                // Clear existing previews
                this.dropZone.find('.preview').remove();

                // Create previews for all files
                this.files.forEach((file, index) => {
                    const url = URL.createObjectURL(file);
                    const $template = this.template(url, file.type, file.name);
                    $template.data('file-index', index);
                    this.dropZone.append($template);
                });
            }

            onRemove(e) {
                const $button = $(e.currentTarget);
                const $preview = $button.closest('.preview');
                // const index = $preview.data('index');
                const index = $preview.data('file-index'); // <-- fixed

                // Remove the file from our collection
                if (index >= 0 && index < this.files.length) {
                    this.files.splice(index, 1);
                }

                // Revoke object URL if this was an image preview
                const $img = $preview.find('img');
                if ($img.length) {
                    URL.revokeObjectURL($img.attr('src'));
                }

                // Remove the preview
                $preview.remove();

                // Update UI state
                if (this.files.length === 0) {
                    this.dropZone.removeClass('has-files');
                } else {
                    // Re-index remaining previews
                    this.updatePreviewIndices();
                }
            }

            updatePreviewIndices() {
                this.dropZone.find('.preview').each((i, element) => {
                    $(element).data('index', i);
                });
                this.dropZone.find('.preview').each((i, element) => {
        $(element).data('file-index', i);
    });
            }
            template(url, type, name) {
                let content = `<p>${name}</p>`;
                return $(`
                    <div class="preview mb-3">
                        <div class="file-preview">${content}</div>
                        <div class="details text-end mt-1">
                            <button type="button" class="remove btn btn-sm btn-danger">X</button>
                        </div>
                    </div>
                `);
            }

            // Method to get all files for form submission
            getFiles() {
                return this.files;
            }
        }

        const dropZone = new DropZone();

        $('form').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(this);

            // Add all files to the FormData
            dropZone.getFiles().forEach((file, index) => {
                formData.append(`files[${index}]`, file);
            });

            // Submit the form
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
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
                                // window.location.href = '/learning-center/trainings';
                            }
                        });
                    } else {
                        console.log("Something went wrong!!!");
                    }
                }
            });
        });



        function deletefunction(id) {

            Swal.fire({
                title: 'Are you sure To Confirm This File?',
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
                        url: "/learning-center/training-file/" + id + "/delete",

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

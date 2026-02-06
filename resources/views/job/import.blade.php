@extends('layouts.master', ['module' => 'shifts'])

@section('title')
	Import Shifts
@endsection

@section('customStyles')
	{{-- dropzone --}}
	<link rel="stylesheet" href="https://rawgit.com/enyo/dropzone/master/dist/dropzone.css" />
	<style>
		.blushed-card {
			height: auto !important;
			;
		}
        a.btn.btn-primary{
            border-radius: 0;
            padding: 11px 10px;
            font-size:14px;
        }
        .sign-btn{

            border-radius: 0;
        }


	</style>
@endsection
@section('content')
	<div class="container">
		<div class="row mb-lg-4 mb-3 mt-lg-3 mt-3">
			<div class="col-md-8 mx-auto">

				{{-- include alerts --}}
				@include('common.alerts')

				<h1 class="f-32 w-600 ">Shifts / Schedule</h1>

				<div class="blushed-card mt-3 py-lg-4 px-lg-4">
					<h1 class="f-24 w-600">Import shifts</h1>
					<p class="f-18 w-500 " style="color: #84818A !important;">
						Please attach the xlxs file to import shifts / schedules
					</p>

					<form action="{{ URL::to('/shifts/import') }}" method="post" enctype="multipart/form-data">
						@csrf

						<div class="row w-100 align-items-center">
							<div class="col-md-12">
								<input type="file" name="shifts">
                                <br>
					<div class="btn-group mt-3" style="float:right;">
						<button class="sign-btn " style="float:right;">Import</button>
						<a href="{{ asset('assets/files/newsample.xlsx') }}" class="btn btn-primary">Download
							Sample</a>
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
				// in order to remove them both when click on .remove
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

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Recap Report</title>
	<style>
		body {
			padding: 20px;
			color: #333;
            font-family: 'Manrope', sans-serif;
			font-size: 12px;
            /* font-feature-settings: "clig" off, "liga" off; */
    font-size: 14px;
    font-style: normal;
    font-weight: 600;
    line-height: 20px;

}
td>strong{
    color: #333;
            font-family: 'Manrope', sans-serif;
			font-size: 12px;
            /* font-feature-settings: "clig" off, "liga" off; */
    font-size: 14px;
    font-style: normal;
    /* font-weight: 600; */
    line-height: 20px;

}
		.header {
			text-align: center;
			margin-bottom: 20px;
		}

		.header h2 {
			margin: 0;
			font-size: 20px;
			color: #cd7faf;
		}

		.info-table {
			width: 100%;
			margin-bottom: 20px;
		}

		.info-table td {
			padding: 5px 10px;
		}

		.question {
			margin-bottom: 12px;
			border-bottom: 1px dashed #cd7faf;
			padding-bottom: 8px;
		}

		.question-title {
			font-weight: bold;
			margin-bottom: 5px;
		}

		.answer {
			margin-left: 15px;
		}

		.checkbox-option, .radio-option {
			display: inline-block;
			margin-right: 10px;
		}

		.image-preview {
			margin-top: 8px;
		}

		.image-preview img {
			height: 80px;
			border: 1px solid #cd7faf;
			border-radius: 4px;
		}

		.page-break {
			page-break-after: always;
		}
	</style>
</head>
<body>

	<div class="header">
		<h2>User Recap Report</h2>
	</div>

	<table class="info-table">
		<tr>
			<td><strong>Name:</strong> {{ $user_recap->user->name ?? 'N/A' }}</td>
			<td><strong>Date:</strong> {{ now()->format('d M Y') }}</td>
		</tr>
		<tr>
			<td><strong>Recap ID:</strong> {{ $user_recap->id }}</td>
			<td><strong>Status:</strong> {{ ucfirst($user_recap->status) }}</td>
		</tr>
	</table>

	@foreach ($questions as $question)
		<div class="question">
			<div class="question-title">{{ $loop->iteration }}. {{ $question->recap_question }} *</div>
			<div class="answer">
				@php
					$answer = $question->recap_question_answer;
				@endphp

				@if($question->recap_question_type == 'input-question' || $question->recap_question_type == 'textarea-question' || $question->recap_question_type == 'date-question')
					{{ $answer ?? 'N/A' }}

					@elseif($question->recap_question_type == 'select-question')
					{{ $answer ?? 'N/A' }}
				@elseif($question->recap_question_type == 'checkbox-question')
					<div class="d-flex">
						@php
							$boxes = explode(',', $question->recap_question_options);
							$question->recap_question_answer = explode(
								',',
								$question->recap_question_answer,
							);
						@endphp
						{{-- @foreach ($boxes as $box) --}}

							<div class="form-check ">
								{{ $answer }}
							</div>
						{{-- @endforeach --}}
					</div>
                    @elseif($question->recap_question_type == 'radio-question')
                    <div class="d-flex">
                        {{ $answer ?? 'N/A' }}

                    </div>



				@elseif($question->recap_question_type == 'image-question')
					@if ($answer)
						<div class="image-preview">
							<img src="{{ public_path('storage/images/recaps/sm/' . $answer) }}" alt="Recap Image">
						</div>
					@else
						No image provided.
					@endif
				@endif
			</div>
		</div>
	@endforeach

</body>
</html>

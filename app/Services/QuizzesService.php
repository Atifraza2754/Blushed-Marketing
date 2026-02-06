<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\Brand;
use App\Models\UserQuiz;
use Illuminate\Support\Str;
use App\Models\QuizQuestion;
use App\Traits\FilesHandler;
use Illuminate\Http\Request;
use App\Models\QuizQuestionOption;
use App\Traits\Base64FilesHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Storage;

class QuizzesService extends BaseService
{
    use FilesHandler;
    use Base64FilesHandler;

    /*
    |=========================================================
    | Get listing of all quizzes
    |=========================================================
    */
    public function get_all_quizzes($filter)
    {
        $quizzes = Quiz::with('brand', 'admin')
            ->withCount('questions')
            ->orderBy('id', 'ASC');
        // dd($quizzes);

        // apply filters
        if ($filter == 'active') {
            $quizzes = $quizzes->where('status', true);
        }
        if ($filter == 'inactive') {
            $quizzes = $quizzes->where('status', false);
        }

        $quizzes = $quizzes->get();

        return [
            'status' => 200,
            'quizzes' => $quizzes
        ];
    }

    /*
    |=========================================================
    | Get listing of all user-quizzes
    |=========================================================
    */
    public function get_user_quizzes($filter)
    {
        $quizzes = UserQuiz::with('user', 'quiz.brand')
            ->orderBy('id', 'ASC');
        // dd($quizzes);

        // apply filters
        if ($filter == 'pending') {
            $quizzes = $quizzes->where('status', 'pending');
        }
        if ($filter == 'completed') {
            $quizzes = $quizzes->where('status', 'completed');
        }

        $quizzes = $quizzes->get();

        return [
            'status' => 200,
            'quizzes' => $quizzes
        ];
    }

    /*
    |=========================================================
    | Get listing of all active quizzes
    |=========================================================
    */
    public function get_active_quizzes()
    {
        $quizzes = Quiz::with('brand', 'admin')
            ->withCount('questions')
            ->where('status', TRUE)
            ->get();
        // dd($quizzes);

        if ($quizzes) {
            return [
                'status' => 200,
                'quizzes' => $quizzes
            ];
        }

        return [
            'status' => 100,
            'message' => "Sorry, something went wrong"
        ];
    }

    /*
    |=========================================================
    | Store new quiz in storage
    |=========================================================
    */
    public function add_new_quiz($data)
    {
        if ($data) {

            DB::beginTransaction();
            $brand_id = $data['brand_id'];

            $formData = [
                'user_id' => Auth::id(),
                'brand_id' => $brand_id,
                'title' => $data['title'],
                'description' => $data['description'],
                'no_of_questions' => 0,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            // if (isset($data['image'])) {
            //     $image_file = $data['image'];
            //     $base64_file = $this->file64($image_file);

            //     // SAVE BASE64 IMAGE IN STORAGE
            //     $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/quizzes/", true);

            //     $formData['image'] = $saved_image->file_name;
            // }

            if (isset($data['image'])) {
                $image_file = $data['image'];

                // Convert the new image to Base64 format
                $base64_file = $this->file64($image_file);

                // $lg = "images/quizzes/lg/$quiz->image";
                // $md = "images/quizzes/md/$quiz->image";
                // $sm = "images/quizzes/sm/$quiz->image";

                // Check if the file exists and remove it
                // if (Storage::disk('public')->exists($lg)) {
                //     Storage::disk('public')->delete($lg);
                // }
                // if (Storage::disk('public')->exists($md)) {
                //     Storage::disk('public')->delete($md);
                // }
                // if (Storage::disk('public')->exists($sm)) {
                //     Storage::disk('public')->delete($sm);
                // }
                // Save the new image as Base64 in storage
                $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/quizzes/", true);
                // Update the image in formData with the new file name
                $formData['image'] = $saved_image->file_name;
            }

            $quiz_id = Quiz::insertGetId($formData);

            // add quiz questions
            // $questions = $data['questions'];
            // if ($quiz_id) {
            //     $this->add_quiz_questions($questions, $quiz_id);
            // }

            // update brand quiz upload status
            Brand::where('id', $brand_id)->update(['is_quiz_uploaded' => true]);

            DB::commit();

            return [
                'status' => 200,
                'message' => 'New quiz is added successfully',
                'quiz_id' => $quiz_id
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }

    /*
    |=========================================================
    | Get listing of all questions for this quiz
    |=========================================================
    */
    public function get_all_questions($id)
    {
        $questions = QuizQuestion::where('quiz_id', $id)
            ->with('quiz.brand')
            ->withCount('options')
            ->where('status', TRUE)
            ->get();
        // dd($questions);

        if ($questions) {
            return [
                'status' => 200,
                'questions' => $questions
            ];
        }

        return [
            'status' => 100,
            'message' => "Sorry, something went wrong"
        ];
    }

    /*
    |=========================================================
    | Store new quiz-questions in storage
    |=========================================================
    */
    public function add_quiz_questions($data, $quiz_id)
    {
        if (!empty($data) && !empty($quiz_id)) {

            $formData = [
                'quiz_id' => $quiz_id,
                'title' => $data['question'],
                'description' => null,
                'answer' => $data['answer'],
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            $question_id = QuizQuestion::insertGetId($formData);

            // add question options
            $options = $data['options'];
            // dd($options);
            if ($question_id) {
                $this->add_quiz_question_options($options, $question_id);
            }

            return [
                'status' => 200,
                'message' => 'New question is added successfully'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }

    /*
    |=========================================================
    | Store new quiz question options in storage
    |=========================================================
    */
    public function add_quiz_question_options($options, $question_id)
    {
        if ($options) {

            foreach ($options as $option) {

                $formData = [
                    'quiz_question_id' => $question_id,
                    'option' => $option,
                    'type' => "text",
                    'status' => true,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];

                QuizQuestionOption::create($formData);
            }

            return [
                'status' => 200,
                'message' => 'New question option is added successfully'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }

    /*
    |=========================================================
    | Store new user-quiz in storage
    |=========================================================
    */
    public function add_user_quiz($data)
    {
        if ($data) {

            $formData = [
                'user_id' => $data['user_id'],
                'quiz_id' => $data['quiz_id'],
                'status' => $data['status'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            UserQuiz::create($formData);

            return [
                'status' => 200,
                'message' => 'User quiz is added successfully'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }

    /*
    |=========================================================
    | Get specific quiz details
    |=========================================================
    */
    public function get_quiz_detail($id)
    {
        if ($id) {
            $quiz = Quiz::with('admin', 'brand')->where('id', $id)->first();
            // dd($quiz);

            if ($quiz) {
                return [
                    'status' => 200,
                    'quiz' => $quiz
                ];
            }
        }

        return [
            'status' => 100,
            'message' => "Sorry, something went wrong"
        ];
    }

    /*
    |=========================================================
    | Update quiz details in storage
    |=========================================================
    */
    public function update_quiz($data, $id)
    {
        $quiz = Quiz::findorfail($id);
        if ($data) {

            $formData = [
                'user_id' => Auth::id(),
                'brand_id' => $data['brand_id'],
                'title' => $data['title'],
                // 'slug'       => Str::slug($data['title']),
                'description' => $data['description'],
                'no_of_questions' => $data['no_of_questions'],
                'status' => $data['status'],
            ];
            if ($data['image']) {
                $image_file = $data['image'];

                // Convert the new image to Base64 format
                $base64_file = $this->file64($image_file);

                $lg = "images/quizzes/lg/$quiz->image";
                $md = "images/quizzes/md/$quiz->image";
                $sm = "images/quizzes/sm/$quiz->image";

                // Check if the file exists and remove it
                if (Storage::disk('public')->exists($lg)) {
                    Storage::disk('public')->delete($lg);
                }
                if (Storage::disk('public')->exists($md)) {
                    Storage::disk('public')->delete($md);
                }
                if (Storage::disk('public')->exists($sm)) {
                    Storage::disk('public')->delete($sm);
                }
                // Save the new image as Base64 in storage
                $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/quizzes/", true);
                // Update the image in formData with the new file name
                $formData['image'] = $saved_image->file_name;
            }
            Quiz::where('id', $id)->update($formData);

            return [
                'status' => 200,
                'message' => 'Quiz information is updated successfully'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }

    /*
    |=========================================================
    | Update questions and options details in storage
    |=========================================================
    */
    public function update_questions($data, $quiz_id)
    {
        if ($data && $quiz_id) {

            if (!empty($data)) {
                $questions = $data;
            } else {
                return [
                    'status' => 100,
                    'message' => 'Sorry, something went wrong'
                ];
            }
            $array = array_values($questions);

            // remove old questions and their options
            QuizQuestionOption::whereIn('quiz_question_id', QuizQuestion::where('quiz_id', $quiz_id)->pluck('id'))->delete();
            $old_img = QuizQuestion::where('quiz_id', $quiz_id)
                ->orderBy('id', 'ASC')
                ->whereNull('deleted_at')
                ->get();

            foreach ($old_img as $quiz) {
                $deleteImage = true;

                foreach ($array as $ar) {
                    $image_name = $ar['image_name'] ?? null;

                    if ($quiz->image == $image_name) {
                        $deleteImage = false;
                        break;
                    }
                }

                if ($deleteImage) {
                    $lg = "images/quizzes/lg/$quiz->image";
                    $md = "images/quizzes/md/$quiz->image";
                    $sm = "images/quizzes/sm/$quiz->image";

                    // Delete the images if they exist
                    if (Storage::disk('public')->exists($lg)) {
                        Storage::disk('public')->delete($lg);
                    }
                    if (Storage::disk('public')->exists($md)) {
                        Storage::disk('public')->delete($md);
                    }
                    if (Storage::disk('public')->exists($sm)) {
                        Storage::disk('public')->delete($sm);
                    }
                }
            }

            QuizQuestion::where('quiz_id', $quiz_id)->delete();

            foreach ($array as $question) {
                if (isset($question['title']) && isset($question['answer'])) {
                    $formData['title'] = $question['title'];
                }
                if (isset($question['answer'])) {
                    $formData['answer'] = $question['answer'];
                }
                $formData['quiz_id'] = $quiz_id;
                if (isset($question['image'])) {
                    $image_file = $question['image'];

                    // Convert the new image to Base64 format
                    $base64_file = $this->file64($image_file);

                    // $lg = "images/quizzes/lg/$quiz->image";
                    // $md = "images/quizzes/md/$quiz->image";
                    // $sm = "images/quizzes/sm/$quiz->image";

                    // Check if the file exists and remove it
                    // if (Storage::disk('public')->exists($lg)) {
                    //     Storage::disk('public')->delete($lg);
                    // }
                    // if (Storage::disk('public')->exists($md)) {
                    //     Storage::disk('public')->delete($md);
                    // }
                    // if (Storage::disk('public')->exists($sm)) {
                    //     Storage::disk('public')->delete($sm);
                    // }
                    // Save the new image as Base64 in storage
                    $saved_image = (object) $this->uploadBase64File($base64_file, "public", "images/quizzes/", true);
                    // Update the image in formData with the new file name
                    if ($saved_image->file_name != '') {

                        $formData['image'] = $saved_image->file_name;
                    } else {
                        $formData['image'] = $question['image_name'];

                    }
                } else {
                    $formData['image'] = $question['image_name'] ?? '';

                }
                $question_id = QuizQuestion::insertGetId($formData);

                if (isset($question['options'])) {

                    foreach ($question['options'] as $option) {
                        QuizQuestionOption::create([
                            'quiz_question_id' => $question_id,
                            'option' => $option,
                            'type' => 'text', // change 'text' if needed
                            'status' => true,
                        ]);
                    }
                }
            }

            return [
                'status' => 200,
                'message' => 'Questions information is updated successfully'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }

    /*
    |=========================================================
    | Soft delete specific quiz -- by id
    |=========================================================
    */
    public function soft_delete_quiz($id)
    {
        if ($id) {

            $is_deleted = Quiz::where('id', $id)->delete();
            if ($is_deleted) {
                return [
                    'status' => 200,
                    'message' => 'Success, quiz is archieved'
                ];
            }
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }

    /*
    |=========================================================
    | Hard delete specific quiz -- by id
    |=========================================================
    */
    public function permanently_delete_quiz($id)
    {
        if ($id) {

            $is_deleted = Quiz::where('id', $id)->forceDelete();
            if ($is_deleted) {
                return [
                    'status' => 200,
                    'message' => 'Success, quiz is deleted permanently'
                ];
            }
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }

    /*
    |=========================================================
    | Soft delete specific quiz-question -- by id
    |=========================================================
    */
    public function soft_delete_question($id)
    {
        if ($id) {

            $is_deleted = QuizQuestion::where('id', $id)->delete();
            if ($is_deleted) {
                return [
                    'status' => 200,
                    'message' => 'Success, quiz question is archieved'
                ];
            }
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }

    /*
    |=========================================================
    | Soft delete specific question-option -- by id
    |=========================================================
    */
    public function soft_delete_option($id)
    {
        if ($id) {

            $is_deleted = QuizQuestionOption::where('id', $id)->delete();
            if ($is_deleted) {
                return [
                    'status' => 200,
                    'message' => 'Success, question option is archieved'
                ];
            }
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }

}

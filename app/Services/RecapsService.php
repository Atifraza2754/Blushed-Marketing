<?php
namespace App\Services;

use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Recap;
use App\Models\Userrecap;
use Illuminate\Support\Str;
use App\Traits\FilesHandler;
use Illuminate\Http\Request;
use App\Models\RecapQuestion;
use App\Traits\Base64FilesHandler;
use Illuminate\Support\Facades\DB;
use App\Models\recapQuestionOption;
use Illuminate\Support\Facades\Auth;

class RecapsService extends BaseService
{
    use FilesHandler;
    use Base64FilesHandler;

    /*
    |=========================================================
    | Get listing of all recaps
    |=========================================================
    */
    public function get_all_recaps($filter)
    {
        $recaps = Recap::with('brand', 'admin')
            ->withCount('questions')
            ->orderBy('id', 'ASC');
        // dd($recaps);

        // apply filters
        if ($filter == 'active') {
            $recaps = $recaps->where('status', true);
        }
        if ($filter == 'inactive') {
            $recaps = $recaps->where('status', false);
        }

        $recaps = $recaps->get();

        return [
            'status' => 200,
            'recaps' => $recaps
        ];
    }



    /*
    |=========================================================
    | Get listing of all user-recaps
    |=========================================================
    */
    public function get_user_recaps($filter)
    {
        $recaps = UserRecap::with('user', 'recap.brand')
            ->orderBy('id', 'ASC');
        // dd($recaps);

        // apply filters
        if ($filter == 'pending') {
            $recaps = $recaps->where('status', 'pending');
        }
        if ($filter == 'completed') {
            $recaps = $recaps->where('status', 'completed');
        }

        $recaps = $recaps->get();

        return [
            'status' => 200,
            'recaps' => $recaps
        ];
    }



    /*
    |=========================================================
    | Get listing of all active recaps
    |=========================================================
    */
    public function get_active_recaps()
    {
        $recaps = Recap::with('brand', 'admin')
            ->withCount('questions')
            ->where('status', TRUE)
            ->get();
        // dd($recaps);

        if ($recaps) {
            return [
                'status' => 200,
                'recaps' => $recaps
            ];
        }

        return [
            'status' => 100,
            'message' => "Sorry, something went wrong"
        ];
    }



    /*
    |=========================================================
    | Store new recap in storage
    |=========================================================
    */
    public function add_new_recap($data)
    {
        if ($data) {

            $questions = $data['questions'];
            $questiontypes = $data['questiontypes'];
            $options = $data['answers'];

            DB::beginTransaction();

            $brand_id = $data['brand_id'];

            $recap_id = Recap::insertGetId([
                'user_id' => Auth::id(),
                'brand_id' => $brand_id,
                'title' => $data['title'],
                'description' => null,
                // 'event_date' => $data['event_date'],
                // 'due_date' => $data['due_date'],
                'no_of_questions' => count($questions),
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            for ($i = 0; $i < count($questions); $i++) {
                RecapQuestion::create([
                    'recap_id' => $recap_id,
                    'title' => $questions[$i],
                    'slug' => Str::slug($questions[$i]),
                    'description' => null,
                    'question_type' => $questiontypes[$i],
                    'options' => $options[$i] ?? null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }

            // update brand recap upload status
            Brand::where('id', $brand_id)->update(['is_recap_uploaded' => true]);

            DB::commit();

            return [
                'status' => 200,
                'message' => 'New recap is added successfully'
            ];
        }

        DB::rollback();

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Store new user-recap in storage
    |=========================================================
    */
    public function add_user_recap($data)
    {
        if ($data) {

            $formData = [
                'user_id' => $data['user_id'],
                'recap_id' => $data['recap_id'],
                'status' => $data['status'],
            ];

            UserRecap::create($formData);

            return [
                'status' => 200,
                'message' => 'User recap is added successfully'
            ];
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Get specific recap details
    |=========================================================
    */
    public function get_recap_detail($id)
    {
        if ($id) {
            $recap = Recap::where('id', $id)
                ->with([
                    'admin',
                    'brand',
                    'questions'
                ])
                ->first();

            // dd($recap);

            if ($recap) {
                return [
                    'status' => 200,
                    'recap' => $recap
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
    | Update recap details in storage
    |=========================================================
    */
    public function update_recap($data, $id)
    {
        if ($data && $id) {
            $questions = $data['questions'] ?? [];
            $questiontypes = $data['questiontypes'] ?? [];
            $options = $data['answers'] ?? [];

            DB::beginTransaction();

            $brand_id = $data['brand_id'];
            
            $recap_id = Recap::where('id', $id)->update([
                'user_id' => Auth::id(),
                'brand_id' => $brand_id,
                'title' => $data['title'],
                'description' => null,
                'event_date' => $data['event_date'] ?? null,
                'due_date' => $data['due_date'] ?? null,
                'no_of_questions' => count($questions) ?? 0,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Remove old recap questions
            RecapQuestion::where('recap_id', $id)->delete();

            $qu_count = count($questions) ?? 0;
            if ($qu_count > 0) {
                // add update form recap questions
                for ($i = 0; $i < $qu_count; $i++) {
                    RecapQuestion::create([
                        'recap_id' => $id,
                        'title' => $questions[$i],
                        'slug' => Str::slug($questions[$i]),
                        'description' => null,
                        'question_type' => $questiontypes[$i],
                        'options' => $options[$i] ?? null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
            // update brand recap upload status
            Brand::where('id', $brand_id)->update(['is_recap_uploaded' => true]);

            DB::commit();

            return [
                'status' => 200,
                'message' => 'Recap is updated successfully'
            ];
        }

        DB::rollback();

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }



    /*
    |=========================================================
    | Soft delete specific recap -- by id
    |=========================================================
    */
    public function soft_delete_recap($id)
    {
        if ($id) {

            $is_deleted = Recap::where('id', $id)->delete();
            if ($is_deleted) {
                return [
                    'status' => 200,
                    'message' => 'Success, recap is archieved'
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
    | Hard delete specific recap -- by id
    |=========================================================
    */
    public function permanently_delete_recap($id)
    {
        if ($id) {

            $is_deleted = Recap::where('id', $id)->forceDelete();
            if ($is_deleted) {
                return [
                    'status' => 200,
                    'message' => 'Success, recap is deleted permanently'
                ];
            }
        }

        return [
            'status' => 100,
            'message' => 'Sorry, something went wrong'
        ];
    }

}

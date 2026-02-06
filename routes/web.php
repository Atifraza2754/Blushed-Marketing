<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// COMMON CONTROLLERS
use App\Http\Controllers\Common\DashboardController;
use App\Http\Controllers\Common\SettingsController;

use App\Http\Controllers\Common\InvitesController;
use App\Http\Controllers\Common\TeamsController;
use App\Http\Controllers\Common\JobsController;
use App\Http\Controllers\Common\ShiftsController;

use App\Http\Controllers\Common\BrandsController;
use App\Http\Controllers\Common\TrainingsController;
use App\Http\Controllers\Common\InfosController;
use App\Http\Controllers\Common\QuizzesController;
use App\Http\Controllers\Common\RecapsController;
use App\Http\Controllers\Common\UserRecapsController;
use App\Http\Controllers\Common\PaymentsController;

use App\Http\Controllers\Common\OnboardingController;
use App\Http\Controllers\Common\MessagesController;
use App\Http\Controllers\Common\NotificationsController;
use App\Http\Controllers\Common\ClockTImeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/otp', [AuthController::class, 'otpEmail']);
Route::get('/generate-pdf', [UserRecapsController::class, 'generatePdfAndUpload']);

/*
|==========================================================================
| AUTHENTICATION ROUTES
|==========================================================================
*/
Route::get('/', [AuthController::class, 'loginForm'])->middleware();
Route::get('/admin-login', [AuthController::class, 'loginForm'])->middleware();
Route::get('/login', [AuthController::class, 'loginForm'])->middleware();
Route::post('/login', [AuthController::class, 'login']);

Route::get('/invite/{email}/step-1', [AuthController::class, 'inviteSignupForm1']);
Route::get('/invite/{email}/step-2', [AuthController::class, 'inviteSignupForm2']);

Route::get('/register/step-1', [AuthController::class, 'signupForm1']);
Route::post('/register/step-1', [AuthController::class, 'registerStep1']);
Route::get('/register/step-2', [AuthController::class, 'signupForm2']);
Route::post('/register/step-2', [AuthController::class, 'registerStep2']);

// RESET PASSWORD
Route::get('/forget-password', [AuthController::class, 'forgetPasswordForm']);
Route::post('/forget-password', [AuthController::class, 'sendOTP']);
Route::get('/verify-otp', [AuthController::class, 'verifyOTPForm']);
Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);
Route::get('/reset-password', [AuthController::class, 'resetPasswordForm']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('auth:sanctum');

// LOGOUT
Route::get('/logout', [AuthController::class, 'logout']);

/*
|==========================================================================
| ADMIN-PANEL ROUTES
|==========================================================================
*/
Route::group(
    ['prefix' => '/', 'middleware' => ['isLogin']],
    function () {

        // DASHBOARD
        Route::get('dashboard', [DashboardController::class, 'index']);
        Route::get('published-shift', [DashboardController::class, 'publishedShifts']);
        Route::get('import-shift', [DashboardController::class, 'importedShifts']);
        Route::get('open-shift-user', [DashboardController::class, 'openShiftUser']);
        Route::get('/user_recap', [DashboardController::class, 'userRecap'])->name('user_recap ');

        Route::get('/user_quiz', [DashboardController::class, 'userquiz'])->name('userquiz ');
        // PROFILE-INFORMATION
        Route::get('settings', [SettingsController::class, 'settings']);
        Route::post('settings/profile', [SettingsController::class, 'updateProfile']);
        Route::post('settings/password', [SettingsController::class, 'updatePassword']);


        //user profile setting
         Route::get('/user-setting/{id}', [SettingsController::class, 'userSettings']);
        Route::post('/user-settings/profile', [SettingsController::class, 'updateProfile']);
        Route::post('/user-settings/password', [SettingsController::class, 'updatePassword']);
        Route::post('/user-settings/documents', [SettingsController::class, 'updateDocuments']);


        Route::get('/site-settings', [SettingsController::class, 'siteSettings']);
        Route::post('/site-setting-update', [SettingsController::class, 'siteSettingsStore']);

        // NOTIFICATIONS
        Route::get('notifications', action: [NotificationsController::class, 'index']);

        // BRANDS
        Route::resource('brands', BrandsController::class);

        /*-------- LEARNING-CENTER -------*/
        // Route::get('learning-center', [LearningCenterController::class, 'index']);
//
        /*-------- INVITES -------*/
        // INVITE ADMINS
        Route::get('admin/invites', [InvitesController::class, 'adminInvites']);
        Route::get('admin/invites/create', [InvitesController::class, 'createAdminInvites']);
        Route::post('admin/invites/store', [InvitesController::class, 'storeAdminInvites']);
        // INVITE USERS
        Route::get('user/invites', [InvitesController::class, 'userInvites']);
        Route::get('user/invites/create', [InvitesController::class, 'createUserInvites']);
        Route::post('user/invites/store', [InvitesController::class, 'storeUserInvites']);

        //upload bulk user
        Route::get('admin/bulk-upload', [InvitesController::class, 'bulkUploadView']);
        Route::post('admin/bulk-upload/store', [InvitesController::class, 'bulkUploadStore']);

        /*-------- TEAMS -------*/
        Route::get('team', [TeamsController::class, 'getAllTeamMembers']);
        Route::get('getLeadUser', [TeamsController::class, 'getLeadUser']);
        Route::post('update/lead-user', [TeamsController::class, 'updateLeadUser']);
        Route::get('make-lead/{id}', [TeamsController::class, 'MakeTeamLead']);
        Route::get('team/{id}', [TeamsController::class, 'showMemberDetail']);
        Route::get('team/{id}', [TeamsController::class, 'showMemberDetail']);
        Route::post('team/flat-rate', [TeamsController::class, 'setFlatRate']);
        Route::post('team/notify', [TeamsController::class, 'notifyTeamMember']);
        Route::post('team/terminate', [TeamsController::class, 'terminateTeamMember']);
        Route::get('onboarding/{id}', [TeamsController::class, 'Onboarding']);
        Route::post('onboardingchangestatus', [TeamsController::class, 'OnboardingChangeStatus']);


        /*-------- RECAPS -------*/
        Route::get('recaps/{slug?}', [UserRecapsController::class, 'index']);
        Route::get('recap/{id}', [UserRecapsController::class, 'edit']);
        Route::post('recap/{id}/reject-with-edit', [UserRecapsController::class, 'rejectWithEdit']);
        Route::post('recap/{id}/approve-with-edit', [UserRecapsController::class, 'approveWithEdit']);
        Route::post('recap/{id}/approve-with-feedback', [UserRecapsController::class, 'approveWithFeedback']);
        Route::post('recap/{id}/approve-with-rating', [UserRecapsController::class, 'approveWithRating']);
        Route::post('recap/approve-with-rating/multiple', [UserRecapsController::class, 'approveWithRatingMultiple']);
        Route::post('recap/{id}', [UserRecapsController::class, 'storeRecapAnswers']);

        Route::post('/recaps/notsubmitted/', [UserRecapsController::class, 'unsubmittedRecaps']);

        // PAYMENTS
        Route::get('payments/{slug?}', [PaymentsController::class, 'index'])->name('payments.index');

          Route::get('/paywithusers/{slug?}', [PaymentsController::class, 'userslist'])
         ->name('payments.userslist');

        Route::get('payments-detail/{id}', [PaymentsController::class, 'paymentDetail']);
        Route::post('payments-detail/update/{id}', [PaymentsController::class, 'paymentPrefencesUpdate']);
        Route::post('payments/pay-now', [PaymentsController::class, 'payNow']);
        

        /*-------- JOBS -------*/
        Route::get('jobs', [JobsController::class, 'index']);
        Route::post('job/import', [JobsController::class, 'importJob']);

        /*-------- SHIFTS -------*/
        Route::get('shifts', [ShiftsController::class, 'index']);
        Route::get('shifts/import', [ShiftsController::class, 'showImportForm']);
        Route::post('shifts/import', [ShiftsController::class, 'importShifts']);
        Route::get('shifts/coverage', [ShiftsController::class, 'coverageJobs']);
        Route::get('shifts/requestors-list/{id}', [ShiftsController::class, 'RequestorsList']);
        Route::post('shifts/requestors-list/submit', [ShiftsController::class, 'RequestorsListSubmit']);

        Route::get('shift/{id}/edit', [ShiftsController::class, 'editJob']);
        Route::post('shift/{id}/update', [ShiftsController::class, 'updateJob']);
        Route::post('shift/publish', [ShiftsController::class, 'publishJobs']);
        Route::get('shift/{id}/members', [ShiftsController::class, 'JobMembers']);
        Route::post('shift/{id}/members/add', [ShiftsController::class, 'addMembers']);
        Route::post('shift/{id}/member/remove', [ShiftsController::class, 'removeMember']);
        Route::get('shift/delete/{id}', [ShiftsController::class, 'deleteJob']);
        Route::get('shift/{id}/member/detail', [ShiftsController::class, 'jobMemeberDetail']);
        Route::post('shift/note/add', [ShiftsController::class, 'addNote']);

        Route::get('update/user/job', [ShiftsController::class, 'updateJobStatusForUser']);

        /*-------- LEARNING-CENTER -------*/
        Route::group(
            ['prefix' => 'learning-center/', 'middleware' => ['isLogin']],
            function () {

                // TRAININGS
                Route::get('trainings', [TrainingsController::class, 'index']);
                Route::get('user-trainings', [TrainingsController::class, 'userTrainings']);
                Route::post('training-approve-selected', [TrainingsController::class, 'approveTraining']);
                Route::get('training/create', [TrainingsController::class, 'create']);
                Route::post('training/store', [TrainingsController::class, 'store']);
                Route::get('training/{id}/edit', [TrainingsController::class, 'edit']);
                Route::put('training/{id}', [TrainingsController::class, 'update']);
                Route::get('training/{id}/delete', [TrainingsController::class, 'destroy']);
                Route::get('training-file/{id}/delete', [TrainingsController::class, 'destroyFile']);
                Route::get('training/{id}/view', [TrainingsController::class, 'detail']);

                // INFOS
                Route::get('infos', [InfosController::class, 'index']);
                Route::get('info/create', [InfosController::class, 'create']);
                Route::post('info/store', [InfosController::class, 'store']);
                Route::get('info/{id}/edit', [InfosController::class, 'edit']);
                Route::put('info/{id}', [InfosController::class, 'update']);
                Route::get('info/{id}/delete', [InfosController::class, 'destroy']);
                Route::get('info-file/{id}/delete', [InfosController::class, 'destroyFile']);


                // QUIZZES
                Route::get('quizzes', [QuizzesController::class, 'index']);
                Route::get('user-quizzes', [QuizzesController::class, 'userQuizzes']);
                Route::get('quiz/create', [QuizzesController::class, 'create']);
                Route::post('quiz/store', [QuizzesController::class, 'store']);
                Route::get('quiz/{id}/questions', [QuizzesController::class, 'questions']);
                Route::post('quiz/{id}/questions', [QuizzesController::class, 'addQuestions']);
                Route::get('quiz/{id}/edit', [QuizzesController::class, 'edit']);
                Route::put('quiz/{id}', [QuizzesController::class, 'update']);
                Route::delete('quiz/{id}', [QuizzesController::class, 'destroyQuiz']);
                Route::delete('question/{id}', [QuizzesController::class, 'destroyQuestion']);
                Route::delete('option/{id}', [QuizzesController::class, 'destroyOption']);
                Route::get('quiz/{id}/delete', [QuizzesController::class, 'destroy']);
                Route::get('user-quiz/', [QuizzesController::class, 'reviewQuiz']);
                Route::post('/reAttempt', [QuizzesController::class, 'userQuizReattempt']);
                Route::post('/appr', [QuizzesController::class, 'approved']);

                // RECAPS
                Route::get('recaps', [RecapsController::class, 'index']);
                Route::get('recap/create', [RecapsController::class, 'create']);
                Route::post('recap/store', [RecapsController::class, 'store']);
                Route::get('recap/{id}/edit', [RecapsController::class, 'edit']);
                Route::put('recap/{id}', [RecapsController::class, 'update']);
                // Route::delete('recap/{id}', [RecapsController::class, 'destroy']);
                Route::get('recap/{id}/delete', [RecapsController::class, 'destroy']);

            }
        );

        /*-------- ONBOARDING -------*/
        Route::group(
            ['prefix' => 'onboarding/', 'middleware' => ['isLogin']],
            function () {

                // W9FORMS
                Route::get('w9forms/list', [OnboardingController::class, 'w9Forms']);
                Route::get('w9forms', [OnboardingController::class, 'w9Forms']);
                Route::get('w9form/{id?}', [OnboardingController::class, 'w9formDetail']);
                Route::post('w9form/{id?}', [OnboardingController::class, 'updateW9FormDetail']);

                // PAYROLLS
                Route::get('payrolls/list', [OnboardingController::class, 'payrolls']);
                Route::get('payrolls', [OnboardingController::class, 'payrolls']);
                Route::get('payroll/{id?}', [OnboardingController::class, 'payrollDetail']);
                Route::post('payroll/{id?}', [OnboardingController::class, 'updatePayrollDetail']);

                //ict
                Route::get('ic-aggrement/list', [OnboardingController::class, 'ICTForms']);
                Route::get('ic-aggrement', [OnboardingController::class, 'ICTForms']);
                Route::get('ic-aggrement/{id?}', [OnboardingController::class, 'ICTformDetail']);
                Route::post('ic-aggrement/{id?}', [OnboardingController::class, 'updateICTFormDetail']);
            }
        );

        /*-------- MESSAGES -------*/
        Route::get('/messages', [MessagesController::class, 'index']);
        Route::get('/messages/{user_id}', [MessagesController::class, 'userMessages']);
        Route::get('/message/send', [MessagesController::class, 'sendNewMessage']);


    }
);

/*
|==========================================================================
| USER-PANEL ROUTES
|==========================================================================
*/

Route::group(
    ['prefix' => '/user', 'middleware' => ['isLogin']],
    function () {

        // DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'index']);

        Route::get('/user_training', [DashboardController::class, 'userTraining'])->name('user_training ');
        Route::get('/user_recap', [DashboardController::class, 'userRecap'])->name('user_recap');
        Route::get('/user_quiz', [DashboardController::class, 'userquiz'])->name('userquiz');

        // PROFILE-INFORMATION
        Route::get('/settings', [SettingsController::class, 'settings']);
        Route::post('/settings/profile', [SettingsController::class, 'updateProfile']);
        Route::post('/settings/password', [SettingsController::class, 'updatePassword']);
        Route::post('/settings/documents', [SettingsController::class, 'updateDocuments']);

        // NOTIFICATIONS
        Route::get('/notifications', [NotificationsController::class, 'index']);
        Route::get('/notifications/{id}', [NotificationsController::class, 'detail']);

        /*-------- SHIFTS -------*/
        Route::get('shifts', [ShiftsController::class, 'index']);


        Route::get('shifts/import', [ShiftsController::class, 'showImportForm']);
        Route::post('shifts/import', [ShiftsController::class, 'importShifts']);

        Route::get('shift/{id}/edit', [ShiftsController::class, 'editJob']);
        Route::get('shift/{id}/detail', [ShiftsController::class, 'UserJobDetail']);
        Route::post('shift/{id}/update', [ShiftsController::class, 'updateJob']);
        Route::get('shift/publish', [ShiftsController::class, 'publishJobs']);
        Route::get('shift/{id}/members', [ShiftsController::class, 'JobMembers']);
        Route::post('shift/{id}/members/add', [ShiftsController::class, 'addMembers']);
        Route::post('shift/{id}/member/remove', [ShiftsController::class, 'removeMember']);
        Route::post('shift/delete', [ShiftsController::class, 'deleteJob']);
        Route::get('shift/accept/{id}', [ShiftsController::class, 'updateJobStatusForUser'])->name('user.accept');
        Route::get('shift/decline/{id}', [ShiftsController::class, 'updateJobStatusForUser'])->name('user.decline');
        Route::post('shift/request-coverage', [ShiftsController::class, 'requestCoverage'])->name('user.requestCoverage');
        Route::get('shifts/coverage', [ShiftsController::class, 'coverageJobs']);
        Route::get('shifts/coverage/accept/{id}', [ShiftsController::class, 'coverageJobsAccept']);

        // RECAPS
        Route::get('recaps/{slug?}', [UserRecapsController::class, 'index']);
        Route::get('recap/{id}', [UserRecapsController::class, 'edit']);
        Route::post('recap/{id}', [UserRecapsController::class, 'storeRecapAnswers']);

        Route::get('team-recap/{slug?}', [UserRecapsController::class, 'teamRecapIndex']);

        // PAYMENTS
        Route::get('payments/{slug?}', [PaymentsController::class, 'index']);

        Route::get('clock-time', [ClockTImeController::class, 'index']);
        Route::get('shift/confirm/{id}', [ClockTImeController::class, 'confirmShift']);
        Route::post('/clock-in/submit', [ClockTImeController::class, 'submit']);


       
        /*-------- LEARNING-CENTER -------*/
        Route::group(
            ['prefix' => 'learning-center/', 'middleware' => ['isLogin']],
            function () {

                // TRAININGS
                Route::get('trainings/{slug?}', [TrainingsController::class, 'index']);
                Route::get('training/{id}', [TrainingsController::class, 'edit']);
                Route::get('training/{id}/complete', [TrainingsController::class, 'completeTraining']);

            }
        );

        // QUIZZES
        Route::get('quizzes/{slug?}', [QuizzesController::class, 'index'])->name('quizzes.index');
        Route::get('quiz/{id}', [QuizzesController::class, 'edit']);
        Route::post('quiz/{id}', [QuizzesController::class, 'submitQuiz']);

        /*-------- ONBOARDING -------*/
        Route::get('/onboarding/w9form', [OnboardingController::class, 'w9formDetail']);
        Route::post('/onboarding/w9form', [OnboardingController::class, 'updateW9FormDetail']);
        Route::get('/onboarding/payroll', [OnboardingController::class, 'payrollDetail']);
        Route::post('/onboarding/payroll', [OnboardingController::class, 'updatePayrollDetail']);
        Route::get('/onboarding/ICTforms', [OnboardingController::class, 'ICTformDetail']);
        Route::post('/onboarding/ICTforms', [OnboardingController::class, 'updateICTFormDetail']);

        // Route::get('/onboarding/ic-aggrement', [OnboardingController::class, 'ICTForms']);
        Route::get('onboarding/ic-aggrement/{id?}', [OnboardingController::class, 'ICTformDetail']);
        Route::post('/onboarding/ic-aggrement/{id?}', [OnboardingController::class, 'updateICTFormDetail']);

        /*-------- MESSAGES -------*/
        Route::get('/messages', [MessagesController::class, 'index']);
        Route::get('/messages/{user_id}', [MessagesController::class, 'userMessages']);
        Route::get('/message/send', [MessagesController::class, 'sendNewMessage']);

    }
);



  Route::get('shifts/checkout/cronjob', [ShiftsController::class, 'autoCleanupCompletedShifts']);


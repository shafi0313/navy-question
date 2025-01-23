<?php

use App\Http\Controllers\Admin\AjaxController;
use App\Http\Controllers\Admin\AnswerPaperController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\GenerateQuestionPaperController;
use App\Http\Controllers\Admin\GlobalController;
use App\Http\Controllers\Admin\MarkDistributionController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuestionImportController;
use App\Http\Controllers\Admin\QuestionPaperController;
use App\Http\Controllers\Admin\RankController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VisitorInfoController;
use App\Http\Controllers\Auth\Permission\PermissionController;
use App\Http\Controllers\Auth\Role\RoleController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->name('login');
    Route::get('/login', 'login')->name('login');
    // Route::get('/register', 'register'])->name('register');
    // Route::post('/register-store', 'registerStore'])->name('registerStore');
    Route::get('/register-verify/{token}', 'registerVerify')->name('registerVerify');
    Route::get('/verify-notification', 'verifyNotification')->name('verifyNotification');

    Route::post('/verify-resend', 'verifyResend')->name('verifyResend');

    Route::get('/forget-password', 'forgetPassword')->name('forgetPassword');
    Route::post('/forget-password-process', 'forgetPasswordProcess')->name('forgetPasswordProcess');
    Route::get('/reset-password/{token}', 'resetPassword')->name('resetPassword');
    Route::post('/reset-password-process', 'resetPasswordProcess')->name('resetPasswordProcess');
    Route::get('/reset-verify-notification', 'resetVerifyNotification')->name('resetVerifyNotification');

    Route::post('/login-process', 'loginProcess')->name('loginProcess');
    Route::get('/logout', 'logout')->name('logout');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::controller(VisitorInfoController::class)->prefix('visitor-info')->name('visitorInfo.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/delete-selected', 'destroySelected')->name('destroySelected');
        Route::get('/delete-all', 'destroyAll')->name('destroyAll');
    });

    // Global Ajax Route
    Route::get('select-2-ajax', [AjaxController::class, 'select2'])->name('select2');
    Route::post('response', [AjaxController::class, 'response'])->name('ajax');

    Route::post('role/permission/{role}', [RoleController::class, 'assignPermission'])->name('role.permission');
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);

    // !APP BACKUP
    Route::controller(BackupController::class)->prefix('app-backup')->name('backup.')->group(function () {
        Route::get('/password', 'password')->name('password');
        Route::post('/checkPassword', 'checkPassword')->name('checkPassword');
        Route::get('/confirm', 'index')->name('index');
        Route::post('backup-file', 'backupFiles')->name('files');
        Route::post('backup-db', 'backupDb')->name('db');
        // Route::get('/restore','restoreLoad'])->name('restore');
        // Route::post('/restore/post','restore'])->name('restore.post');
        Route::post('/download/{name}/{ext}', 'downloadBackup')->name('download');
        Route::post('/delete/{name}/{ext}', 'deleteBackup')->name('delete');
    });

    Route::controller(GlobalController::class)->name('global.')->group(function () {
        Route::get('/get-subject', 'getSubject')->name('getSubject');
    });

    // Route::controller(UserController::class)->prefix('user')->name('user.')->group(function () {
    //     Route::get('/', 'index')->name('index');
    //     Route::get('/create', 'create')->name('create');
    //     Route::post('/store', 'store')->name('store');
    //     Route::get('/edit/{id}', 'edit')->name('edit');
    //     Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    // });

    Route::resource('/users', UserController::class)->except(['create', 'show']);

    Route::controller(ProfileController::class)->prefix('my-profile')->group(function () {
        Route::get('/', 'index')->name('myProfile.profile.index');
        Route::post('/update', 'update')->name('myProfile.profile.update');
    });

    Route::resource('/subjects', SubjectController::class)->except(['show']);

    Route::controller(ChapterController::class)->prefix('chapter')->name('chapter.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    });
    // Route::controller(QuestionEntryController::class)->prefix('question')->name('question.')->group(function () {
    //     // Route::get('/', 'index')->name('index');
    //     // Route::get('/create', 'create')->name('create');
    //     // Route::post('/store', 'store')->name('store');
    //     Route::get('/read', 'read')->name('read');
    //     Route::get('/edit/{id}', 'edit')->name('edit');
    //     Route::post('/update/{id}', 'update')->name('update');
    //     Route::get('/show/{id}', 'show')->name('show');
    //     Route::get('/option/destroy/{id}', 'optionDestroy')->name('optionDestroy');
    //     Route::delete('/destroy/{id}', 'destroy')->name('destroy');
    //     Route::post('/ques-generate', 'quesGenerate')->name('quesGenerate');
    //     Route::post('/newOptionAdd', 'newOptionAdd')->name('newOptionAdd');
    //     // Route::get('/get-subject', 'getSubject')->name('getSubject');
    //     Route::get('/get-subject', 'getSubject')->name('getSubject');
    //     Route::get('/get-chapter', 'getChapter')->name('getChapter');
    //     Route::get('/get-question', 'getQuestion')->name('getQuestion');
    // });

    Route::resource('/mark-distributions', MarkDistributionController::class);
    Route::controller(MarkDistributionController::class)->prefix('mark-distribution')->name('mark_distributions.')->group(function () {
        Route::get('/read', 'read')->name('read');
        Route::get('/get-mark-info', 'getMarkInfo')->name('getMarkInfo');
    });

    Route::controller(GenerateQuestionPaperController::class)->prefix('generate-question-paper')->name('generate_question.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/addQues', 'addQues')->name('addQues');
        Route::post('/store', 'store')->name('store');
        Route::patch('/status/{quesInfo}', 'status')->name('status');
        // Route::post('/complete', 'complete')->name('complete');
        Route::get('/edit/{id}/{quesInfoId}/{set}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/show/{quesInfo}/{set}/{type}', 'show')->name('show');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');
        Route::get('/option/destroy/{id}', 'optionDestroy')->name('optionDestroy');
        Route::get('/question/destroy/{quesPaperId}', 'quesDestroy')->name('quesDestroy');
        Route::post('/ques-generate', 'quesGenerate')->name('quesGenerate');
        Route::get('/get-question', 'getQuestion')->name('getQuestion');
        Route::get('/get-subject', 'getSubject')->name('getSubject');
    });

    Route::controller(QuestionPaperController::class)->prefix('question-paper')->name('generated_question.')->group(function () {
        Route::get('/', 'index')->name('index');
        // Route::get('/subject/show/{subject}', 'showBySubject')->name('showBySubject');
        // Route::get('/set/show/{subjectId}/{year}', 'showBySet')->name('showBySet');
        Route::get('/show/{quesInfo}/{set}/{type}', 'show')->name('show');
        Route::get('/answer-sheet/{quesInfo}/{set}/{type}', 'answerSheet')->name('answer_sheet');
        Route::delete('/destroy/{id}', 'destroy')->name('destroy');

        // Route::get('/pdf/download/', 'questionPFD')->name('questionPFD');
    });

    Route::controller(AnswerPaperController::class)->prefix('answer-paper')->name('answerPaper.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{userId}/{examId}', 'show')->name('show');
        Route::post('/store', 'store')->name('store');
    });

    Route::resource('/exams', ExamController::class);
    Route::resource('/ranks', RankController::class);
    Route::resource('/question-imports', QuestionImportController::class)->except(['create', 'show']);
    Route::controller(QuestionImportController::class)->prefix('question-import')->name('question_imports.')->group(function () {
        Route::post('/imports', 'import')->name('imports');
        Route::get('/imports/all-delete', 'allDelete')->name('all_deletes');
    });
    Route::resource('/questions', QuestionController::class);
    Route::controller(QuestionController::class)->prefix('questions')->name('questions.')->group(function () {
        Route::get('/read', 'read')->name('read');
        Route::get('/option/destroy/{id}', 'optionDestroy')->name('optionDestroy');
        Route::post('/ques-generate', 'quesGenerate')->name('quesGenerate');
        Route::post('/newOptionAdd', 'newOptionAdd')->name('newOptionAdd');
        // Route::get('/get-subject', 'getSubject')->name('getSubject');
        // Route::get('/get-subject', 'getSubject')->name('getSubject');
        // Route::get('/get-chapter', 'getChapter')->name('getChapter');
        Route::get('/get-question', 'getQuestion')->name('getQuestion');
    });

});

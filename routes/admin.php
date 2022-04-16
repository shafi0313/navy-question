<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VisitorInfoController;
use App\Http\Controllers\Admin\GeneratedQuesController;


Route::get('/t', function () {
    return User::with('permissionn')->get();

});


Route::controller(AuthController::class)->group(function(){
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


Route::middleware(['auth','admin'])->prefix('admin')->name('admin.')->group(function(){
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::controller(VisitorInfoController::class)->prefix('visitor-info')->name('visitorInfo.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/delete-selected', 'destroySelected')->name('destroySelected');
        Route::get('/delete-all', 'destroyAll')->name('destroyAll');
    });


    // !APP BACKUP
    Route::controller(BackupController::class)->prefix('app-backup')->name('backup.')->group(function(){
        Route::get('/password','password')->name('password');
        Route::post('/checkPassword','checkPassword')->name('checkPassword');
        Route::get('/confirm','index')->name('index');
        Route::post('backup-file','backupFiles')->name('files');
        Route::post('backup-db','backupDb')->name('db');
        // Route::get('/restore','restoreLoad'])->name('restore');
        // Route::post('/restore/post','restore'])->name('restore.post');
        Route::post('/download/{name}/{ext}','downloadBackup')->name('download');
        Route::post('/delete/{name}/{ext}','deleteBackup')->name('delete');
    });

    Route::controller(AdminUserController::class)->prefix('admin-user')->name('adminUser.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
    });

    Route::controller(ProfileController::class)->prefix('my-profile')->group(function(){
        Route::get('/', 'index')->name('myProfile.profile.index');
        Route::post('/update', 'update')->name('myProfile.profile.update');
    });

    Route::controller(SubjectController::class)->prefix('subject')->name('subject.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');
    });
    Route::controller(ChapterController::class)->prefix('chapter')->name('chapter.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{id}', 'update')->name('update');

    });
    Route::controller(QuestionController::class)->prefix('question')->name('question.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/show/{id}', 'show')->name('show');
        Route::get('/option/destroy/{id}', 'optionDestroy')->name('optionDestroy');
        Route::post('/ques-generate', 'quesGenerate')->name('quesGenerate');
        Route::get('/get-subject', 'getSubject')->name('getSubject');
        Route::get('/get-chapter', 'getChapter')->name('getChapter');
    });

    Route::controller(GeneratedQuesController::class)->prefix('generated-question')->name('generatedQues.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
    });

    Route::controller(ExamController::class)->prefix('exam')->name('exam.')->group(function(){
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
    });
});

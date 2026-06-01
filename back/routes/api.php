<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\VideoController;
use App\Http\Controllers\Api\LeaderController;
use App\Http\Controllers\Api\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Api\Admin\PageController as AdminPageController;
use App\Http\Controllers\Api\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Api\Admin\LeaderController as AdminLeaderController;
use App\Http\Controllers\Api\Admin\MembershipApplicationController as AdminMembershipApplicationController;
use App\Http\Controllers\Api\Admin\MembershipPlanController as AdminMembershipPlanController;
use App\Http\Controllers\Api\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\Api\Admin\UploadController;
use App\Http\Controllers\Api\Admin\VideoController as AdminVideoController;
use App\Http\Controllers\Api\MembershipApplicationController;
use App\Http\Controllers\Api\MembershipPlanController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\LeadController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\Admin\QuestionController as AdminQuestionController;
use App\Http\Controllers\Api\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Api\Admin\TradingPlatformController as AdminTradingPlatformController;
use App\Http\Controllers\Api\TradingPlatformController;
use App\Http\Controllers\Api\ComplaintController;
use App\Http\Controllers\Api\Admin\ComplaintController as AdminComplaintController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\Admin\SettingsController as AdminSettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
});

/*
|--------------------------------------------------------------------------
| Public API Routes
|--------------------------------------------------------------------------
*/

Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index']);
    Route::get('/featured', [NewsController::class, 'featured']);
    Route::get('/tags', [NewsController::class, 'tags']);
    Route::get('/category-counts', [NewsController::class, 'categoryCounts']);
    Route::get('/{newsArticle}', [NewsController::class, 'show']);
});

Route::get('/videos', [VideoController::class, 'index']);
Route::get('/leaders', [LeaderController::class, 'index']);
Route::get('/membership-plans', [MembershipPlanController::class, 'index']);
Route::post('/membership-applications', [MembershipApplicationController::class, 'store']);
Route::post('/questions', [QuestionController::class, 'store']);
Route::post('/leads', [LeadController::class, 'store']);
Route::get('/testimonials', [TestimonialController::class, 'index']);

Route::get('/page/{slug}', [PageController::class, 'show']);
Route::get('/services', [ServiceController::class, 'index']);
Route::get('/trading-platforms', [TradingPlatformController::class, 'index']);
Route::get('/settings', [SettingsController::class, 'show']);
Route::post('/complaints', [ComplaintController::class, 'store']);
Route::get('/complaints/stats', [ComplaintController::class, 'stats']);
Route::get('/complaints/track/{code}', [ComplaintController::class, 'track']);

/*
|--------------------------------------------------------------------------
| Admin API Routes (protected by Sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::post('/upload/image', [UploadController::class, 'image']);

    Route::get('/page/{slug}', [AdminPageController::class, 'show']);
    Route::put('/page/{slug}', [AdminPageController::class, 'update']);

    Route::get('/services', [AdminServiceController::class, 'index']);
    Route::post('/services', [AdminServiceController::class, 'store']);
    Route::put('/services/{service}', [AdminServiceController::class, 'update']);
    Route::delete('/services/{service}', [AdminServiceController::class, 'destroy']);

    Route::get('/news', [AdminNewsController::class, 'index'])->name('admin.news.index');
    Route::post('/news', [AdminNewsController::class, 'store'])->name('admin.news.store');
    Route::put('/news/{newsArticle}', [AdminNewsController::class, 'update'])->name('admin.news.update');
    Route::delete('/news/{newsArticle}', [AdminNewsController::class, 'destroy'])->name('admin.news.destroy');

    Route::get('/videos', [AdminVideoController::class, 'index']);
    Route::post('/videos', [AdminVideoController::class, 'store']);
    Route::post('/videos/{video}/sync-title', [AdminVideoController::class, 'syncTitle']);
    Route::put('/videos/{video}', [AdminVideoController::class, 'update']);
    Route::delete('/videos/{video}', [AdminVideoController::class, 'destroy']);

    Route::get('/leaders', [AdminLeaderController::class, 'index']);
    Route::post('/leaders', [AdminLeaderController::class, 'store']);
    Route::put('/leaders/{leader}', [AdminLeaderController::class, 'update']);
    Route::delete('/leaders/{leader}', [AdminLeaderController::class, 'destroy']);

    Route::get('/membership-applications', [AdminMembershipApplicationController::class, 'index']);
    Route::get('/membership-applications/{membershipApplication}', [AdminMembershipApplicationController::class, 'show']);
    Route::put('/membership-applications/{membershipApplication}', [AdminMembershipApplicationController::class, 'update']);
    Route::delete('/membership-applications/{membershipApplication}', [AdminMembershipApplicationController::class, 'destroy']);

    Route::get('/testimonials', [AdminTestimonialController::class, 'index']);
    Route::post('/testimonials', [AdminTestimonialController::class, 'store']);
    Route::put('/testimonials/{testimonial}', [AdminTestimonialController::class, 'update']);
    Route::delete('/testimonials/{testimonial}', [AdminTestimonialController::class, 'destroy']);

    Route::get('/membership-plans', [AdminMembershipPlanController::class, 'index']);
    Route::get('/membership-plans/{membershipPlan}', [AdminMembershipPlanController::class, 'show']);
    Route::put('/membership-plans/{membershipPlan}', [AdminMembershipPlanController::class, 'update']);

    Route::get('/leads', [AdminLeadController::class, 'index']);
    Route::put('/leads/{lead}', [AdminLeadController::class, 'update']);
    Route::delete('/leads/{lead}', [AdminLeadController::class, 'destroy']);

    Route::get('/questions', [AdminQuestionController::class, 'index']);
    Route::get('/questions/{question}', [AdminQuestionController::class, 'show']);
    Route::put('/questions/{question}', [AdminQuestionController::class, 'update']);
    Route::delete('/questions/{question}', [AdminQuestionController::class, 'destroy']);

    Route::get('/settings', [AdminSettingsController::class, 'show']);
    Route::put('/settings', [AdminSettingsController::class, 'update']);

    Route::get('/trading-platforms', [AdminTradingPlatformController::class, 'index']);
    Route::post('/trading-platforms', [AdminTradingPlatformController::class, 'store']);
    Route::put('/trading-platforms/{tradingPlatform}', [AdminTradingPlatformController::class, 'update']);
    Route::delete('/trading-platforms/{tradingPlatform}', [AdminTradingPlatformController::class, 'destroy']);

    Route::get('/complaints', [AdminComplaintController::class, 'index']);
    Route::get('/complaints/{complaint}', [AdminComplaintController::class, 'show']);
    Route::put('/complaints/{complaint}', [AdminComplaintController::class, 'update']);
    Route::delete('/complaints/{complaint}', [AdminComplaintController::class, 'destroy']);
    Route::delete('/complaints/{complaint}/files', [AdminComplaintController::class, 'deleteResponseFile']);
});

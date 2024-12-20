<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\HeadStaffController;
use App\Http\Controllers\ResponseProgressController;

Route::get('/',[AuthController::class,'index'])->name('index');
Route::get('/login',[AuthController::class,'login'])->name('login');
Route::get('/article',[AuthController::class,'article'])->name('article');
Route::get('/report/article/{id}',[AuthController::class,'articleId'])->name('articleId');
Route::get('/search/articles', [AuthController::class, 'article'])->name('articles.search');

Route::post('/loginOrRegister',[AuthController::class,'loginOrRegister'])->name('loginOrRegister');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/report/create', [ReportController::class, 'create'])->name('report.create');
Route::post('/report/store', [ReportController::class, 'store'])->name('reports.store');
Route::get('report/me',[ReportController::class,'index'])->name('index.reports.me');
Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');

Route::get('/report', [ReportController::class, 'indexStaff'])->name('report.staff');
Route::post('/response/report/{id}', [ResponseController::class, 'showReportResponse'])->name('reports.response');
Route::get('/response/report/{id}', [ResponseController::class, 'reportResponseIndex'])->name('response.index');
Route::post('/progress/{id}/store', [ResponseProgressController::class, 'store'])->name('progress.store');

Route::post('/reports/{id}/vote', [ReportController::class, 'vote'])->name('reports.vote');
Route::post('/comments/{report}', [CommentController::class, 'store'])->name('comments.store');

Route::get('/headStaff', [HeadStaffController::class, 'index'])->name('head.staff');
Route::get('/headStaff/user', [HeadStaffController::class, 'user'])->name('user');
Route::get('/headStaff/create', [HeadStaffController::class, 'create'])->name('create');
Route::post('/headStaff/create/submit', [HeadStaffController::class, 'store'])->name('store.alex');
Route::delete('/headStaff/user/{id}', [HeadStaffController::class, 'destroy'])->name('destroy.user');

Route::delete('/response/report/{id}', [ResponseProgressController::class, 'destroy'])->name('destroy.response');
Route::put('/response/{id}', [ResponseController::class, 'update'])->name('update.response');
Route::get('/excel/export', [ReportController::class, 'export'])->name('excel');
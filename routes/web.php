<?php

use App\Models\Story;
use App\Models\Chapter;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BrowseStoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolesPermissionController;

//Route to view home page
Route::get('/', [WelcomeController::class, 'index']);


/**---------------------------------------------------------------
 * USER ATHENTICATION ROUTE GROUP
 ----------------------------------------------------------------*/
Route::controller(AuthController::class)->group(function () {
  // Registration routes
  Route::get('register', 'show_registration_form');
  Route::post('register', 'store_user');

  // Verification route
  Route::get('verification/{token}', 'verify_user');

  // Login routes
  Route::get('login', 'show_login_form')->name('login');
  Route::post('login', 'login');

  // Password reset routes
  Route::get('reset', 'reset_password_form')->name('password.reset');
  Route::post('reset', 'reset_password');
  Route::get('reset-password/{token}', 'changePasswordForm');
  Route::post('reset-password/{token}', 'changePassword');

  // Logout route
  Route::get('logout', 'logout');
});
/**---------------------------------------------------------------
 **************END OF USER ATHENTICATION ROUTE GROUP*************
 ----------------------------------------------------------------*/

//Route to browse all stories
Route::get('/all-stories', [BrowseStoriesController::class, 'index'])->name('stories.all');

// Browse  stories by category
Route::get('/stories/{category}', [BrowseStoriesController::class, 'showStoriesByCategory'])->name('stories.category');
Route::get('story/{story}', [BrowseStoriesController::class, 'storyChapters'])->name('story.show');
//Endpoint for Fetching Chapter Content
Route::get('/stories/{story}/chapters/{chapter}', [ChapterController::class, 'showChapter'])->name('chapters.show');
Route::get('/stories/{story}/chapters/{chapter}/content', [ChapterController::class, 'content'])->name('chapters.content');


Route::group(['middleware' => ['role:admin', 'authmiddleware']], function () {
  // Admin routes

  Route::get('dashboard', [DashboardController::class, 'dashboard']);
  /**-----------------------------------------------------------------------
   * PROFILE RESOURCE ROUTES
  -------------------------------------------------------------------------*/
  Route::get('dashboard/profile', [ProfileController::class, 'index']);

  /**-------------------------------------------------------------------------
   * CATEGORY RESOURCE ROUTES
  ----------------------------------------------------------------------------*/
  Route::resource('dashboard/categories', CategoryController::class);
});

Route::group(['middleware' => ['authmiddleware']], function () {
  /**-----------------------------------------------------------------------
   * PROFILE RESOURCE ROUTES
  -------------------------------------------------------------------------*/
  Route::get('user-profile', [ProfileController::class, 'index'])->name('user.profile');
  Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
  // Route::get('/profile/password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.password');
  Route::post('/profile', [ProfileController::class, 'changePassword'])->name('profile.password.update');

  /**-------------------------------------------------------------------------
   * CATEGORY RESOURCE ROUTES
  ----------------------------------------------------------------------------*/
  Route::resource('dashboard/categories', CategoryController::class);
});




Route::group(['middleware' => ['authmiddleware']], function () {

  /**-------------------------------------------------------------------------
  STORY  ROUTES
  ----------------------------------------------------------------------------*/
  Route::get('stories', [StoryController::class, 'showStories'])->name('stories.show');
  Route::get('create-story', [StoryController::class, 'createStory'])->name('story.create');
  Route::post('create-story', [StoryController::class, 'saveStory']);
  Route::get('edit-story/{story}/edit', [StoryController::class, 'editStory'])->name('story.edit');
  Route::put('edit-story/{story}/edit', [StoryController::class, 'updateStory'])->name('story.update');
  Route::delete('delete-story/{story}', [StoryController::class, 'deleteStory'])->name('story.delete');

  /**-------------------------------------------------------------------------
  CHAPTER RESOURCES ROUTES
  ----------------------------------------------------------------------------*/
  Route::get('/story/{story}/chapter/create', [ChapterController::class, 'create'])->name('chapter.create');
  Route::post('/story/{story}/chapter', [ChapterController::class, 'store'])->name('chapter.store');
  Route::get('story/{story}/chapter/{chapter}/write', [ChapterController::class, 'write'])->name('chapter.write');
  Route::put('story/{story}/chapter/{chapter}', [ChapterController::class, 'update'])->name('chapter.update');
  Route::delete('story/{story}/chapter/{chapter}', [ChapterController::class, 'destroy'])->name('chapter.delete');
});

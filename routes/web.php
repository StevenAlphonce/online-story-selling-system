<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BrowseStoriesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

//Route to view home page
Route::get('/', [WelcomeController::class, 'index'])->middleware('guest');

//Route for searching Story
Route::post('/search', [StoryController::class, 'search'])->name('search');

//Route to browse all stories
Route::get('/all-stories', [BrowseStoriesController::class, 'index'])->name('stories.all');
// Browse  stories by category
Route::get('/stories/{category}', [BrowseStoriesController::class, 'showStoriesByCategory'])->name('stories.category');
Route::get('story/{story}', [BrowseStoriesController::class, 'storyChapters'])->name('story.show');
//Endpoint for Fetching Chapter Content
Route::get('/stories/{story}/chapters/{chapter}', [ChapterController::class, 'showChapter'])->name('chapters.show');
Route::get('/stories/{story}/chapters/{chapter}/content', [ChapterController::class, 'content'])->name('chapters.content');

/**---------------------------------------------------------------
 * USER ATHENTICATION ROUTE GROUP
 ----------------------------------------------------------------*/
Route::controller(AuthController::class)->group(function () {

  Route::middleware('guest')->group(function () {
    // Registration routes
    Route::get('register', 'show_registration_form');
    Route::post('register', 'store_user')->name('register');
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
  });

  // Logout route
  Route::get('logout', 'logout');
});
/**---------------------------------------------------------------
 **************END OF USER ATHENTICATION ROUTE GROUP*************
 ----------------------------------------------------------------*/

Route::group(['middleware' => ['auth', 'admin']], function () {
  // Admin routes

  Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
  /**-----------------------------------------------------------------------
   * PROFILE RESOURCE ROUTES
  -------------------------------------------------------------------------*/
  Route::get('dashboard/profile', [ProfileController::class, 'index']);

  /**-------------------------------------------------------------------------
   * CATEGORY RESOURCE ROUTES
  ----------------------------------------------------------------------------*/
  Route::resource('dashboard/categories', CategoryController::class);

  /**-------------------------------------------------------------------------
   * USERS RESOURCE ROUTES
  ----------------------------------------------------------------------------*/
  Route::get('dashboard/users', [UserController::class, 'index'])->name('users.index');
  Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
});

/** *********************************************************************************** */

Route::group(['middleware' => ['auth', 'user']], function () {
  /**-----------------------------------------------------------------------
   * PROFILE RESOURCE ROUTES
  -------------------------------------------------------------------------*/
  Route::get('user-profile', [ProfileController::class, 'index'])->name('user.profile');
  Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
  // Route::get('/profile/password', [ProfileController::class, 'showChangePasswordForm'])->name('profile.password');
  Route::post('/profile', [ProfileController::class, 'changePassword'])->name('profile.password.update');




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

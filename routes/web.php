<?php
// Frontend...
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

Route::get('/', 'MainController@index')->name('main');

Route::get('/novosti', 'PostsController@index')->name('novosti');
Route::get('/post/{slug}', 'PostsController@post')->name('post.show');
Route::post('/comment', 'CommentsController@store');

Route::get('/tag/{slug}', 'PostsController@tag')->name('tag.show');

Route::get('/category/{slug}', 'PostsController@category')->name('category.show');
Route::get('/no-category', 'PostsController@no_category')->name('no-category.show');

Route::get('/archive/{year}', 'PostsController@archive')->name('year');
//Route::get('/archive/{month-year}', 'PostsController@archiveMonthYear')->name('archive.month.year.show');
Route::get('/archive_month_year/{month}/{year}', 'PostsController@archiveMonthYear')->name('archive.month.year.show');

Route::get('/user_posts/{id}/{name}', 'PostsController@user_posts')->name('user_posts.show');

Route::post('/subscribe', 'SubscribesController@subscribe');
Route::get('/verify/{token}', 'SubscribesController@verify');

Route::post('/letter', 'LetterController@letter');
Route::get('/get_captcha/{config?}', function (\Mews\Captcha\Captcha $captcha, $config = 'default') {
  return $captcha->src($config);
});

Route::post('/sendmail', 'Ajax\ContactController@send');



Route::get('/uslugi', 'ServicesController@index')->name('uslugi');
Route::get('/raspisanie', 'TimetablesController@index')->name('raspisanie');
Route::get('/kontakty', 'ContactsController@index')->name('kontakty');
Route::get('/kostyukovskie-luzhniki', 'HistorysController@luzhniki')->name('kostyukovskie-luzhniki');
Route::get('/doska-pocheta', 'HistorysController@doska')->name('doska-pocheta');
Route::get('/oao-gomelsteklo', 'HistorysController@gomelsteklo')->name('oao-gomelsteklo');
Route::get('/obyavleniya', 'AddsController@index')->name('obyavleniya');

Route::get('/section/{id}/{slug}', 'SectionsPagesController@section')->name('section');

// Backend...
Route::get('/cabinet', function () { return redirect('/admin/home'); })->name('cabinet');

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login')->name('auth.login');
$this->post('logout', 'Auth\LoginController@logout')->name('auth.logout');
$this->get('logout', 'Auth\LoginController@logout')->name('auth.logout');

// Change Password Routes...
$this->get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
$this->patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('auth.password.reset');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('auth.password.reset');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
$this->post('password/reset', 'Auth\ResetPasswordController@reset')->name('auth.password.reset');

Route::group([
    'middleware' => 'auth',
], function(){
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::post('/profile', 'ProfileController@store');
});

Route::group(
    [
        'middleware' => ['auth', 'trimstriptags', 'del.empty.folder'],
        'prefix' => 'admin',
        'as' => 'admin.',
        'namespace' => 'Admin'
    ],
    function () {
        Route::get('/home', 'HomeController@index');

        Route::resource('roles', 'RolesController');
        Route::post('roles_mass_destroy', ['uses' => 'RolesController@massDestroy', 'as' => 'roles.mass_destroy']);

        Route::resource('users', 'UsersController');
        Route::post('users_mass_destroy', ['uses' => 'UsersController@massDestroy', 'as' => 'users.mass_destroy']);

        Route::resource('coaches', 'CoachesController');
        Route::post('coaches_mass_destroy', ['uses' => 'CoachesController@massDestroy', 'as' => 'coaches.mass_destroy']);
        Route::post('coaches_restore/{id}', ['uses' => 'CoachesController@restore', 'as' => 'coaches.restore']);
        Route::delete('coaches_perma_del/{id}', ['uses' => 'CoachesController@perma_del', 'as' => 'coaches.perma_del']);

        Route::resource('directors', 'DirectorsController');
        Route::post('directors_mass_destroy', ['uses' => 'DirectorsController@massDestroy', 'as' => 'directors.mass_destroy']);
        Route::post('directors_restore/{id}', ['uses' => 'DirectorsController@restore', 'as' => 'directors.restore']);
        Route::delete('directors_perma_del/{id}', ['uses' => 'DirectorsController@perma_del', 'as' => 'directors.perma_del']);

        Route::resource('boards', 'BoardsController');
        Route::post('boards_mass_destroy', ['uses' => 'BoardsController@massDestroy', 'as' => 'boards.mass_destroy']);
        Route::post('boards_restore/{id}', ['uses' => 'BoardsController@restore', 'as' => 'boards.restore']);
        Route::delete('boards_perma_del/{id}', ['uses' => 'BoardsController@perma_del', 'as' => 'boards.perma_del']);

        Route::resource('mains', 'MainsController');
        Route::post('mains_mass_destroy', ['uses' => 'MainsController@massDestroy', 'as' => 'mains.mass_destroy']);
        Route::post('mains_restore/{id}', ['uses' => 'MainsController@restore', 'as' => 'mains.restore']);
        Route::delete('mains_perma_del/{id}', ['uses' => 'MainsController@perma_del', 'as' => 'mains.perma_del']);

        Route::resource('histories', 'HistoriesController');
        Route::post('histories_mass_destroy', ['uses' => 'HistoriesController@massDestroy', 'as' => 'histories.mass_destroy']);
        Route::post('histories_restore/{id}', ['uses' => 'HistoriesController@restore', 'as' => 'histories.restore']);
        Route::delete('histories_perma_del/{id}', ['uses' => 'HistoriesController@perma_del', 'as' => 'histories.perma_del']);

        Route::resource('sections', 'SectionsController');
        Route::post('sections_mass_destroy', ['uses' => 'SectionsController@massDestroy', 'as' => 'sections.mass_destroy']);
        Route::post('sections_restore/{id}', ['uses' => 'SectionsController@restore', 'as' => 'sections.restore']);
        Route::delete('sections_perma_del/{id}', ['uses' => 'SectionsController@perma_del', 'as' => 'sections.perma_del']);

        Route::resource('services', 'ServicesController');
        Route::post('services_mass_destroy', ['uses' => 'ServicesController@massDestroy', 'as' => 'services.mass_destroy']);
        Route::post('services_restore/{id}', ['uses' => 'ServicesController@restore', 'as' => 'services.restore']);
        Route::delete('services_perma_del/{id}', ['uses' => 'ServicesController@perma_del', 'as' => 'services.perma_del']);

        Route::resource('prides', 'PridesController');
        Route::post('prides_mass_destroy', ['uses' => 'PridesController@massDestroy', 'as' => 'prides.mass_destroy']);
        Route::post('prides_restore/{id}', ['uses' => 'PridesController@restore', 'as' => 'prides.restore']);
        Route::delete('prides_perma_del/{id}', ['uses' => 'PridesController@perma_del', 'as' => 'prides.perma_del']);

        Route::resource('timetables', 'TimetablesController');
        Route::post('timetables_mass_destroy', ['uses' => 'TimetablesController@massDestroy', 'as' => 'timetables.mass_destroy']);
        Route::post('timetables_restore/{id}', ['uses' => 'TimetablesController@restore', 'as' => 'timetables.restore']);
        Route::delete('timetables_perma_del/{id}', ['uses' => 'TimetablesController@perma_del', 'as' => 'timetables.perma_del']);


        Route::resource('contacts', 'ContactsController');
        Route::post('contacts_mass_destroy', ['uses' => 'ContactsController@massDestroy', 'as' => 'contacts.mass_destroy']);
        Route::post('contacts_restore/{id}', ['uses' => 'ContactsController@restore', 'as' => 'contacts.restore']);
        Route::delete('contacts_perma_del/{id}', ['uses' => 'ContactsController@perma_del', 'as' => 'contacts.perma_del']);

        Route::resource('categories', 'CategoriesController');
        Route::post('categories_mass_destroy', ['uses' => 'CategoriesController@massDestroy', 'as' => 'categories.mass_destroy']);
        Route::post('categories_restore/{id}', ['uses' => 'CategoriesController@restore', 'as' => 'categories.restore']);
        Route::delete('categories_perma_del/{id}', ['uses' => 'CategoriesController@perma_del', 'as' => 'categories.perma_del']);

        Route::resource('tags', 'TagsController');
        Route::post('tags_mass_destroy', ['uses' => 'TagsController@massDestroy', 'as' => 'tags.mass_destroy']);
        Route::post('tags_restore/{id}', ['uses' => 'TagsController@restore', 'as' => 'tags.restore']);
        Route::delete('tags_perma_del/{id}', ['uses' => 'TagsController@perma_del', 'as' => 'tags.perma_del']);


        Route::resource('comments', 'CommentsController');
        Route::get('/comment/toggle/{id}', 'CommentsController@toggle');
        Route::post('comments_mass_destroy', ['uses' => 'CommentsController@massDestroy', 'as' => 'comments.mass_destroy']);
        Route::post('comments_restore/{id}', ['uses' => 'CommentsController@restore', 'as' => 'comments.restore']);
        Route::delete('comments_perma_del/{id}', ['uses' => 'CommentsController@perma_del', 'as' => 'comments.perma_del']);

        Route::resource('poststags', 'PoststagsController');
        Route::post('poststags_mass_destroy', ['uses' => 'PoststagsController@massDestroy', 'as' => 'poststags.mass_destroy']);
        Route::post('poststags_restore/{id}', ['uses' => 'PoststagsController@restore', 'as' => 'poststags.restore']);
        Route::delete('poststags_perma_del/{id}', ['uses' => 'PoststagsController@perma_del', 'as' => 'poststags.perma_del']);

        Route::resource('subscribes', 'SubscribesController');
        Route::post('subscribes_mass_destroy', ['uses' => 'SubscribesController@massDestroy', 'as' => 'subscribes.mass_destroy']);
        Route::post('subscribes_restore/{id}', ['uses' => 'SubscribesController@restore', 'as' => 'subscribes.restore']);
        Route::delete('subscribes_perma_del/{id}', ['uses' => 'SubscribesController@perma_del', 'as' => 'subscribes.perma_del']);

        Route::resource('gomelglasses', 'GomelglassesController');
        Route::post('gomelglasses_mass_destroy', ['uses' => 'GomelglassesController@massDestroy', 'as' => 'gomelglasses.mass_destroy']);
        Route::post('gomelglasses_restore/{id}', ['uses' => 'GomelglassesController@restore', 'as' => 'gomelglasses.restore']);
        Route::delete('gomelglasses_perma_del/{id}', ['uses' => 'GomelglassesController@perma_del', 'as' => 'gomelglasses.perma_del']);

        Route::resource('banners', 'BannersController');
        Route::post('banners_mass_destroy', ['uses' => 'BannersController@massDestroy', 'as' => 'banners.mass_destroy']);
        Route::post('banners_restore/{id}', ['uses' => 'BannersController@restore', 'as' => 'banners.restore']);
        Route::delete('banners_perma_del/{id}', ['uses' => 'BannersController@perma_del', 'as' => 'banners.perma_del']);

        Route::resource('posts', 'PostsController');
        Route::get('/post/toggle/{id}', 'PostsController@toggle');
        Route::post('posts_mass_destroy', ['uses' => 'PostsController@massDestroy', 'as' => 'posts.mass_destroy']);
        Route::post('posts_restore/{id}', ['uses' => 'PostsController@restore', 'as' => 'posts.restore']);
        Route::delete('posts_perma_del/{id}', ['uses' => 'PostsController@perma_del', 'as' => 'posts.perma_del']);


        Route::resource('ads', 'AdsController');
        Route::get('/ad/toggle/{id}', 'AdsController@toggle');
        Route::post('ads_mass_destroy', ['uses' => 'AdsController@massDestroy', 'as' => 'ads.mass_destroy']);
        Route::post('ads_restore/{id}', ['uses' => 'AdsController@restore', 'as' => 'ads.restore']);
        Route::delete('ads_perma_del/{id}', ['uses' => 'AdsController@perma_del', 'as' => 'ads.perma_del']);


        Route::resource('menus', 'MenusController');
        Route::post('menus_mass_destroy', ['uses' => 'MenusController@massDestroy', 'as' => 'menus.mass_destroy']);
        Route::post('menus_restore/{id}', ['uses' => 'MenusController@restore', 'as' => 'menus.restore']);
        Route::delete('menus_perma_del/{id}', ['uses' => 'MenusController@perma_del', 'as' => 'menus.perma_del']);

});


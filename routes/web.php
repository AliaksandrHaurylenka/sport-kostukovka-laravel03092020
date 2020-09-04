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

Route::get('/archive/{year}', 'PostsController@archive');
Route::get('/archive/{month}/{year}', 'PostsController@archiveMonthYear');

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

Route::get('/plavanie', 'SectionsPagesController@swimming')->name('plavanie');
Route::get('/borba', 'SectionsPagesController@wrestling')->name('borba');
Route::get('/legkaya-atletika', 'SectionsPagesController@legkaya_atletika')->name('legkaya-atletika');
Route::get('/tyazhelaya-atletika', 'SectionsPagesController@tyazhelaya_atletika')->name('tyazhelaya-atletika');
Route::get('/futbol', 'SectionsPagesController@football')->name('futbol');
Route::get('/voleybol', 'SectionsPagesController@volleyball')->name('voleybol');

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
    //Route::get('/logout', 'AuthController@logout')->name('logout');
    Route::get('/profile', 'ProfileController@index')->name('profile');
    Route::post('/profile', 'ProfileController@store');
});

Route::group(['middleware' => ['auth', 'trimstriptags', 'del.empty.folder'],
    'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/home', 'HomeController@index');

    Route::resource('roles', 'Admin\RolesController');
    Route::post('roles_mass_destroy', ['uses' => 'Admin\RolesController@massDestroy', 'as' => 'roles.mass_destroy']);

    Route::resource('users', 'Admin\UsersController');
    Route::post('users_mass_destroy', ['uses' => 'Admin\UsersController@massDestroy', 'as' => 'users.mass_destroy']);

    Route::resource('coaches', 'Admin\CoachesController');
    Route::post('coaches_mass_destroy', ['uses' => 'Admin\CoachesController@massDestroy', 'as' => 'coaches.mass_destroy']);
    Route::post('coaches_restore/{id}', ['uses' => 'Admin\CoachesController@restore', 'as' => 'coaches.restore']);
    Route::delete('coaches_perma_del/{id}', ['uses' => 'Admin\CoachesController@perma_del', 'as' => 'coaches.perma_del']);

    Route::resource('directors', 'Admin\DirectorsController');
    Route::post('directors_mass_destroy', ['uses' => 'Admin\DirectorsController@massDestroy', 'as' => 'directors.mass_destroy']);
    Route::post('directors_restore/{id}', ['uses' => 'Admin\DirectorsController@restore', 'as' => 'directors.restore']);
    Route::delete('directors_perma_del/{id}', ['uses' => 'Admin\DirectorsController@perma_del', 'as' => 'directors.perma_del']);

    Route::resource('boards', 'Admin\BoardsController');
    Route::post('boards_mass_destroy', ['uses' => 'Admin\BoardsController@massDestroy', 'as' => 'boards.mass_destroy']);
    Route::post('boards_restore/{id}', ['uses' => 'Admin\BoardsController@restore', 'as' => 'boards.restore']);
    Route::delete('boards_perma_del/{id}', ['uses' => 'Admin\BoardsController@perma_del', 'as' => 'boards.perma_del']);

    Route::resource('mains', 'Admin\MainsController');
    Route::post('mains_mass_destroy', ['uses' => 'Admin\MainsController@massDestroy', 'as' => 'mains.mass_destroy']);
    Route::post('mains_restore/{id}', ['uses' => 'Admin\MainsController@restore', 'as' => 'mains.restore']);
    Route::delete('mains_perma_del/{id}', ['uses' => 'Admin\MainsController@perma_del', 'as' => 'mains.perma_del']);

    Route::resource('histories', 'Admin\HistoriesController');
    Route::post('histories_mass_destroy', ['uses' => 'Admin\HistoriesController@massDestroy', 'as' => 'histories.mass_destroy']);
    Route::post('histories_restore/{id}', ['uses' => 'Admin\HistoriesController@restore', 'as' => 'histories.restore']);
    Route::delete('histories_perma_del/{id}', ['uses' => 'Admin\HistoriesController@perma_del', 'as' => 'histories.perma_del']);

    Route::resource('sections', 'Admin\SectionsController');
    Route::post('sections_mass_destroy', ['uses' => 'Admin\SectionsController@massDestroy', 'as' => 'sections.mass_destroy']);
    Route::post('sections_restore/{id}', ['uses' => 'Admin\SectionsController@restore', 'as' => 'sections.restore']);
    Route::delete('sections_perma_del/{id}', ['uses' => 'Admin\SectionsController@perma_del', 'as' => 'sections.perma_del']);

    Route::resource('services', 'Admin\ServicesController');
    Route::post('services_mass_destroy', ['uses' => 'Admin\ServicesController@massDestroy', 'as' => 'services.mass_destroy']);
    Route::post('services_restore/{id}', ['uses' => 'Admin\ServicesController@restore', 'as' => 'services.restore']);
    Route::delete('services_perma_del/{id}', ['uses' => 'Admin\ServicesController@perma_del', 'as' => 'services.perma_del']);

    Route::resource('prides', 'Admin\PridesController');
    Route::post('prides_mass_destroy', ['uses' => 'Admin\PridesController@massDestroy', 'as' => 'prides.mass_destroy']);
    Route::post('prides_restore/{id}', ['uses' => 'Admin\PridesController@restore', 'as' => 'prides.restore']);
    Route::delete('prides_perma_del/{id}', ['uses' => 'Admin\PridesController@perma_del', 'as' => 'prides.perma_del']);
    
    Route::resource('timetables', 'Admin\TimetablesController');
    Route::post('timetables_mass_destroy', ['uses' => 'Admin\TimetablesController@massDestroy', 'as' => 'timetables.mass_destroy']);
    Route::post('timetables_restore/{id}', ['uses' => 'Admin\TimetablesController@restore', 'as' => 'timetables.restore']);
    Route::delete('timetables_perma_del/{id}', ['uses' => 'Admin\TimetablesController@perma_del', 'as' => 'timetables.perma_del']);

    
    Route::resource('contacts', 'Admin\ContactsController');
    Route::post('contacts_mass_destroy', ['uses' => 'Admin\ContactsController@massDestroy', 'as' => 'contacts.mass_destroy']);
    Route::post('contacts_restore/{id}', ['uses' => 'Admin\ContactsController@restore', 'as' => 'contacts.restore']);
    Route::delete('contacts_perma_del/{id}', ['uses' => 'Admin\ContactsController@perma_del', 'as' => 'contacts.perma_del']);

    Route::resource('categories', 'Admin\CategoriesController');
    Route::post('categories_mass_destroy', ['uses' => 'Admin\CategoriesController@massDestroy', 'as' => 'categories.mass_destroy']);
    Route::post('categories_restore/{id}', ['uses' => 'Admin\CategoriesController@restore', 'as' => 'categories.restore']);
    Route::delete('categories_perma_del/{id}', ['uses' => 'Admin\CategoriesController@perma_del', 'as' => 'categories.perma_del']);

    Route::resource('tags', 'Admin\TagsController');
    Route::post('tags_mass_destroy', ['uses' => 'Admin\TagsController@massDestroy', 'as' => 'tags.mass_destroy']);
    Route::post('tags_restore/{id}', ['uses' => 'Admin\TagsController@restore', 'as' => 'tags.restore']);
    Route::delete('tags_perma_del/{id}', ['uses' => 'Admin\TagsController@perma_del', 'as' => 'tags.perma_del']);

    
    Route::resource('comments', 'Admin\CommentsController');
    Route::get('/comment/toggle/{id}', 'Admin\CommentsController@toggle');
    Route::post('comments_mass_destroy', ['uses' => 'Admin\CommentsController@massDestroy', 'as' => 'comments.mass_destroy']);
    Route::post('comments_restore/{id}', ['uses' => 'Admin\CommentsController@restore', 'as' => 'comments.restore']);
    Route::delete('comments_perma_del/{id}', ['uses' => 'Admin\CommentsController@perma_del', 'as' => 'comments.perma_del']);

    Route::resource('poststags', 'Admin\PoststagsController');
    Route::post('poststags_mass_destroy', ['uses' => 'Admin\PoststagsController@massDestroy', 'as' => 'poststags.mass_destroy']);
    Route::post('poststags_restore/{id}', ['uses' => 'Admin\PoststagsController@restore', 'as' => 'poststags.restore']);
    Route::delete('poststags_perma_del/{id}', ['uses' => 'Admin\PoststagsController@perma_del', 'as' => 'poststags.perma_del']);

    Route::resource('subscribes', 'Admin\SubscribesController');
    Route::post('subscribes_mass_destroy', ['uses' => 'Admin\SubscribesController@massDestroy', 'as' => 'subscribes.mass_destroy']);
    Route::post('subscribes_restore/{id}', ['uses' => 'Admin\SubscribesController@restore', 'as' => 'subscribes.restore']);
    Route::delete('subscribes_perma_del/{id}', ['uses' => 'Admin\SubscribesController@perma_del', 'as' => 'subscribes.perma_del']);

    Route::resource('gomelglasses', 'Admin\GomelglassesController');
    Route::post('gomelglasses_mass_destroy', ['uses' => 'Admin\GomelglassesController@massDestroy', 'as' => 'gomelglasses.mass_destroy']);
    Route::post('gomelglasses_restore/{id}', ['uses' => 'Admin\GomelglassesController@restore', 'as' => 'gomelglasses.restore']);
    Route::delete('gomelglasses_perma_del/{id}', ['uses' => 'Admin\GomelglassesController@perma_del', 'as' => 'gomelglasses.perma_del']);
    
    Route::resource('banners', 'Admin\BannersController');
    Route::post('banners_mass_destroy', ['uses' => 'Admin\BannersController@massDestroy', 'as' => 'banners.mass_destroy']);
    Route::post('banners_restore/{id}', ['uses' => 'Admin\BannersController@restore', 'as' => 'banners.restore']);
    Route::delete('banners_perma_del/{id}', ['uses' => 'Admin\BannersController@perma_del', 'as' => 'banners.perma_del']);

    Route::resource('posts', 'Admin\PostsController');
    Route::get('/post/toggle/{id}', 'Admin\PostsController@toggle');
    Route::post('posts_mass_destroy', ['uses' => 'Admin\PostsController@massDestroy', 'as' => 'posts.mass_destroy']);
    Route::post('posts_restore/{id}', ['uses' => 'Admin\PostsController@restore', 'as' => 'posts.restore']);
    Route::delete('posts_perma_del/{id}', ['uses' => 'Admin\PostsController@perma_del', 'as' => 'posts.perma_del']);


    Route::resource('ads', 'Admin\AdsController');
    Route::get('/ad/toggle/{id}', 'Admin\AdsController@toggle');
    Route::post('ads_mass_destroy', ['uses' => 'Admin\AdsController@massDestroy', 'as' => 'ads.mass_destroy']);
    Route::post('ads_restore/{id}', ['uses' => 'Admin\AdsController@restore', 'as' => 'ads.restore']);
    Route::delete('ads_perma_del/{id}', ['uses' => 'Admin\AdsController@perma_del', 'as' => 'ads.perma_del']);


    Route::resource('menus', 'Admin\MenusController');
    Route::post('menus_mass_destroy', ['uses' => 'Admin\MenusController@massDestroy', 'as' => 'menus.mass_destroy']);
    Route::post('menus_restore/{id}', ['uses' => 'Admin\MenusController@restore', 'as' => 'menus.restore']);
    Route::delete('menus_perma_del/{id}', ['uses' => 'Admin\MenusController@perma_del', 'as' => 'menus.perma_del']);

});


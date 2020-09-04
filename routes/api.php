<?php

Route::group(['prefix' => '/v1', 'namespace' => 'Api\V1', 'as' => 'api.'], function () {

        Route::resource('coaches', 'CoachesController', ['except' => ['create', 'edit']]);

        Route::resource('directors', 'DirectorsController', ['except' => ['create', 'edit']]);

        Route::resource('boards', 'BoardsController', ['except' => ['create', 'edit']]);

        Route::resource('mains', 'MainsController', ['except' => ['create', 'edit']]);

        Route::resource('histories', 'HistoriesController', ['except' => ['create', 'edit']]);

        Route::resource('sections', 'SectionsController', ['except' => ['create', 'edit']]);

        Route::resource('services', 'ServicesController', ['except' => ['create', 'edit']]);

        Route::resource('prides', 'PridesController', ['except' => ['create', 'edit']]);
        
        Route::resource('timetables', 'TimetablesController', ['except' => ['create', 'edit']]);

        Route::resource('ads', 'AdsController', ['except' => ['create', 'edit']]);

        Route::resource('contacts', 'ContactsController', ['except' => ['create', 'edit']]);

        Route::resource('categories', 'CategoriesController', ['except' => ['create', 'edit']]);

        Route::resource('tags', 'TagsController', ['except' => ['create', 'edit']]);

        Route::resource('posts', 'PostsController', ['except' => ['create', 'edit']]);

        Route::resource('comments', 'CommentsController', ['except' => ['create', 'edit']]);

        Route::resource('poststags', 'PoststagsController', ['except' => ['create', 'edit']]);

        Route::resource('subscribes', 'SubscribesController', ['except' => ['create', 'edit']]);

        Route::resource('gomelglasses', 'GomelglassesController', ['except' => ['create', 'edit']]);

        Route::resource('banners', 'BannersController', ['except' => ['create', 'edit']]);

});

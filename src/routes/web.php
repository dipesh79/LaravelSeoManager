<?php

use Dipesh79\LaravelSeoManager\Http\Controllers\SEOController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SEO Routes
|--------------------------------------------------------------------------
|
| Here is where you can register SEO related routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" and "auth" middleware groups.
|
*/
if (config('laravel-seo-manager.show_dashboard', true)) {
    Route::controller(SEOController::class)
        ->prefix('admin/seo') // Prefix all routes with 'admin/seo'
        ->as('admin.seo.') // Name all routes with the 'admin.seo.' prefix
        ->middleware(config('laravel-seo-manager.middleware'))
        ->group(function () {
            // Route to display the list of SEO entries
            Route::get('/', 'index')->name('index');

            // Route to show the form for creating a new SEO entry
            Route::get('/create', 'create')->name('create');

            // Route to store a newly created SEO entry
            Route::post('/store', 'store')->name('store');

            // Route to display a specific SEO entry
            Route::get('/show/{id}', 'show')->name('show');

            // Route to show the form for editing a specific SEO entry
            Route::get('/edit/{id}', 'edit')->name('edit');

            // Route to update a specific SEO entry
            Route::put('/update/{id}', 'update')->name('update');

            // Route to delete a specific SEO entry
            Route::delete('/delete/{id}', 'destroy')->name('delete');

            // Route to generate static pages for SEO
            Route::post('/generate-static-pages', 'generateStaticPages')->name('generate-static-pages');
        });
}

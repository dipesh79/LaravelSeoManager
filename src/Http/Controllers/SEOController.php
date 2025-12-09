<?php

namespace Dipesh79\LaravelSeoManager\Http\Controllers;

use App\Http\Controllers\Controller;
use Dipesh79\LaravelSeoManager\Http\Requests\CreateRequest;
use Dipesh79\LaravelSeoManager\Http\Requests\DeleteRequest;
use Dipesh79\LaravelSeoManager\Http\Requests\EditRequest;
use Dipesh79\LaravelSeoManager\Http\Requests\IndexRequest;
use Dipesh79\LaravelSeoManager\Http\Requests\ShowRequest;
use Dipesh79\LaravelSeoManager\Http\Requests\StoreRequest;
use Dipesh79\LaravelSeoManager\Http\Requests\UpdateRequest;
use Dipesh79\LaravelSeoManager\Models\Seo;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Class SEOController
 *
 * This controller handles the CRUD operations for SEO tags.
 */
class SEOController extends Controller
{
    /**
     * Display a listing of the SEO tags.
     *
     * @param IndexRequest $request The request instance.
     * @return View The view displaying the list of SEO tags.
     */
    public function index(IndexRequest $request): View
    {
        $search = $request->input('search');
        $tags = Seo::where('title', 'like', "%{$search}%")
            ->orWhere('uri', 'like', "%{$search}%")
            ->orWhere('description', 'like', "%{$search}%")
            ->orWhere('keywords', 'like', "%{$search}%")
            ->orWhere('uri', 'like', "%{$search}%")
            ->paginate(config('laravel-seo-manager.pagination_limit'))
            ->appends(['search' => $search]);
        return view('seo::seo.index', compact('tags','search'));
    }

    /**
     * Store a newly created SEO tag in the database.
     *
     * @param StoreRequest $request The request instance.
     * @return RedirectResponse A redirect response to the SEO index page.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $seo = Seo::create(
                [
                    'uri' => $request->uri,
                    'title' => $request->title,
                    'description' => $request->description,
                    'keywords' => $request->keywords,
                    'robots' => $request->robots,
                    'og_title' => $request->og_title,
                    'og_description' => $request->og_description,
                    'og_url' => $request->og_url,
                    'twitter_card' => $request->twitter_card,
                    'twitter_title' => $request->twitter_title,
                    'twitter_description' => $request->twitter_description,
                    'schema_type' => $request->schema_type,
                    'schema_name' => $request->schema_name,
                    'schema_description' => $request->schema_description,
                    'schema_url' => $request->schema_url,
                    'type' => $request->type,
                    'json_ld' => $request->json_ld,
                ]
            );
            if ($request->og_image) {
                $seo->addMedia($request->og_image)->toMediaCollection('og');
            }
            if ($request->twitter_image) {
                $seo->addMedia($request->twitter_image)->toMediaCollection('twitter');
            }
        } catch (Exception $exception) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong. Please try again');
        }
        DB::commit();
        return redirect()->route('admin.seo.index')->with('success', 'SEO Tag Created Successfully');
    }

    /**
     * Show the form for creating a new SEO tag.
     *
     * @param CreateRequest $request The request instance.
     * @return View The view displaying the form for creating a new SEO tag.
     */
    public function create(CreateRequest $request): View
    {
        return view('seo::seo.create');
    }

    /**
     * Display the specified SEO tag.
     *
     * @param ShowRequest $request The request instance.
     * @param int $id The ID of the SEO tag to display.
     * @return View The view displaying the specified SEO tag.
     */
    public function show(ShowRequest $request, int $id): View
    {
        $tag = Seo::findorFail($id);
        return view('seo::seo.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified SEO tag.
     *
     * @param EditRequest $request The request instance.
     * @param int $id The ID of the SEO tag to edit.
     * @return View The view displaying the form for editing the specified SEO tag.
     */
    public function edit(EditRequest $request, int $id): View
    {
        $tag = Seo::findorFail($id);
        return view('seo::seo.edit', compact('tag'));
    }

    /**
     * Update the specified SEO tag in the database.
     *
     * @param UpdateRequest $request The request instance.
     * @param int $id The ID of the SEO tag to update.
     * @return RedirectResponse A redirect response to the SEO index page.
     */
    public function update(UpdateRequest $request, int $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $seo = Seo::findorFail($id);
            $seo->update(
                [
                    'uri' => $request->uri,
                    'title' => $request->title,
                    'description' => $request->description,
                    'keywords' => $request->keywords,
                    'robots' => $request->robots,
                    'og_title' => $request->og_title,
                    'og_description' => $request->og_description,
                    'og_url' => $request->og_url,
                    'twitter_card' => $request->twitter_card,
                    'twitter_title' => $request->twitter_title,
                    'twitter_description' => $request->twitter_description,
                    'schema_type' => $request->schema_type,
                    'schema_name' => $request->schema_name,
                    'schema_description' => $request->schema_description,
                    'schema_url' => $request->schema_url,
                    'type' => $request->type,
                    'json_ld' => $request->json_ld
                ]
            );
            if ($request->og_image) {
                $seo->addMedia($request->og_image)->toMediaCollection('og');
            }
            if ($request->twitter_image) {
                $seo->addMedia($request->twitter_image)->toMediaCollection('twitter');
            }

        } catch (Exception $exception) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong. Please try again');
        }
        DB::commit();
        return redirect()->route('admin.seo.index')->with('success', 'SEO Tag Updated Successfully');
    }

    /**
     * Remove the specified SEO tag from the database.
     *
     * @param DeleteRequest $request The request instance.
     * @param int $id The ID of the SEO tag to delete.
     * @return RedirectResponse A redirect response to the SEO index page.
     */
    public function destroy(DeleteRequest $request, int $id): RedirectResponse
    {
        try {
            Seo::destroy($id);
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
        return redirect()->route('admin.seo.index')->with('success', 'SEO Tag Deleted Successfully');
    }

    /**
     * Generate static pages for SEO.
     *
     * @param CreateRequest $request The request instance.
     * @return RedirectResponse A redirect response to the SEO index page.
     */
    public function generateStaticPages(CreateRequest $request): RedirectResponse
    {
        try {
            Artisan::call('seo:generate');
        }
        catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
        return redirect()->route('admin.seo.index')->with('success', 'Static Pages Generated Successfully');
    }
}

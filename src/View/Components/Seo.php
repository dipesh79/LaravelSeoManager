<?php

namespace Dipesh79\LaravelSeoManager\View\Components;

use Dipesh79\LaravelSeoManager\Models\Seo as SeoModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

/**
 * Class Seo
 *
 * This component is responsible for managing SEO attributes for a given page.
 * It retrieves SEO data from the database based on the current URL and applies
 * the appropriate SEO attributes.
 */
class Seo extends Component
{
    public string|null $title;
    public string|null $description;
    public string|null $keywords;
    public string|null $robots;
    public string|null $canonical;

    public string|null $ogTitle;
    public string|null $ogDescription;
    public string|null $ogImage;
    public string|null $ogUrl;

    public string|null $twitterCard;
    public string|null $twitterTitle;
    public string|null $twitterDescription;
    public string|null $twitterImage;

    public string|null $schemaType;
    public string|null $schemaName;
    public string|null $schemaDescription;
    public string|null $schemaUrl;

    public string|null $jsonLd;

    /**
     * Create a new component instance.
     *
     * Initializes the SEO attributes by setting default values and then
     * attempting to override them with values from the database if a match
     * is found for the current URL.
     */
    public function __construct()
    {
        $url = request()->path();
        $this->canonical = url()->current();

        $this->setDefaultSeoAttributes();
        $seoTag = $this->getSeoTag($url);

        if ($seoTag) {
            $this->applySeoAttributes($seoTag);
        }
    }

    /**
     * Set default SEO attributes from the configuration.
     */
    private function setDefaultSeoAttributes(): void
    {
        $this->title = config('laravel-seo-manager.title');
        $this->description = config('laravel-seo-manager.description');
        $this->keywords = config('laravel-seo-manager.keywords');
        $this->robots = config('laravel-seo-manager.robots');

        $this->ogTitle = config('laravel-seo-manager.og.title');
        $this->ogDescription = config('laravel-seo-manager.og.description');
        $this->ogImage = config('laravel-seo-manager.og.image');
        $this->ogUrl = $this->canonical;

        $this->twitterCard = config('laravel-seo-manager.twitter.card');
        $this->twitterTitle = config('laravel-seo-manager.twitter.title');
        $this->twitterDescription = config('laravel-seo-manager.twitter.description');
        $this->twitterImage = config('laravel-seo-manager.twitter.image');

        $this->schemaType = config('laravel-seo-manager.schema.type');
        $this->schemaName = config('laravel-seo-manager.schema.name');
        $this->schemaDescription = config('laravel-seo-manager.schema.description');
        $this->schemaUrl = $this->canonical;
        $this->jsonLd = null;
    }

    /**
     * Retrieve the SEO tag from the database based on the current URL.
     *
     * @param string $url The current URL path.
     * @return SeoModel|null The SEO model if a match is found, otherwise null.
     */
    private function getSeoTag(string $url): ?SeoModel
    {
        $seoTag = SeoModel::where('uri', '=', $url)->first();
        if (!$seoTag) {
            $seoTags = SeoModel::all();
            foreach ($seoTags as $tag) {
                if (fnmatch($tag->uri, $url)) {
                    $seoTag = $tag;
                    break;
                }
            }
        }
        return $seoTag;
    }

    /**
     * Apply the SEO attributes from the given SEO model.
     *
     * @param SeoModel $seoTag The SEO model containing the attributes to apply.
     */
    private function applySeoAttributes(SeoModel $seoTag): void
    {
        $this->title = $this->getSeoAttribute($seoTag->title, 'title');
        $this->description = $this->getSeoAttribute($seoTag->description, 'description');
        $this->keywords = $this->getSeoAttribute($seoTag->keywords, 'keywords');
        $this->robots = $this->getSeoAttribute($seoTag->robots, 'robots');

        $this->ogTitle = $this->getSeoAttribute($seoTag->og_title, 'og.title');
        $this->ogDescription = $this->getSeoAttribute($seoTag->og_description, 'og.description');
        $this->ogImage = $this->getSeoAttribute($seoTag->og_image, 'og.image');
        $this->ogUrl = $this->getSeoAttribute($seoTag->og_url, 'og.url', $this->canonical);

        $this->twitterCard = $this->getSeoAttribute($seoTag->twitter_card, 'twitter.card');
        $this->twitterTitle = $this->getSeoAttribute($seoTag->twitter_title, 'twitter.title');
        $this->twitterDescription = $this->getSeoAttribute($seoTag->twitter_description, 'twitter.description');
        $this->twitterImage = $this->getSeoAttribute($seoTag->twitter_image, 'twitter.image');

        $this->schemaType = $this->getSeoAttribute($seoTag->schema_type, 'schema.type');
        $this->schemaName = $this->getSeoAttribute($seoTag->schema_name, 'schema.name');
        $this->schemaDescription = $this->getSeoAttribute($seoTag->schema_description, 'schema.description');
        $this->schemaUrl = $this->getSeoAttribute($seoTag->schema_url, 'schema.url', $this->canonical);
        $this->jsonLd = $seoTag->json_ld ?: null;
    }

    /**
     * Get the SEO attribute value, falling back to a configuration value if not set.
     *
     * @param string|null $attribute The attribute value from the SEO model.
     * @param string $configKey The configuration key to use if the attribute is not set.
     * @param string|null $default The default value to use if neither the attribute nor the configuration value is set.
     * @return string|null The final attribute value.
     */
    private function getSeoAttribute(?string $attribute, string $configKey, ?string $default = null): ?string
    {
        return $attribute ?: config("laravel-seo-manager.$configKey", $default);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return View The view representing the component.
     */
    public function render(): View
    {
        return view('seo::components.seo');
    }
}

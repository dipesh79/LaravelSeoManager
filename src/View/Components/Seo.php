<?php

namespace Dipesh79\LaravelSeoManager\View\Components;

use Dipesh79\LaravelSeoManager\Models\Seo as SeoModel;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

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

    public string|null $jsonLd;

    public function __construct()
    {
        $url = request()->path();

        $this->canonical = $this->getCanonicalUrl();

        $this->setDefaultSeoAttributes();

        $seoTag = $this->getSeoTag($url);

        if ($seoTag) {
            $this->applySeoAttributes($seoTag);
        }
    }

    /**
     * Get the canonical URL for the current page.
     *
     * Pagination parameters such as ?page=2 are preserved.
     *
     * Tracking parameters and other non-canonical query parameters
     * should not be included.
     */
    private function getCanonicalUrl(): string
    {
        $query = request()->query();

        /*
         * Parameters that should never be part of the canonical URL.
         */
        $excludedParameters = [
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'utm_term',
            'utm_content',
            'gclid',
            'fbclid',
        ];

        $query = collect($query)
            ->except($excludedParameters)
            ->all();

        /*
         * Remove empty values.
         */
        $query = collect($query)
            ->filter(fn ($value) => filled($value))
            ->all();

        /*
         * Build the canonical URL.
         */
        $url = url()->current();

        if (!empty($query)) {
            $url .= '?' . http_build_query($query);
        }

        return $url;
    }

    private function setDefaultSeoAttributes(): void
    {
        $this->title = config('laravel-seo-manager.title');
        $this->description = config('laravel-seo-manager.description');
        $this->keywords = config('laravel-seo-manager.keywords');
        $this->robots = config('laravel-seo-manager.robots');

        $this->ogTitle = null;
        $this->ogDescription = null;
        $this->ogImage = null;
        $this->ogUrl = $this->canonical;

        $this->twitterCard = null;
        $this->twitterTitle = null;
        $this->twitterDescription = null;
        $this->twitterImage = null;

        $this->jsonLd = null;
    }

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

    private function applySeoAttributes(SeoModel $seoTag): void
    {
        $this->title = $this->getSeoAttribute(
            $seoTag->title,
            'title'
        );

        $this->description = $this->getSeoAttribute(
            $seoTag->description,
            'description'
        );

        $this->keywords = $this->getSeoAttribute(
            $seoTag->keywords,
            'keywords'
        );

        $this->robots = $this->getSeoAttribute(
            $seoTag->robots,
            'robots'
        );

        $this->ogTitle = $seoTag->title ?? null;
        $this->ogDescription = $seoTag->og_description ?? null;
        $this->ogImage = $seoTag->ogImage() ?? null;
        $this->ogUrl = $seoTag->og_url ?: $this->canonical;

        $this->twitterCard = $seoTag->twitter_card ?? null;
        $this->twitterTitle = $seoTag->twitter_title ?? null;
        $this->twitterDescription = $seoTag->twitter_description ?? null;
        $this->twitterImage = $seoTag->twitterImage() ?? null;

        $this->jsonLd = $seoTag->json_ld ?: null;
    }

    private function getSeoAttribute(
        ?string $attribute,
        string $configKey,
        ?string $default = null
    ): ?string {
        return $attribute ?: config(
            "laravel-seo-manager.$configKey",
            $default
        );
    }

    public function render(): View
    {
        return view('seo::components.seo');
    }
}

<?php

namespace Dipesh79\LaravelSeoManager\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Seo
 *
 * Represents the SEO model which is used to manage SEO tags for various models.
 *
 * @property mixed $title The title tag for SEO.
 * @property mixed $description The description tag for SEO.
 * @property mixed $keywords The keyword tag for SEO.
 * @property mixed $robots The robot tag for SEO.
 * @property mixed $og_title The Open Graph title tag for SEO.
 * @property mixed $og_description The Open Graph description tag for SEO.
 * @property mixed $og_image The Open Graph image tag for SEO.
 * @property mixed $og_url The Open Graph URL tag for SEO.
 * @property mixed $twitter_card The Twitter card type for SEO.
 * @property mixed $twitter_title The Twitter title tag for SEO.
 * @property mixed $twitter_description The Twitter description tag for SEO.
 * @property mixed $twitter_image The Twitter image tag for SEO.
 * @property mixed $schema_type The schema type for SEO.
 * @property mixed $schema_name The schema name for SEO.
 * @property mixed $schema_description The schema description tag for SEO.
 * @property mixed $schema_url The schema URL for SEO.
 * @property mixed $uri The URI associated with the SEO tags.
 * @package App\Models
 * @method static firstOrCreate(array $array, string[] $array1) Find the first record matching the attributes or create it.
 * @method static where(string $string, string $operator, string $url) Add a basic where clause to the query.
 */
class Seo extends Model implements HasMedia
{
    use InteractsWithMedia;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'seo_tags';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'json_ld' => 'array',
    ];

    /**
     * Get the parent seoable model (morph to relationship).
     *
     * @return MorphTo
     */
    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the URL of the Open Graph image.
     *
     * @return string The URL of the Open Graph image or the default image URL from the configuration.
     */
    public function ogImage(): string
    {
        return $this->getMedia('og')->count()
            ? $this->getMedia('og')
                ->last()
                ->getUrl()
            : config('laravel-seo-manager.og.image');
    }

    /**
     * Get the URL of the Twitter image.
     *
     * @return string The URL of the Twitter image or the default image URL from the configuration.
     */
    public function twitterImage(): string
    {
        return $this->getMedia('twitter')->count()
            ? $this->getMedia('twitter')
                ->last()
                ->getUrl()
            : config('laravel-seo-manager.twitter.image');
    }
}

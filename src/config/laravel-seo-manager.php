<?php

return [
    /**
     * Enable or Disable SEO Manager Dashboard.
     */
    'show_dashboard' => true,
    /**
     * Middleware for SEO Manager Route.
     */
    'middleware' => ['web', 'auth'],

    /**
     * Redirect URL from SEO Manager Dashboard.
     */
    'redirect_url' => '/home',

    /**
     * Default Pagination Limit for SEO Manager.
     */
    'pagination_limit' => 10,

    /**
     * Default title for the application.
     *
     * The title will be used as the title of the page.
     */
    'title' => 'Title',

    /**
     * Default meta-description for the application.
     *
     * The description will be used as the meta description of the page.
     */
    'description' => 'Description',

    /**
     * Default meta-keywords for the application.
     *
     * The keywords will be used as the meta-keywords of the page.
     */
    'keywords' => 'Keywords',

    /**
     * Default meta-robots for the application.
     *
     * Available options: index, noindex, follow, nofollow.
     */
    'robots' => 'index, follow',
];

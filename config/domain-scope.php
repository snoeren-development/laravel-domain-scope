<?php
declare(strict_types = 1);

use App\Models\Domain;

return [

    /*
    |--------------------------------------------------------------------------
    | Table
    |--------------------------------------------------------------------------
    |
    | Configure which table it should use to define domains in your
    | application.
    |
    */

    'table' => env('DOMAINSCOPE_TABLE', 'domains'),

    /*
    |--------------------------------------------------------------------------
    | Column
    |--------------------------------------------------------------------------
    |
    | Define the column to identify domains with. Ideally, this column should
    | be indexed for fast searches.
    |
    */

    'column' => env('DOMAINSCOPE_COLUMN', 'domain'),

    /*
    |--------------------------------------------------------------------------
    | Related column.
    |--------------------------------------------------------------------------
    |
    | Define the related column that is available on every scoped model. This
    | column will be used to scope all queries of the scoped models as
    | configured below.
    |
    */

    'related' => env('DOMAINSCOPE_RELATED', 'domain_id'),

    /*
    |--------------------------------------------------------------------------
    | Mode
    |--------------------------------------------------------------------------
    |
    | Define the domain mode here. You can either search for subdomains or full
    | domains. Supported values are: sub, full
    |
    */

    'mode' => env('DOMAINSCOPE_MODE', 'sub'),

    /*
    |--------------------------------------------------------------------------
    | Model
    |--------------------------------------------------------------------------
    |
    | Configure what model to use to retrieve domains with. By default, the
    | published domain model will be used.
    |
    */

    'model' => Domain::class,

    /*
    |--------------------------------------------------------------------------
    | Excluded (sub)domains.
    |--------------------------------------------------------------------------
    |
    | Configure what (sub)domains should be ignored by the resolver. Typically,
    | applications ignore the `www` prefix, but you can ignore any (sub)domain
    | you'd like.
    |
    */

    'ignore' => array_map('strtolower', explode(',', env('DOMAINSCOPE_IGNORE', 'www'))),

    /*
    |--------------------------------------------------------------------------
    | Scoped models.
    |--------------------------------------------------------------------------
    |
    | Define the list of scoped models. These models will be scoped by the
    | currently active domain. Just make sure these models contain a
    | `domain_id` column.
    |
    */

    'scoped' => [
        // User::class
        // 'App\Models\User'
    ],

    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | The cache settings define how to cache domain-lookups. Lookups are done
    | on every request, which is unnecessary as domains are pretty static data.
    |
    | ttl
    | -----
    | The time-to-live for cached domains in seconds. 0 disables the cache.
    |
    | key
    | -----
    | {domain} will be replaced by the lowercase variant of the domain, based
    | on mode. It will insert the subdomain in sub mode and the full domain
    | in full mode. You, as developer, can re-use this key to populate or clear
    | the cache in your part of the application.
    |
    */

    'cache' => [
        'ttl' => (int) env('DOMAINSCOPE_CACHE_TTL', 60),
        'key' => env('DOMAINSCOPE_CACHE_KEY', 'domain-scope.{domain}'),
    ],

];

<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\DomainScope\Resolvers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class FullDomainResolver implements Resolver
{
    /**
     * Resolve the current domain.
     *
     * @param  string $domain The domain.
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function resolve(string $domain): ?Model
    {
        $model = config('domain-scope.model');

        // Check if the domain is on the ignore list.
        if (in_array($domain, config('domain-scope.ignore'))) {
            return null;
        }

        return Cache::remember(
            str_replace('{domain}', $domain, config('domain-scope.cache.key')),
            config('domain-scope.cache.ttl'),
            function () use ($model, $domain): ?Model {
                return (new $model)
                    ->setTable(config('domain-scope.table'))
                    ->where(config('domain-scope.column'), $domain)
                    ->first();
            }
        );
    }
}

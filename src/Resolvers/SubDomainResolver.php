<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\DomainScope\Resolvers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class SubDomainResolver implements Resolver
{
    /**
     * Resolve the current domain.
     *
     * @param  string $domain The domain.
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function resolve(string $domain): ?Model
    {
        $parts = explode('.', $domain);
        $model = config('domain-scope.model');

        // Check if a developer is developing locally.
        if (!app()->environment('production') && count($parts) === 2 && $parts[1] === 'localhost') {
            return in_array($parts[0], config('domain-scope.ignore'))
                ? null
                : $this->resolveDomain($model, $parts[0]);
        }

        // Typically, a domain with a subdomain consists of at least 3 elements.
        if (count($parts) < 3) {
            return null;
        }

        // Check if the subdomain is ignored.
        if (in_array($parts[0], config('domain-scope.ignore'))) {
            return null;
        }

        return $this->resolveDomain($model, $parts[0]);
    }

    /**
     * Resolve and cache the domain model.
     *
     * @param  string $model  The model classname.
     * @param  string $domain The domain name.
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    private function resolveDomain(string $model, string $domain): ?Model
    {
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

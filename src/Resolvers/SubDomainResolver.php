<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\DomainScope\Resolvers;

class SubDomainResolver implements Resolver
{
    /**
     * Resolve the current domain.
     *
     * @param  string $domain The domain.
     * @return null|\App\Models\Domain
     */
    public function resolve(string $domain) // phpcs:ignore
    {
        $parts = explode('.', $domain);
        $model = config('domain-scope.model');

        // Check if a developer is developing locally.
        if (!app()->environment('production') && count($parts) === 2 && strtolower($parts[1]) === 'localhost') {
            return in_array($parts[0], config('domain-scope.ignore'))
                ? null
                : (new $model)
                    ->setTable(config('domain-scope.table'))
                    ->where(config('domain-scope.column'), strtolower($parts[0]))
                    ->first();
        }

        // Typically, a domain with a subdomain consists of at least 3 elements.
        if (count($parts) < 3) {
            return null;
        }

        // Check if the subdomain is ignored.
        if (in_array($parts[0], config('domain-scope.ignore'))) {
            return null;
        }

        return (new $model)
            ->setTable(config('domain-scope.table'))
            ->where(config('domain-scope.column'), strtolower($parts[0]))
            ->first();
    }
}

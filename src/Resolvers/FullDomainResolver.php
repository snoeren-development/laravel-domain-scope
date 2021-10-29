<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\DomainScope\Resolvers;

class FullDomainResolver implements Resolver
{
    /**
     * Resolve the current domain.
     *
     * @param  string $domain The domain.
     * @return null|\App\Models\Domain
     */
    public function resolve(string $domain) // phpcs:ignore
    {
        $model = config('domain-scope.model');

        // Check if the domain is on the ignore list.
        if (in_array(strtolower($domain), config('domain-scope.ignore'))) {
            return null;
        }

        return (new $model)
            ->where('domain', strtolower($domain))
            ->first();
    }
}

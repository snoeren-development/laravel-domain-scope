<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\DomainScope\Resolvers;

interface Resolver
{
    /**
     * Resolve the current domain.
     *
     * @param  string $domain The domain.
     * @return null|\App\Models\Domain
     */
    public function resolve(string $domain); // phpcs:ignore
}

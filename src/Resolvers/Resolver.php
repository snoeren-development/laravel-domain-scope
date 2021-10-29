<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\DomainScope\Resolvers;

use Illuminate\Database\Eloquent\Model;

interface Resolver
{
    /**
     * Resolve the current domain.
     *
     * @param  string $domain The domain.
     * @return null|\Illuminate\Database\Eloquent\Model
     */
    public function resolve(string $domain): ?Model;
}

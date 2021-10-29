<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\DomainScope\Scopes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Builder;

class DomainScope implements Scope
{
    /**
     * The domain model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected Model $domain;

    /**
     * Constructor
     *
     * @param  \Illuminate\Database\Eloquent\Model $domain The domain model.
     * @return void
     */
    public function __construct(Model $domain)
    {
        $this->domain = $domain;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder The query builder.
     * @param  \Illuminate\Database\Eloquent\Model   $model   The model object.
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where(config('domain-scope.related'), $this->domain->getKey());
    }
}

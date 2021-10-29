<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\DomainScope\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use SnoerenDevelopment\DomainScope\Scopes\DomainScope;

class DetectDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request The request object.
     * @param  \Closure                 $next    The next handler.
     * @return mixed
     */
    public function handle(Request $request, Closure $next) // phpcs:ignore
    {
        $domain = $request->getHost();

        /** @var \SnoerenDevelopment\DomainScope\Resolvers\Resolver $resolver */
        $resolver = app('domain-scope.resolver');
        $model = $resolver->resolve($domain);

        // If a domain has been matched, configure the application.
        if ($model) {
            // Bind the current domain into the service container.
            app()->singleton('domain', fn () => $model);
            app()->singleton(config('domain-scope.model'), fn () => $model);

            // Scope all configured models.
            $scope = new DomainScope($model);
            foreach (config('domain-scope.scoped') as $scopedModel) {
                $scopedModel::addGlobalScope($scope);
            }
        }

        return $next($request);
    }
}

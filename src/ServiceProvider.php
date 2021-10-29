<?php
declare(strict_types = 1);

namespace SnoerenDevelopment\DomainScope;

use SnoerenDevelopment\DomainScope\Resolvers\Resolver;
use SnoerenDevelopment\DomainScope\Resolvers\SubDomainResolver;
use SnoerenDevelopment\DomainScope\Resolvers\FullDomainResolver;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/domain-scope.php', 'domain-scope');

        $this->app->singleton('domain-scope.resolver.sub', SubDomainResolver::class);
        $this->app->singleton('domain-scope.resolver.full', FullDomainResolver::class);
        $this->app->singleton('domain-scope.resolver', function ($app): Resolver {
            return app('domain-scope.resolver.' . config('domain-scope.mode'));
        });
    }

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $timestamp = date('Y_m_d_His', time());

            $this->publishes([__DIR__ . '/../config/domain-scope.php' => config_path('domain-scope.php')], 'config');
            $this->publishes([__DIR__ . '/../app/Models/Domain.php.stub' => app_path('Models/Domain.php')], 'models');
            $this->publishes([
                __DIR__ . '/../database/migrations/create_domains_table.php.stub' =>
                    database_path("migrations/{$timestamp}_create_domains_table.php"),
            ], 'migrations');
        }
    }
}

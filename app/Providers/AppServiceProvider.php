<?php

namespace Fce\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerRepositories('Database', 'Eloquent');
    }

    /**
     * Registers the repositories according to the specified namespace and type
     *
     * @param string $namespace
     * @param string $type
     */
    public function registerRepositories($namespace, $type)
    {
        $prefix = 'Fce\Repositories\\';

        $contracts = File::allFiles(__DIR__ . '/../Repositories/Contracts');

        foreach ($contracts as $contract) {
            $contract = str_replace('.php', '', $contract->getFileName());

            $this->app->bind(
                $prefix . 'Contracts\\' . $contract,
                $prefix . $namespace . '\\' . $type . $contract
            );
        }

    }
}

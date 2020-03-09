<?php

namespace App\Providers;

use App\Repositories\Interfaces\NewsRepositoryInterface;
use App\Repositories\NewsRepository;
use App\Services\NewsImportService;
use App\Services\NewsImportServiceInterface;
use App\SourceProviders\DataProvider;
use App\SourceProviders\Interfaces\DataProviderInterface;
use App\SourceProviders\Interfaces\WebSourceProviderInterface;
use App\SourceProviders\WebSourceProvider;
use App\Sources\Interfaces\MainPageParserInterface;
use App\Sources\Interfaces\PageParserFactoryInterface;
use App\Sources\Rbc\Parsers\RBCMainPageParser;
use App\Sources\Rbc\RBCPageParserFactory;
use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(WebSourceProviderInterface::class, function ($app) {
            return new WebSourceProvider(
                new Client()
            );
        });

        $this->app->singleton(MainPageParserInterface::class, function ($app) {
            return new RBCMainPageParser();
        });

        $this->app->singleton(PageParserFactoryInterface::class, function ($app) {
            return new RBCPageParserFactory();
        });

        $this->app->singleton(DataProviderInterface::class, function ($app) {
            return new DataProvider(
                $app->make(WebSourceProviderInterface::class),
                $app->make(MainPageParserInterface::class),
                $app->make(PageParserFactoryInterface::class)
            );
        });

        $this->app->singleton(NewsRepositoryInterface::class, function ($app) {
            return new NewsRepository();
        });

        $this->app->singleton(NewsImportServiceInterface::class, function ($app) {
            return new NewsImportService(
                $app->make(DataProviderInterface::class),
                $app->make(NewsRepositoryInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

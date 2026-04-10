<?php

namespace Mmt\TradingServiceSdk;

use Illuminate\Support\ServiceProvider;
use Mmt\TradingServiceSdk\Platforms\TradingService;
use Mmt\TradingServiceSdk\TransportDrivers\Drivers\Http\TradingServiceHttpClient;
use Mmt\TradingServiceSdk\Platforms\MT5\Contracts\MT5TradingServiceInterface;
use Mmt\TradingServiceSdk\Platforms\MT5\Contracts\MT5TradingService;
use Mmt\TradingServiceSdk\TransportDrivers\Contracts\TransportInterface;

class TradingServiceSdkServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/laravel-trading-service-sdk.php',
            'laravel-trading-service-sdk'
        );
        
        $this->app->singleton(TransportInterface::class, TradingServiceHttpClient::class);
        $this->app->singleton(MT5TradingServiceInterface::class, MT5TradingService::class);
        $this->app->singleton(TradingService::class);
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/laravel-trading-service-sdk.php' => config_path('laravel-trading-service-sdk.php'),
            ], 'laravel-trading-service-sdk-config');
        }
    }
}

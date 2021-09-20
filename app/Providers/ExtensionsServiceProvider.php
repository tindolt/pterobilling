<?php

namespace App\Providers;

use Illuminate\Support\AggregateServiceProvider;
use App\Services\Extensions;
use Illuminate\Contracts\Foundation\CachesConfiguration;

class ExtensionsServiceProvider extends AggregateServiceProvider
{
  protected $providers = [];

  /**
   * Register services.
   *
   * @return void
   */
  public function register()
  {
    $this->providers = config('extensions.extensions');
    $this->mergeConfig();

    parent::register();

    $instance = [];

    foreach ($this->providers as $provider) {
      $instance[] = $this->app->resolveProvider($provider);
    }

    $extensions = new Extensions($instance);

    $this->app->instance(Extensions::class, $extensions);
  }

  public function mergeConfig()
  {
    if (!($this->app instanceof CachesConfiguration && $this->app->configurationIsCached())) {
      $config = $this->app->make('config');
      $extensions_config = config('extensions.configs');

      foreach ($extensions_config as $path => $configs) {
        $config->set(
          // Config file
          $path,
          // File content
          array_merge(
            $config->get($path, []),
            $configs
          )
        );
      }
    }
  }
}

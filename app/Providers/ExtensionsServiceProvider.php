<?php

namespace App\Providers;

use Illuminate\Support\AggregateServiceProvider;
use App\Services\Extensions;

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

    parent::register();

    $instance = [];

    foreach ($this->providers as $provider) {
      $instance[] = $this->app->resolveProvider($provider);
    }

    $extensions = new Extensions($instance);

    $this->app->instance(Extensions::class, $extensions);
  }
}

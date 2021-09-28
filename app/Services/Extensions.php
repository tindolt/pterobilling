<?php

namespace App\Services;

use Illuminate\Support\Arr;

class Extensions
{
  protected $instances = [];

  public function __construct(array $instances)
  {
    $this->instances = $instances;
  }

  public function get_scripts()
  {
    $scripts = [];

    foreach ($this->instances as $instance) {
      if (method_exists($instance, 'script_link')) {
        $link = $instance->script_link();
        if (is_array($link)) {
          $scripts = array_merge($scripts, $link);
        } else if (gettype($link) == 'string') {
          $scripts[] = $link;
        }
      }
    }

    return $scripts;
  }

  public function get_styles()
  {
  }

  public function generate_loader()
  {
    $plugins = [];

    foreach ($this->instances as $instance) {
      if (method_exists($instance, 'loading_class')) {
        $plugins[] = 'new window.' . $instance->loading_class() . '();';
      }
    }
    return json_encode([
      'plugins' => $plugins
    ]);
  }
}

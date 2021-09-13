<?php

namespace App\Services;

use Illuminate\Support\HtmlString;

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
        if (gettype($link) == 'string') {
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
    $output_script = 'window.plugins = [';

    foreach ($this->instances as $instance) {
      if (method_exists($instance, 'loading_class')) {
        $output_script .= "\nnew window." . $instance->loading_class() . "()";
      }
    }
    $output_script .= "\n];";
    return $output_script;
  }
}

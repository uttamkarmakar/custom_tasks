<?php

namespace Drupal\dependency_module;

use Drupal\Core\Controller\ControllerBase;

class MyCustomService {

  public function getSum($a, $b)
  {
    return $a + $b;
  }
}

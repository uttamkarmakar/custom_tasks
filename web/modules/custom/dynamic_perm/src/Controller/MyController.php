<?php

namespace Drupal\dynamic_perm\Controller;

use Drupal\Core\Controller\ControllerBase;

class MyController extends ControllerBase {
  public function myMethod() {
    // Implementation of your controller method.
    // You can access this method if the user has the dynamic permission.
    return [
      '#markup' => $this->t('Welcome to MyModule Page.'),
    ];
  }
}

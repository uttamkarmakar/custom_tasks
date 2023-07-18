<?php

namespace Drupal\hello_block\Controller;

use Drupal\Core\Controller\ControllerBase;

class MyController extends ControllerBase
{
  public function myPage() {
    $output = "My page";
    return [
      '#type' => 'markup',
      '#markup' => $output,
    ];
  }
}

<?php

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * This controller helps to display a current user name using it's method
 * 
 * @package Drupal\mymodule\Controller
 * 
 * @author Uttam Karmakar <uttam.karmakar@innoraft.com>
 */
class HelloController extends ControllerBase
{
  /**
   * @method helloMethod
   *  By the help of this method the name of current user will be displayed on
   *  the page
   */
  public function helloMethod()
  {
    $user = $this->currentUser();
    $getUserName = $user->getDisplayName();

    // Create a cache metadata object.
    $cacheMetadata = new \Drupal\Core\Cache\CacheableMetadata();
    $cacheMetadata->setCacheTags(['user:' . $user->id()]);

    return [
      '#markup' => 'Hello ' . $getUserName,
      '#cache' => [
        'tags' => $cacheMetadata->getCacheTags(),
      ],
    ];
  }
}

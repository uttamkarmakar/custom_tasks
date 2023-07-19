<?php

namespace Drupal\mymodule\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * This controller helps to display a current user name using its method.
 *
 * @package Drupal\mymodule\Controller
 */
class HelloController extends ControllerBase
{
  /**
   * The current user service.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $currentUser;

  /**
   * Constructor for HelloController.
   *
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user service.
   */
  public function __construct(AccountInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * Creates a new instance of the HelloController.
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *   The dependency injection container.
   *
   * @return \Drupal\mymodule\Controller\HelloController
   *   The HelloController instance.
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user')
    );
  }


  /**
   * Display the name of the current user on the page.
   *
   * @return array
   *   A renderable array.
   */
  public function helloMethod()
  {
    $user = $this->currentUser;
    $getUserName = $user->getDisplayName();

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


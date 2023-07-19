<?php

namespace Drupal\dynamic_perm;

use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\Entity\User;
use Drupal\Core\Controller\ControllerBase;

/**
 * PermissionProvider Controller helps to provide permissions based on if a user
 * has a permission named "dynamic permission"
 * 
 * @package Drupal\dynamic_perm
 * 
 * @author Uttam Karmakar <uttam.karmakar@innoraft.com>
 */
class PermissionProvider extends ControllerBase {


  /**
   * The current user.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * Constructs a new PermissionProvider object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   * @param \Drupal\Core\Session\AccountProxyInterface $current_user
   *   The current user.
   */
  public function __construct(AccountInterface $current_user) {
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user'),
    );
  }
  
  /**
   * Provides a permission based on a condition on a runtime.
   *  
   * @return array
   *   Returns array of permissions.
   */
  public function dynamicPermissions() {
    $permissions = [];
    $account = $this->currentUser;
    $user = User::load($account->id());

    if ($user->hasPermission('dynamic permission')) {
      // Allow access for "admin" and "content editor" roles.
      $permissions[] = 'access the custom page';
    }

    return $permissions;
  }
}


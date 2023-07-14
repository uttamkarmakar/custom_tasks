<?php

namespace Drupal\dynamic_perm;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;

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
   * @method dynamicPermissions
   *  This method helps to provides a permission based on a condition on a run-
   *  time
   *  
   *  @return array
   *    Returns array of permissions.
   */
  public  function dynamicPermissions() {
    $permissions = [];
    $account = \Drupal::currentUser();
    $user = User::load($account->id());

    if ($user->hasPermission('dynamic permission')) {
      // Allow access for "admin" and "content editor" roles.
      $permissions[] = 'access the custom page';
    }
    return $permissions;
  }
}

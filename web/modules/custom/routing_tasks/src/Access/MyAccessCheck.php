<?php
  namespace Drupal\routing_tasks\Access;

  use Drupal\Core\Routing\Access\AccessInterface;
  use Drupal\Core\Access\AccessResult;
  
  /**
   * This class is used to check the custom access which implements the
   * @Drupal\Core\Routing\Access\AccessInterface
   */
  class MyAccessCheck implements AccessInterface {
    
    /**
     * Callback function for the cusgtom access check
     * 
     * @return AccessResult
     */
    public function access() {
     $user = \Drupal::currentUser();
     if($user->hasPermission('access the custom page')) {
      return AccessResult::allowed();
     }
     return Accessresult::forbidden();
    }
  }
  
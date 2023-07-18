<?php

namespace Drupal\routing_tasks\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Alters existing routes.
 */
class MyRouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    // Alter an existing route and remove the "developer" role from the requirement.
    if ($route = $collection->get('rouitng_tasks.restricted.route')) {
      // dd($route);
      $requirements = $route->getRequirements();
      // dd($requirements);
      // Check if the specific role requirement exists

      if (isset($requirements['_role'])) {
        $roleRequirement = $requirements['_role'];
        // dd($roleRequirement);
        // Split the role requirement string into an array.
        $roles = explode('+', $roleRequirement);
        // dd($roles);
        // Remove the "developer" role from the roles array.
        $roles = array_diff($roles, ['developer']);
        
        // Rebuild the role requirement string.
        $roleRequirement = implode('+', $roles);
     
        // Update the route requirement with the modified role requirement.
        $requirements['_role'] = $roleRequirement;
      } 
      $route->setRequirements($requirements);
    }

    // Altering the path to my-new-path
    if($route = $collection->get('routing_task.new_route')) {
      $route->setPath('my-new-path');
    }
  }
}


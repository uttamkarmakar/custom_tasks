<?php

namespace Drupal\routing_tasks\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for routing system.
 */
class MyRoute extends ControllerBase
{

  /**
   * A simple method to display a markup on the page.
   */
  public function myMethod()
  {

    $user = User::load(\Drupal::currentUser()->id());
    $userName = $user->getDisplayName();
    return [
      '#markup' => 'Welcome to my method ' . $userName,
    ];
  }
  /**
   * dynamic route to display a message in the user/{uid page}
   */

  public function userMessage($uid)
  {
  }

  public function userDetails()
  {
    // Load the user entity based on the provided $uid.
    $uid = \Drupal::currentUser()->id();
    $user = User::load($uid);

    // Check if the user exists.
    if (!$user || !$user->isActive()) {
      // Return a 404 response if the user is not found or not active.
      // return new Response('User not found', Response::HTTP_NOT_FOUND);
      throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
    }

    // Get the user details.
    $username = $user->getDisplayName();
    $email = $user->getEmail();

    // Generate the response with user details.
    $output = 'User ID: ' . $uid . '<br>';
    $output .= 'Username: ' . $username . '<br>';
    $output .= 'Email: ' . $email;

    return [
      '#markup' => $output,
    ];
  }

  public function campaignValues($dynamicValue) {
    return [
      '#markup' => $this->t('Dynamic value from route is @value', ['@value' => $dynamicValue]),
    ];
  }

  public function newRoute() {
    return [
      '#markup' => $this->t('Welcome to new route'),
    ];
  }
}

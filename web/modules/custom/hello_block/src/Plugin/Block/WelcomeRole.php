<?php

namespace Drupal\hello_block\Plugin\Block;


namespace Drupal\hello_block\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Welcome Role Block.
 *
 * @Block(
 *   id = "new_block",
 *   admin_label = @Translation("My Welcome block"),
 *   category = @Translation("Custom block"),
 * )
 */
class WelcomeRole extends BlockBase implements ContainerFactoryPluginInterface
{
  protected $currentUser;

  /**
   * Constructs a new WelcomeRole block.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Session\AccountInterface $current_user
   *   The current user account.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, AccountInterface $current_user)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->currentUser = $current_user;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $userRoles = $this->currentUser->getRoles();
    $userRoleArray = array_diff($userRoles,['authenticated']);
    $userRole = reset($userRoleArray);
    return [
      '#theme' => 'welcome-role',
      '#data' => $userRole,
      '#attached' => [
        'library' => [
          'hello_block/welcome-role-styles',
        ],
      ],
    ];
  }
  
  /**
   * {@inheritdoc}
   */
  protected function blockAccess($current_user)
  {
    if($current_user->isAuthenticated()) {
      return AccessResult::allowed();
    }
    return AccessResult::forbidden();
  }
}

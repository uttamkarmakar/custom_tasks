<?php

namespace Drupal\color_field\Plugin\Field\FieldWidget;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;

abstract class CustomWidgetBase extends WidgetBase implements ContainerFactoryPluginInterface
{

  protected $currentUser;

  public function __construct(
    $plugin_id,
    $plugin_definition,
    FieldDefinitionInterface $field_definition,
    array $settings,
    array $third_party_settings,
    AccountInterface $current_user
  ) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, 
    $settings, $third_party_settings);

    $this->currentUser = $current_user;
  }

  public static function create(ContainerInterface $container,
   array $configuration, $plugin_id, $plugin_definition) {
    return new static (
      $plugin_id,
      $plugin_definition,
      $configuration["field_definition"],
      $configuration["settings"],
      $configuration["third_party_settings"],
      $container->get('current_user')
    );
  }

  protected function isAdmin() {
    return $this->currentUser->hasPermission("administer site configuration");
  }
  
}

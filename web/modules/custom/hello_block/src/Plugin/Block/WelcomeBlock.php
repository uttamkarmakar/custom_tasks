<?php

  namespace Drupal\hello_block\Plugin\Block;

  use Drupal\Core\Block\BlockBase;

  /**
   * Provides welcome block
   * 
   * @Block(
   *  id = "Welcome Block",
   * 
   *  admin_label = @Translation("Welcome Block"),
   * )
   */

   class WelcomeBlock extends BlockBase {
    /**
     * {@inheritdoc}
     */
    public function build() {
      $userName = \Drupal::currentUser()->getDisplayName();
      return [
        '#theme' => 'welcome-block',
        '#data' => $userName,
        '#attached' => [
          'library' => [
            'hello_block/welcome-style',
          ],
        ],
      ];
    }
   }
   
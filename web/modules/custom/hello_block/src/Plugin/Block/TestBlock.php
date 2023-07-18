<?php

  namespace Drupal\hello_block\Plugin\Block;

  use Drupal\Core\Block\BlockBase;

  /**
   * Provides Test Block
   * 
   * @Block(
   * id = "Test Block",
   * 
   * admin_label = @Translation("Test Block"),
   * )
   */
  class TestBlock extends BlockBase {
    
    /**
     * {@inheritdoc}
     */
    public function build() {
      $output = "Hello world! Working....";
      return [
        '#theme' => 'custom-block',
        '#data' => $output,
        '#attached' => [
          'library' => [
            'hello_block/custom-style',
          ],
        ],
      ];
    }
  }
  
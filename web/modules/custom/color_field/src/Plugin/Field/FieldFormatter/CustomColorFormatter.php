<?php

namespace Drupal\color_field\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'custom_color_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "custom_color_formatter",
 *   label = @Translation("Custom Color Code"),
 *   field_types = {
 *     "custom_field"
 *   }
 * )
 */
class CustomColorFormatter extends FormatterBase
{

  /** 
   * {@inheritdoc}
   */

   public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      $color_code = $item->hex_code;
  
      // If hex_code field is present and not empty, use it to display text in the specified color.
      if (!empty($color_code)) {
        $elements += [
          $delta => [
            '#type' => 'html_tag',
            '#tag' => 'div',
            '#attributes' => [
              'style' => 'background-color:' . $color_code . ';font-size:30px',
            ],
            '#value' => 'Text displayed with color ' . $color_code,
          ],
        ];
      } else {
        // If hex_code field is empty, check if RGB values are present and valid.
        $r_value = $item->r;
        $g_value = $item->g;
        $b_value = $item->b;
  
        if ($this->isValidRGBValue($r_value) && $this->isValidRGBValue($g_value)
         && $this->isValidRGBValue($b_value)) {
          // Construct the rgb() color value.
          $rgb_color_code = sprintf('rgb(%d, %d, %d)', $r_value, $g_value, $b_value);
  
          $elements += [
            $delta => [
              '#type' => 'html_tag',
              '#tag' => 'div',
              '#attributes' => [
                'style' => 'color:' . $rgb_color_code . ';font-size:30px',
              ],
              '#value' => 'Text displayed with color ' . $rgb_color_code,
            ],
          ];
        }
      }
    }
    // dd([$delta => $item]);
    return $elements;
  }
  
  /**
   * Helper function to check if an RGB value is valid (between 0 and 255).
   */
  private function isValidRGBValue($value) {
    return is_numeric($value) && $value >= 0 && $value <= 255;
  }
  
}

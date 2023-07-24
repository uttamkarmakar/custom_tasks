<?php

  namespace Drupal\color_field\Plugin\Field\FieldWidget;

  use Drupal\Core\Field\FieldItemListInterface;
  use Drupal\color_field\Plugin\Field\FieldWidget\CustomWidgetBase;
  use Drupal\Core\Field\WidgetBase;
  use Drupal\Core\Form\FormStateInterface;
  
  /**
   * Plugin".
   *
   * @FieldWidget(
   *   id = "color_picker_widget",
   *   label = @Translation("Color Picker Widget"),
   *   field_types = {
   *     "custom_field"
   *   }
   * )
   */
  class ColorPickerWidget extends CustomWidgetBase {

    /**
     * {@inheritdoc}
     */

    public function formElement(FieldItemListInterface $items, $delta, 
    array $element, array &$form, FormStateInterface $form_state) {

      $value = isset($items[$delta]->hex_code) ? $items[$delta]->hex_code : NULL;

      $element['hex_code'] = [
        '#type' => 'color',
        '#title' => 'Pick Color',
        '#default_value' => $value,
      ];
      return $element;
    }
  }
?>

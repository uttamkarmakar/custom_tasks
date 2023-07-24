<?php

  namespace Drupal\color_field\Plugin\Field\FieldWidget;

  use Drupal\Core\Field\FieldItemListInterface;
  use Drupal\color_field\Plugin\Field\FieldWidget\CustomWidgetBase;
  use Drupal\Core\Field\WidgetBase;
  use Drupal\Core\Form\FormStateInterface;

  /**
   * Implementation of rgb_color_widget
   * 
   * @FieldWidget(
   *  
   *  id = "rgb_color_widget",
   *  label = @Translation("RGB color widget"),
   *  field_types = {
   *    "custom_field"
   *  }
   * )
   */
  class RGBColorWidget extends CustomWidgetBase
  {

    public function formElement(FieldItemListInterface $items, $delta, 
    array $element, array &$form, FormStateInterface $form_state)
    {
      $element['r'] = [
        '#type' => 'number',
        '#title' => 'Red',
        '#default_value' => $items[$delta]->r,
        '#min' => 0,
        '#max' => 255,
        '#step' => 1,
        '#placeholder' => $this->t("0 to 255"),
        '#access' => $this->isAdmin(),
      ];

      $element['g'] = [
        '#type' => 'number',
        '#title' => 'Green',
        '#default_value' => $items[$delta]->g,
        '#min' => 0,
        '#max' => 255,
        '#step' => 1,
        '#placeholder' => $this->t("0 to 255"),
        '#access' => $this->isAdmin(),
      ];

      $element['b'] = [
        '#type' => 'number',
        '#title' => 'Blue',
        '#default_value' => $items[$delta]->b,
        '#min' => 0,
        '#max' => 255,
        '#step' => 1,
        '#placeholder' => $this->t("0 to 255"),
        '#access' => $this->isAdmin(),
      ];
      return $element;
    }
  }

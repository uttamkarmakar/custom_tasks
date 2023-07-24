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
 *   id = "hex_color_widget",
 *   label = @Translation("Custom Hex Widget"),
 *   field_types = {
 *     "custom_field"
 *   }
 * )
 */
class HexColorWidget extends CustomWidgetBase
{

  /**
   * {@inheritdoc}
   */
  public function formElement(
    FieldItemListInterface $items,
    $delta,
    array $element,
    array &$form,
    FormStateInterface $form_state
  ) {
    $value = isset($items[$delta]->hex_code) ? $items[$delta]->hex_code : '';

    $element['hex_code'] = [
      '#type' => 'textfield',
      '#title' => $this->t("Hex color"),
      '#default_value' => $value,
      '#placeholder' => $this->getSetting('placeholder'),
      '#element_validate' => [
        [$this, 'validateHexCode']
      ],
    ];
    return $element;
  }

  public function validateHexCode($element, FormStateInterface $form_state)
  {

    $hex_code = $element['#value'];
    if (!preg_match('/^#[0-9A-Fa-f]{6}$/', $hex_code)) {
      $form_state->setError($element, ('Invalid hex code. Please enter a valid 6-digit hex code starting with "#".'));
    }
  }

  public static function defaultSettings()
  {
    return [
      'placeholder' => 'Enter Color..',
    ] + parent::defaultSettings();
  }

  public function settingsForm(array $form, FormStateInterface $form_state)
  {
    $element = parent::settingsForm($form, $form_state);

    $element['placeholder'] = [
      '#type' => 'textfield',
      '#title' => 'placeholder',
      '#default_value' => $this->getSetting('placeholder'),
    ];
    return $element;
  }

  public function settingsSummary()
  {
    $summary = parent::settingsSummary();

    $placeholder = $this->getSetting('placeholder');
    $summary[] = $this->t('Placeholder text is :  @placeholder', ['@placeholder' => $placeholder]);

    return $summary;
  }
}

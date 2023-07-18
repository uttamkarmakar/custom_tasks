<?php

namespace Drupal\myblock\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Provides a Hello Block.
 *
 * @Block(
 *   id = "my_block",
 *   admin_label = @Translation("My block"),
 *   category = @Translation("Custom block"),
 * )
 */
class MyBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * The form builder.
   *
   * @var \Drupal\Core\Form\FormBuilderInterface
   */
  protected $formBuilder;

  /**
   * The configuration factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * Constructs a new MyBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Form\FormBuilderInterface $form_builder
   *   The form builder.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The configuration factory.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, FormBuilderInterface $form_builder, ConfigFactoryInterface $config_factory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->formBuilder = $form_builder;
    $this->configFactory = $config_factory;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('form_builder'),
      $container->get('config.factory'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->configFactory->getEditable('myblock.settings');
    // print_r($config->get());
    $custom_text = $config->get('custom_text');
    $custom_checkbox = $config->get('custom_checkbox');
    $custom_radio = $config->get('custom_radio');

    $content = ['#markup' => $this->t('The custom text is: @text', ['@text' => $custom_text])];
    $content['#markup'] .= '<br>' . $this->t('The custom option is: @option', ['@option' => $custom_radio]);

    if ($custom_checkbox) {
      $content['#markup'] .= '<br>' . $this->t("Custom checkbox is checked");
    } else {
      $content['#markup'] .= '<br>' . $this->t("Custom checkbox is unchecked");
    }

    return $content;
  }


  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->configFactory->getEditable('myblock.settings');

    $form['custom_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Custom text field'),
      '#default_value' => $config->get('custom_text'),
    ];

    $form['custom_checkbox'] = [
      '#type' => 'checkbox',
      '#title' => $this->t("Custom checkbox"),
      '#default_value' => $config->get('custom_checkbox'),
    ];

    $form['custom_radio'] = [
      '#type' => 'radios',
      '#title' => $this->t("Custom radio button"),
      '#options' => [
        'option1' => $this->t("Option 1"),
        'option2' => $this->t("Option 2"),
        'option3' => $this->t("Option 3"),
      ],
      '#default_value' => $config->get('custom_radio'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $config = $this->configFactory->getEditable('myblock.settings');
    $config->set('custom_text', $form_state->getValue('custom_text'))
      ->set('custom_checkbox', $form_state->getValue('custom_checkbox'))
      ->set('custom_radio', $form_state->getValue('custom_radio'))
      ->save();
  }
}

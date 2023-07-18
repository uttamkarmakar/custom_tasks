<?php

  namespace Drupal\hello_block\Plugin\Block;

  use Drupal\Core\Block\BlockBase;
  use Drupal\Core\Form\FormStateInterface;

  /**
   * Provides a Hello Block
   * 
   * @Block(
   *  id = "hello_block",
   *  admin_label = @Translation("A Hello block"),
   *  category = @Translation("Custom block"),
   * )
   */

   class HelloWorldBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */

    public function build() {
      $config = $this->getConfiguration();
      // var_dump(($config));
      $custom_text = $config['custom_text'];
      $custom_checkbox = $config['custom_checkbox'];
      $custom_option = $config['custom_radio'];
      
      $content = ['#markup' => $this->t('The custom text is : @text',['@text' => $custom_text])];
      $content['#markup'] .= '<br>' .$this->t('The custom option is : @option',['@option' => $custom_option]);

      if($custom_checkbox) {
        $content['#markup'] .= '<br>' .$this->t("Custom checkbox is checked");
      }
      else{
        $content['#markup'] .= '<br>' .$this->t("Custom checkbox is unchecked");
      }
      return $content;
     }

     /**
      * {@inheritdoc}
      */
    public function defaultConfiguration() {

        return [
          'custom_text' => '',
          'custom_checkbox' => FALSE,
          'custom_radio' => 'Option 1',
        ];
      }
    /**
     * {@inheritdoc}
     */
    public function blockForm($form,FormStateInterface $form_state) {
      $config = $this->getConfiguration();

      $form['custom_text'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Custom text field'),
        '#default_value' => $config['custom_text'],
      ];

      $form['custom_checkbox'] = [
        '#type' => 'checkbox',
        '#title' => $this->t("Custom checkbox"),
        '#default_value' => $config['custom_checkbox'],
      ];

      $form['custom_radio'] = [
        '#type' => 'radios',
        '#title' => $this->t("Custom radio button"),
        '#options' => [
          'option1' => $this->t("Option 1"),~
          'option2' => $this->t("Option 2"),
          'option3' => $this->t("Option 3"),
        ],
      ];
      return $form;
    }

    /**
     * {@inheritdoc}
     */

     public function blockSubmit($form, FormStateInterface $form_state)
     {
      $this->setConfigurationValue('custom_text',$form_state->getValue('custom_text'));
      $this->setConfigurationValue('custom_checkbox',$form_state->getValue('custom_checkbox'));
      $this->setConfigurationValue('custom_radio',$form_state->getValue('custom_radio'));
     }
   }